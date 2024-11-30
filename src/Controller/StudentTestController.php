<?php

namespace App\Controller;

use App\Entity\Test;
use App\Entity\StudentTest;
use App\Form\StudentTestFormType;
use App\Form\TestFormType;
use App\Repository\StudentsRepository;
use App\Repository\StudentTestRepository;
use App\Repository\TestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;

class StudentTestController extends AbstractController
{

    private $testRepository;
    private $em;

    private $studentTestRepository;

    private $studentsRepository;

    public function __construct(StudentsRepository $studentsRepository, TestRepository $testRepository, EntityManagerInterface $em, StudentTestRepository $studentTestRepository) {
        $this->testRepository = $testRepository;
        $this->em = $em;
        $this->studentTestRepository = $studentTestRepository;
        $this->studentsRepository = $studentsRepository;
    }

    #[Route('/seeskills/{testid}', methods: ["GET"], name: 'see_skills')]
    public function seeSkills(int $testid): Response {

        /* retrives info about the test */
        $testInfo = $this->testRepository->findOneBy(['id' => $testid]);
        if (!$testInfo) {
            throw $this->createNotFoundException('Test not found');
        }

        $studentData = $this->studentTestRepository->findByTestOrderedByStudentLastname($testid);

        // Initialize skill visibility flags
        $showSkill1 = false;
        $showSkill2 = false;
        $showSkill3 = false;
        $showSkill4 = false;
        $showSkill5 = false;

        // Check if any student has a non-zero value for each skill
        foreach ($studentData as $studentTest) {
            if ($studentTest->getSkill1() != 0) $showSkill1 = true;
            if ($studentTest->getSkill2() != 0) $showSkill2 = true;
            if ($studentTest->getSkill3() != 0) $showSkill3 = true;
            if ($studentTest->getSkill4() != 0) $showSkill4 = true;
            if ($studentTest->getSkill5() != 0) $showSkill5 = true;
        }

        return $this->render('studenttest/show.html.twig', [
            'testInfo' => $testInfo,
            'students' => $studentData,
            'showSkill1' => $showSkill1,
            'showSkill2' => $showSkill2,
            'showSkill3' => $showSkill3,
            'showSkill4' => $showSkill4,
            'showSkill5' => $showSkill5,
        ]);
        
        
    }

    #[Route('/addtestskills/test={testid}', methods: ['GET', 'POST'], name: 'new_add_skills')]
    public function addTestSkills($testid): Response
    {
         
        // Fetch test info for rendering
        $testInfo = $this->testRepository->find($testid);

        // Fetch the Students from the class concerned with the test
        $students = $this->studentsRepository->findBy([
            'schoolclass' => $testInfo->getSchoolclass()], ['lastname' => 'ASC']
        );

        // Check for existing StudentTest entries

        $studentTests = $this->studentTestRepository->findByTestOrderedByStudentLastname($testid);

         // Check if any StudentTest entries exist
         if (!$studentTests) {
            // Create StudentTest entries for each student if none exist

            foreach ($students as $student) {
                    $studentTest = new StudentTest();
                    $studentTest->setStudent($student);
                    $studentTest->setTest($testInfo);
    
                    $this->em->persist($studentTest);
                }

                $this->em->flush();

                // Refetch the student tests after they are created
                $studentTests = $this->studentTestRepository->findBy([
                'test' => $testid]);

                $skill1Avg = $skill2Avg = $skill3Avg = $skill4Avg = $skill5Avg = 0;
                
        } else {

            // handling average
            $skill1 = $skill2 = $skill3 = $skill4 = $skill5 = 0;

            foreach ($studentTests as $test) {
                $skill1 += $test->getSkill1();
                $skill2 += $test->getSkill2();
                $skill3 += $test->getSkill3();
                $skill4 += $test->getSkill4();
                $skill5 += $test->getSkill5();
            }

            // Check if there are any tests to avoid division by zero
            $studentCount = count($studentTests);
            if ($studentCount > 0) {
                $skill1Avg = $skill1 / $studentCount;
                $skill2Avg = $skill2 / $studentCount;
                $skill3Avg = $skill3 / $studentCount;
                $skill4Avg = $skill4 / $studentCount;
                $skill5Avg = $skill5 / $studentCount;
            } else {
                // Handle the case when there are no student tests
                $skill1Avg = $skill2Avg = $skill3Avg = $skill4Avg = $skill5Avg = 0;
            }

       
            // Extract student IDs from the existing StudentTest entries
            $studentTestIds = array_map(function($studentTest) {
                return $studentTest->getStudent()->getId();
            }, $studentTests);

            // Check if each student has an existing StudentTest entry
            foreach ($students as $student) {
                if (!in_array($student->getId(), $studentTestIds)) {
                    var_dump("No test entry for student with ID: " . $student->getId());
                    $studentTest = new StudentTest();
                    $studentTest->setStudent($student);
                    $studentTest->setTest($testInfo);

                    $this->em->persist($studentTest);
                }
            }

            // Flush the changes to the database
            $this->em->flush();
        }

        return $this->render('studenttest/addSkillsForAll.html.twig', [
            'testInfo' => $testInfo,
            'studentTests' => $studentTests,
            'students' => $students,
            'skill1Avg' => $skill1Avg,
            'skill2Avg' => $skill2Avg,
            'skill3Avg' => $skill3Avg,
            'skill4Avg' => $skill4Avg,
            'skill5Avg' => $skill5Avg,

        ]);
    }

    /* update all the skills for every student in the class concerned by the given test */

    #[Route('/update-student-tests/{testid}', methods: ['POST'], name: 'app_update_student_tests')]
    public function updateTestSkills(Request $request, $testid): Response
    {
        $data = $request->get('studentTests');

        foreach ($data as $id => $fields) {
            $studentTest = $this->em->getRepository(StudentTest::class)->find($id);

            if (!$studentTest) {
                continue; // Skip if the student test is not found
            }

            if (isset($fields['skill1'])) {
                $studentTest->setSkill1((float)$fields['skill1']);
            }
            if (isset($fields['skill2'])) {
                $studentTest->setSkill2((float)$fields['skill2']);
            }
            if (isset($fields['skill3'])) {
                $studentTest->setSkill3((float)$fields['skill3']);
            }
            if (isset($fields['skill4'])) {
                $studentTest->setSkill4((float)$fields['skill4']);
            }
            if (isset($fields['skill5'])) {
                $studentTest->setSkill5((float)$fields['skill5']);
            }
            if (isset($fields['mark'])) {
                $studentTest->setMark((float)$fields['mark']);
            }

            $this->em->persist($studentTest);
        }

        $this->em->flush();

        $this->addFlash('success', 'Mise à jour effectuée !');

        return $this->redirectToRoute('see_skills', ['testid' => $testid]);
    
    }

}