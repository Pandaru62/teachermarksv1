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

        function isDarkBackground($hexColor) {
            // Remove the '#' if present
            $hexColor = str_replace('#', '', $hexColor);
        
            // Convert hex to RGB
            $r = hexdec(substr($hexColor, 0, 2));
            $g = hexdec(substr($hexColor, 2, 2));
            $b = hexdec(substr($hexColor, 4, 2));
        
            // Calculate luminance
            $luminance = ($r * 0.299 + $g * 0.587 + $b * 0.114);
        
            // Return true if the background is dark (luminance < 128)
            return $luminance < 128;
        }
    

        $isDarkBackground = isDarkBackground($selectedClass->getColor());

        return $this->render('class/showsingle.html.twig', [
            'students' => $students,
            'selectedClass' => $selectedClass,
            'isDarkBackground' => $isDarkBackground,
        ]);
    }


}
