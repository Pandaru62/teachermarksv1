<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use App\Repository\SchoolclassRepository;
use App\Repository\StudentsRepository;
use Symfony\Bundle\SecurityBundle\Security;

class AppExtension extends AbstractExtension
{
    private $schoolclassRepository;
    private $studentsRepository;
    private $security;

    public function __construct(
        SchoolclassRepository $schoolclassRepository,
        StudentsRepository $studentsRepository,
        Security $security
    ) {
        $this->schoolclassRepository = $schoolclassRepository;
        $this->studentsRepository = $studentsRepository;
        $this->security = $security;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getHeaderData', [$this, 'getHeaderData']),
        ];
    }

    public function getHeaderData(): array
    {
        if (!$this->security->getUser()) {
            return [];
        }

        $students = $this->studentsRepository->findAll();

        $studentsData = [];

        foreach ($students as $student) {
            $studentsData[] = [
                'id' => $student->getId(),
                'firstname' => $student->getFirstname(),
                'lastname' => $student->getLastname(),
                'class' => $student->getSchoolclass()->getName(),
            ];
        }

        $classes = $this->schoolclassRepository->findBy([
            'isArchived' => 0
            ]);

        return [
            'students' => $studentsData,
            'classes' => $classes,
        ];
    }
}
