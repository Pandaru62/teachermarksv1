<?php

namespace App\Entity;

use App\Repository\TestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestRepository::class)]
class Test
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?int $trimester = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $scale = null;

    #[ORM\Column]
    private ?int $coefficient = null;

    #[ORM\ManyToOne(targetEntity: Schoolclass::class, inversedBy: 'tests')]
    #[ORM\JoinColumn(name: 'schoolclass_id', referencedColumnName: 'id', nullable: false)]
    private ?Schoolclass $schoolclass = null;

    #[ORM\OneToMany(targetEntity: StudentTest::class, mappedBy: 'test', orphanRemoval: true)]
    private Collection $studentTests;

    public function __construct()
    {
        $this->studentTests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getTrimester(): ?int
    {
        return $this->trimester;
    }

    public function setTrimester(int $trimester): static
    {
        $this->trimester = $trimester;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getScale(): ?int
    {
        return $this->scale;
    }

    public function setScale(int $scale): static
    {
        $this->scale = $scale;

        return $this;
    }

    public function getCoefficient(): ?int
    {
        return $this->coefficient;
    }

    public function setCoefficient(int $coefficient): static
    {
        $this->coefficient = $coefficient;

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
            $studentTest->setTest($this);
        }

        return $this;
    }

    public function removeStudentTest(StudentTest $studentTest): static
    {
        if ($this->studentTests->removeElement($studentTest)) {
            // set the owning side to null (unless already changed)
            if ($studentTest->getTest() === $this) {
                $studentTest->setTest(null);
            }
        }

        return $this;
    }
}
