<?php

namespace App\Entity;

use App\Entity\Test;
use App\Repository\StudentTestRepository;
use Doctrine\DBAL\Types\DecimalType;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentTestRepository::class)]
class StudentTest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Students::class, inversedBy: 'studentTests')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Students $student = null;

    #[ORM\ManyToOne(targetEntity: Test::class, inversedBy: 'studentTests')]
    #[ORM\JoinColumn(name: 'test_id', referencedColumnName: 'id', nullable: false)]    private ?Test $test = null;

    #[ORM\Column(type: 'decimal', precision: 2, scale: 2, nullable: true)]
    private ?string $mark = null;

    #[ORM\Column(nullable: true)]
    private ?int $skill1 = null;

    #[ORM\Column(nullable: true)]
    private ?int $skill2 = null;

    #[ORM\Column(nullable: true)]
    private ?int $skill3 = null;

    #[ORM\Column(nullable: true)]
    private ?int $skill4 = null;

    #[ORM\Column(nullable: true)]
    private ?int $skill5 = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudent(): ?Students
    {
        return $this->student;
    }

    public function setStudent(?Students $student): static
    {
        $this->student = $student;

        return $this;
    }

    public function getTest(): ?Test
    {
        return $this->test;
    }

    public function setTest(?Test $test): static
    {
        $this->test = $test;

        return $this;
    }

    public function getMark(): ?int
    {
        return $this->mark;
    }

    public function setMark(int $mark): static
    {
        $this->mark = $mark;

        return $this;
    }

    public function getSkill1(): ?int
    {
        return $this->skill1;
    }

    public function setSkill1(?int $skill1): static
    {
        $this->skill1 = $skill1;

        return $this;
    }

    public function getSkill2(): ?int
    {
        return $this->skill2;
    }

    public function setSkill2(?int $skill2): static
    {
        $this->skill2 = $skill2;

        return $this;
    }

    public function getSkill3(): ?int
    {
        return $this->skill3;
    }

    public function setSkill3(?int $skill3): static
    {
        $this->skill3 = $skill3;

        return $this;
    }

    public function getSkill4(): ?int
    {
        return $this->skill4;
    }

    public function setSkill4(?int $skill4): static
    {
        $this->skill4 = $skill4;

        return $this;
    }

    public function getSkill5(): ?int
    {
        return $this->skill5;
    }

    public function setSkill5(?int $skill5): static
    {
        $this->skill5 = $skill5;

        return $this;
    }
}
