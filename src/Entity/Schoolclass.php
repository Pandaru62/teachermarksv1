<?php

namespace App\Entity;

use App\Repository\SchoolclassRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: SchoolclassRepository::class)]
class Schoolclass
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 2,
        max: 25,
        minMessage: 'Au moins {{ limit }} caractères requis',
        maxMessage: 'Vous dépassez la limite de {{ limit }} caractères',
    )]
    private ?string $name = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 2,
        max: 25,
        minMessage: 'Au moins {{ limit }} caractères requis',
        maxMessage: 'Vous dépassez la limite de {{ limit }} caractères',
    )]
    private ?string $color = null;

    #[ORM\Column(type: 'boolean')]
    private ?bool $isArchived = null;

    #[ORM\ManyToOne(targetEntity: Form::class)]
    #[ORM\JoinColumn(name: 'form_id', referencedColumnName: 'id', nullable: false)]
    private ?Form $form = null;

    #[ORM\OneToMany(mappedBy: 'schoolclass', targetEntity: Students::class)]
    private Collection $students;

    #[ORM\OneToMany(mappedBy: 'schoolclass', targetEntity: Test::class)]
    private Collection $tests;

    public function __construct()
    {
        $this->students = new ArrayCollection();
        $this->tests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getIsArchived(): ?bool
    {
        return $this->isArchived;
    }

    public function setIsArchived(bool $isArchived): static
    {
        $this->isArchived = $isArchived;

        return $this;
    }

    public function getForm(): ?Form
    {
        return $this->form;
    }

    public function setForm(?Form $form): static
    {
        $this->form = $form;

        return $this;
    }

    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function getTests(): Collection
    {
        return $this->tests;
    }

    public function addTest(Test $test): static
    {
        if (!$this->tests->contains($test)) {
            $this->tests->add($test);
            $test->setSchoolclass($this);
        }

        return $this;
    }

    public function removeTest(Test $test): static
    {
        if ($this->tests->removeElement($test)) {
            // set the owning side to null (unless already changed)
            if ($test->getSchoolclass() === $this) {
                $test->setSchoolclass(null);
            }
        }

        return $this;
    }
}
