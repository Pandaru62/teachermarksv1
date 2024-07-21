<?php

namespace App\Entity;

use App\Repository\StudentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Schoolclass;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: StudentsRepository::class)]
class Students
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Au moins {{ limit }} caractères requis',
        maxMessage: 'Vous dépassez la limite de {{ limit }} caractères',
    )]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Au moins {{ limit }} caractères requis',
        maxMessage: 'Vous dépassez la limite de {{ limit }} caractères',
    )]
    private ?string $firstname = null;

    #[ORM\ManyToOne(targetEntity: Schoolclass::class, inversedBy: 'students')]
    #[ORM\JoinColumn(name: 'class_id', referencedColumnName: 'id', nullable: false)]
    private ?Schoolclass $schoolclass = null;

    #[ORM\OneToMany(targetEntity: StudentTest::class, mappedBy: 'student', orphanRemoval: true)]
    private Collection $studentTests;

    public function __construct()
    {
        $this->studentTests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getSchoolclass(): ?Schoolclass
    {
        return $this->schoolclass;
    }

    public function setSchoolclass(?Schoolclass $schoolclass): static
    {
        $this->schoolclass = $schoolclass;

        return $this;
    }

    /**
     * @return Collection<int, StudentTest>
     */
    public function getStudentTests(): Collection
    {
        return $this->studentTests;
    }

    public function addStudentTest(StudentTest $studentTest): static
    {
        if (!$this->studentTests->contains($studentTest)) {
            $this->studentTests->add($studentTest);
            $studentTest->setStudent($this);
        }

        return $this;
    }

    public function removeStudentTest(StudentTest $studentTest): static
    {
        if ($this->studentTests->removeElement($studentTest)) {
            // set the owning side to null (unless already changed)
            if ($studentTest->getStudent() === $this) {
                $studentTest->setStudent(null);
            }
        }

        return $this;
    }
}
