<?php

namespace App\Controller;

use App\Entity\Schoolclass;
use App\Entity\Students;
use App\Repository\SchoolclassRepository;
use App\Repository\StudentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowClassController extends AbstractController
{
    private $studentsRepository;
    private $schoolclassRepository;

    public function __construct(StudentsRepository $studentsRepository, SchoolclassRepository $schoolclassRepository) {
        $this->studentsRepository = $studentsRepository;
        $this->schoolclassRepository = $schoolclassRepository;
    }

    #[Route('/class/{classid}', name: 'showClass', methods: ['GET'])]
    public function show(int $classid): Response
    {
        $students = $this->studentsRepository->findBy(['schoolclass' => $classid], ['lastname' => 'ASC']);
        $selectedClass = $this->schoolclassRepository->find($classid);

        return $this->render('class/showsingle.html.twig', [
            'students' => $students,
            'selectedClass' => $selectedClass,
        ]);
    }
}
