<?php

namespace App\Controller;

use App\Entity\Students;
use App\Form\StudentFormType;
use App\Entity\Test;
use App\Repository\TestRepository;
use App\Entity\StudentTest;
use App\Repository\StudentsRepository;
use App\Repository\StudentTestRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Psr\Log\LoggerInterface;
// use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
// use Symfony\UX\Chartjs\Model\Chart;

class StudentController extends AbstractController
{

    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    #[Route('/addstudent', name: 'add_student')]
    public function create(Request $request): Response
    {

        $newStudent = new Students();
        $form = $this->createForm(StudentFormType::class, $newStudent);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newStudent = $form->getData();

            $this->em->persist($newStudent);
            $this->em->flush();

            return $this->redirectToRoute('app_class');

        }


        return $this->render('student/addstudents.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/showstudent{studentid}', name: 'app_student')]
    public function show($studentid): Response
    {
        // get the student from the given id
        $studentrepo=$this->em->getRepository(Students::class);
        $showStudent= $studentrepo->find($studentid);

        // get the student's class to access the list of students in the same class
        $studentClassId = $showStudent->getSchoolclass()->getId();
        $students = $this->em->getRepository(Students::class)->findBy(['schoolclass' => $studentClassId], ['lastname' => 'ASC']);

        $studentsInTheClass = [];
        $selectedStudent = null;
        
        foreach ($students as $key => $student) {
            $studentData = [
                'id' => $student->getId(),
                'lastname' => $student->getLastname(),
                'firstname' => $student->getFirstname()
            ];
        
            $studentsInTheClass[] = $studentData;
        
            if ($studentData['id'] == $studentid) {
                $selectedStudent = $studentData;
                $selectedStudentKeyData = $key;
            }
        }
        
        if ($selectedStudentKeyData +1 > count($studentsInTheClass)-1) {
            $nextStudent = $studentsInTheClass[array_key_first($studentsInTheClass)];
        } else {
            $nextStudent = $studentsInTheClass[$selectedStudentKeyData +1];
        }

        if ($selectedStudentKeyData -1 < 0) {
            $previousStudent = $studentsInTheClass[array_key_last($studentsInTheClass)];
        } else {
            $previousStudent = $studentsInTheClass[$selectedStudentKeyData -1];
        }


        $repository = $this->em->getRepository(StudentTest::class);
        $studentTests = $repository->findBy(['student' => $studentid]);

        $averageStudentTest = [];
        $trimesterData = [];

        // Organize StudentTests by trimester
        foreach ($studentTests as $studentTest) {
            $trimester = $studentTest->getTest()->getTrimester();
            
            if (!isset($trimesterData[$trimester])) {
                $trimesterData[$trimester] = [
                    'skill1' => [],
                    'skill2' => [],
                    'skill3' => [],
                    'skill4' => [],
                    'skill5' => [],
                ];
            }
            
            if ($studentTest->getSkill1() !== null) {
                $trimesterData[$trimester]['skill1'][] = $studentTest->getSkill1();
            }
            if ($studentTest->getSkill2() !== null) {
                $trimesterData[$trimester]['skill2'][] = $studentTest->getSkill2();
            }
            if ($studentTest->getSkill3() !== null) {
                $trimesterData[$trimester]['skill3'][] = $studentTest->getSkill3();
            }
            if ($studentTest->getSkill4() !== null) {
                $trimesterData[$trimester]['skill4'][] = $studentTest->getSkill4();
            }
            if ($studentTest->getSkill5() !== null) {
                $trimesterData[$trimester]['skill5'][] = $studentTest->getSkill5();
            }
        }

        // Calculate averages for each trimester and each skill
        foreach ($trimesterData as $trimester => $skills) {
            $averageStudentTest[$trimester] = [
                'skill1' => count($skills['skill1']) > 0 ? round(array_sum($skills['skill1']) / count($skills['skill1']), 1) : null,
                'skill2' => count($skills['skill2']) > 0 ? round(array_sum($skills['skill2']) / count($skills['skill2']), 1) : null,
                'skill3' => count($skills['skill3']) > 0 ? round(array_sum($skills['skill3']) / count($skills['skill3']), 1) : null,
                'skill4' => count($skills['skill4']) > 0 ? round(array_sum($skills['skill4']) / count($skills['skill4']), 1) : null,
                'skill5' => count($skills['skill5']) > 0 ? round(array_sum($skills['skill5']) / count($skills['skill5']), 1) : null,
            ];
        }

            
        // Calculate overall yearly averages, excluding null values
        $yearlySkills = [
            'skill1' => [],
            'skill2' => [],
            'skill3' => [],
            'skill4' => [],
            'skill5' => [],
        ];

        foreach ($averageStudentTest as $trimester => $skills) {
            if ($skills['skill1'] !== null) {
                $yearlySkills['skill1'][] = $skills['skill1'];
            }
            if ($skills['skill2'] !== null) {
                $yearlySkills['skill2'][] = $skills['skill2'];
            }
            if ($skills['skill3'] !== null) {
                $yearlySkills['skill3'][] = $skills['skill3'];
            }
            if ($skills['skill4'] !== null) {
                $yearlySkills['skill4'][] = $skills['skill4'];
            }
            if ($skills['skill5'] !== null) {
                $yearlySkills['skill5'][] = $skills['skill5'];
            }
        }

        $averageStudentTest['year'] = [
            'skill1' => count($yearlySkills['skill1']) > 0 ? round(array_sum($yearlySkills['skill1']) / count($yearlySkills['skill1']), 1) : null,
            'skill2' => count($yearlySkills['skill2']) > 0 ? round(array_sum($yearlySkills['skill2']) / count($yearlySkills['skill2']), 1) : null,
            'skill3' => count($yearlySkills['skill3']) > 0 ? round(array_sum($yearlySkills['skill3']) / count($yearlySkills['skill3']), 1) : null,
            'skill4' => count($yearlySkills['skill4']) > 0 ? round(array_sum($yearlySkills['skill4']) / count($yearlySkills['skill4']), 1) : null,
            'skill5' => count($yearlySkills['skill5']) > 0 ? round(array_sum($yearlySkills['skill5']) / count($yearlySkills['skill5']), 1) : null,
        ];

        // getting the chart

        // $chart = $chartBuilder->createChart(Chart::TYPE_RADAR);

        // $labels = ['year', 1, 2, 3];
        // $colors = [
        //     'rgba(255, 99, 132, 0.2)' => 'rgb(255, 99, 132)',
        //     'rgba(72, 143, 51, 0.2)' => 'rgb(72, 143, 51)',
        //     'rgba(88, 74, 213, 0.2)' => 'rgb(88, 74, 213)',
        //     'rgba(255, 219, 39, 0.2)' => 'rgb(255, 219, 39)',
        // ];
        // $datasetLabels = [
        //     'year' => 'Récap annuel',
        //     1 => 'Trimestre 1',
        //     2 => 'Trimestre 2',
        //     3 => 'Trimestre 3'
        // ];

        // $datasets = [];
        // $i = 0;
        // foreach ($labels as $label) {
        //     if (isset($averageStudentTest[$label])) {
        //         $datasets[] = [
        //             'label' => $datasetLabels[$label],
        //             'fill' => true,
        //             'backgroundColor' => array_keys($colors)[$i],
        //             'borderColor' => array_values($colors)[$i],
        //             'data' => array_values($averageStudentTest[$label]),
        //             'hidden' => $i !== 0 // only the first dataset is visible initially
        //         ];

        //     }

        //     $i++;
        // }

        // $chart->setData([
        //     'labels' => ['Lecture', 'Connaissances', 'Argumentation', 'Ecrit', 'Oral'],
        //     'datasets' => $datasets
        // ]);

        // $chart->setOptions([
        //     'scales' => [
        //         'r' => [
        //             'angleLines' => [
        //                 'display' => false
        //             ],
        //             'suggestedMin' => 0,
        //             'suggestedMax' => 4
        //         ]
        //     ]
        // ]);

    $labels = ['year', 1, 2, 3];
    $colors = [
        'rgba(255, 99, 132, 0.2)' => 'rgb(255, 99, 132)',
        'rgba(72, 143, 51, 0.2)' => 'rgb(72, 143, 51)',
        'rgba(88, 74, 213, 0.2)' => 'rgb(88, 74, 213)',
        'rgba(255, 219, 39, 0.2)' => 'rgb(255, 219, 39)',
    ];
    $datasetLabels = [
        'year' => 'Récap annuel',
        1 => 'Trimestre 1',
        2 => 'Trimestre 2',
        3 => 'Trimestre 3'
    ];

    $datasets = [];
    $i = 0;
    foreach ($labels as $label) {
        if (isset($averageStudentTest[$label])) {
            $datasets[] = [
                'label' => $datasetLabels[$label],
                'fill' => true,
                'backgroundColor' => array_keys($colors)[$i],
                'borderColor' => array_values($colors)[$i],
                'data' => array_values($averageStudentTest[$label]),
                'hidden' => $i !== 0 // only the first dataset is visible initially
            ];
        }
        $i++;
    }

    $chartData = [
        'labels' => ['Lecture', 'Connaissances', 'Argumentation', 'Ecrit', 'Oral'],
        'datasets' => $datasets
    ];

    $chartOptions = [
        'scales' => [
            'r' => [
                'angleLines' => [
                    'display' => false
                ],
                'suggestedMin' => 0,
                'suggestedMax' => 4
            ]
        ]
    ];

        return $this->render('student/showstudent.html.twig', [
            'student' => $showStudent,
            'studentTests' => $studentTests,
            'studentsInTheClass' => $studentsInTheClass,
            'selectedStudent' => $selectedStudent,
            'previousStudent' => $previousStudent,
            'nextStudent' => $nextStudent,
            'averageStudentTest' => $averageStudentTest,
            // 'chart' => $chart,
            'chartData' => json_encode($chartData),
            'chartOptions' => json_encode($chartOptions)
        ]);
    }

        #[Route('/editstudent/{studentid}', methods: ['GET', 'POST'], name: 'edit_student')]
        public function editStudent(int $studentid, Request $request): Response
        {
            $student = $this->em->getRepository(Students::class)->find($studentid);
            
            if (!$student) {
                throw $this->createNotFoundException('Aucun élève n\'a été trouvé avec l\'id ' . $studentid);
            }
    
            $form = $this->createForm(StudentFormType::class, $student);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                $this->em->flush();
                return $this->redirectToRoute('app_class');
            }
    
            return $this->render('student/editstudent.html.twig', [
                'student' => $student,
                'form' => $form->createView()
            ]);
        }

        #[Route('/deletestudent/{studentid}', methods: ['GET', 'DELETE'], name: 'delete_student')]
        public function deleteStudent(int $studentid): Response
        {
            $student = $this->em->getRepository(Students::class)->find($studentid);
            $this->em->remove($student);
            $this->em->flush();

            return $this->redirectToRoute('app_class');
        }
    }
    



