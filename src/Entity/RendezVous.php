<?php

namespace App\Entity;

use App\Repository\RendezVousRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=RendezVousRepository::class)
 */
class RendezVous
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Champs Obligatoire")
     */
    private $nomRDV;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Champs Obligatoire")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(message="Champs Obligatoire")
     */
    private $dateRDV;



    /**
     * @ORM\OneToMany(targetEntity=Patient::class, mappedBy="rendezVous",cascade={"persist"})
     * @Assert\NotBlank(message="Champs Obligatoire")
     */
    private $patient;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="rendezVous",cascade={"persist"})
     * @Assert\NotBlank(message="Champs Obligatoire")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Planning::class, inversedBy="renders",cascade={"persist"})
     * @ORM\JoinColumn(nullable = true)
     */
    private $plannings;

    public function __construct()
    {
        $this->patient = new ArrayCollection();
        $this->user = new ArrayCollection();
        $this->plannings = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomRDV(): ?string
    {
        return $this->nomRDV;
    }

    public function setNomRDV(string $nomRDV): self
    {
        $this->nomRDV = $nomRDV;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateRDV(): ?\DateTimeInterface
    {
        return $this->dateRDV;
    }

    public function setDateRDV(\DateTimeInterface $dateRDV): self
    {
        $this->dateRDV = $dateRDV;

        return $this;
    }

    /**
     * @return Collection|Patient[]
     */
    public function getPatient(): Collection
    {
        return $this->patient;
    }

    public function addPatient(Patient $patient): self
    {
        if (!$this->patient->contains($patient)) {
            $this->patient[] = $patient;
            $patient->setRendezVous($this);
        }

        return $this;
    }

    public function removePatient(Patient $patient): self
    {
        if ($this->patient->removeElement($patient)) {
            // set the owning side to null (unless already changed)
            if ($patient->getRendezVous() === $this) {
                $patient->setRendezVous(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
            $user->setRendezVous($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->medecin->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getRendezVous() === $this) {
                $user->setRendezVous(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPlannings()
    {
        return $this->plannings;
    }

    /**
     * @param mixed $plannings
     */
    public function setPlannings($plannings): void
    {
        $this->plannings = $plannings;
    }



    public function __toString(){
        return (string)$this->getNomRDV();
    }
}
