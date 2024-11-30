<?php
namespace App\Controller;

use App\Repository\SchoolclassRepository;
use App\Repository\StudentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HeaderController extends AbstractController
{
        private $studentsRepository;
        private $schoolclassRepository;

        public function __construct(StudentsRepository $studentsRepository, SchoolclassRepository $schoolclassRepository) {
                $this->studentsRepository = $studentsRepository;
                $this->schoolclassRepository = $schoolclassRepository;
        }

        public function headerData(): array
        {

                $students = $this->studentsRepository->findAll();
                $classes = $this->schoolclassRepository->findAll();

                return [
                        'students' => $students,
                        'classes' => $classes,
                ];

        }
}
