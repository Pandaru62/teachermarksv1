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
        $testInfo = $this->testRepository->findOneBy(['id' => $testid]);
        if (!$testInfo) {
            throw $this->createNotFoundException('Test not found');
        }

        $classId = $testInfo->getSchoolclass()->getId();
        $students = $this->studentsRepository->findBy(['schoolclass' => $classId], ['lastname' => 'ASC']);
        
        $studentData = [];

        foreach ($students as $student) {
            $studentResults = $this->studentTestRepository->findBy(['student' => $student->getId(), 'test' => $testid]);

            $skills = ['skill1', 'skill2', 'skill3', 'skill4', 'skill5'];
            $studentSkills = [];

            foreach ($skills as $skill) {
                $studentSkills[$skill] = !empty($studentResults) && !empty($studentResults[0]->{'get' . ucfirst($skill)}())
                    ? $studentResults[0]->{'get' . ucfirst($skill)}()
                    : 'x';
            }

            $mark = !empty($studentResults) ? $studentResults[0]->getMark() : 'x';

            $studentData[] = [
                'student' => $student,
                'skills' => $studentSkills,
                'mark' => $mark,
            ];
        }
        return $this->render('studenttest/show.html.twig', [
            'testInfo' => $testInfo,
            'students' => $studentData,
        ]);
    }
    
    #[Route('/addskills/test={testid}/student={studentid}', methods: ['GET', 'POST'], name: 'old_add_skills')]
    public function addSkills(Request $request, $testid, $studentid): Response
    {
        // Fetch the Students entity
        $student = $this->studentsRepository->find($studentid);
        // Fetch the Test entity
        $test = $this->testRepository->find($testid);

        // Check if student and test are valid
        if (!$student || !$test) {
            throw $this->createNotFoundException('Student or Test not found');
        }

        // Check for existing StudentTest entry
        $studentTest = $this->studentTestRepository->findOneBy([
            'student' => $student,
            'test' => $test,
        ]);

        // If no existing entry is found, create a new one
        if (!$studentTest) {
            $studentTest = new StudentTest();
            $studentTest->setStudent($student);
            $studentTest->setTest($test);
        }

        // Create the form and handle the request
        $form = $this->createForm(StudentTestFormType::class, $studentTest);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $studentTest = $form->getData();

            $this->em->persist($studentTest);
            $this->em->flush();

            return $this->redirectToRoute('see_skills', ['testid' => $testid]);
        }

        // Fetch test info for rendering (if needed)
        $testInfo = $this->testRepository->findOneBy(['id' => $testid]);

        // Render the form with existing data if any
        return $this->render('studenttest/add.html.twig', [
            'form' => $form->createView(),
            'testInfo' => $testInfo,
            'student' => $student,
        ]);
    }

    

}

    

