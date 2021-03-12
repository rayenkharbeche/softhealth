<?php

namespace App\Entity;

use App\Repository\PlanningRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=PlanningRepository::class)
 */
class Planning
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
    private $nomP;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Expression(
     *     "this.getDateDebut() < this.getDateFin()",
     *     message="La date fin ne doit pas être antérieure à la date début"
     * )
     */
    private $dateFin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descriptionP;

    /**
     * @ORM\OneToMany(targetEntity=RendezVous::class, mappedBy="plannings",cascade={"persist"})
     */
    private $renders;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="plannings",cascade={"persist"})
     */
    private $personnel;

    public function __construct(){
        $this->renders = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomP(): ?string
    {
        return $this->nomP;
    }

    public function setNomP(string $nomP): self
    {
        $this->nomP = $nomP;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }
    /**
     * @param mixed $dateDebut
     */
    public function setDateDebut($dateDebut): void
    {
        $this->dateDebut = $dateDebut;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getDescriptionP(): ?string
    {
        return $this->descriptionP;
    }

    public function setDescriptionP(string $descriptionP): self
    {
        $this->descriptionP = $descriptionP;

        return $this;
    }
    /**
     * @return Collection|RendezVous[]
     */
    public function getRenders(): Collection
    {
        return $this->renders;
    }

    public function addRenders(RendezVous $renders): self
    {
        if (!$this->renders->contains($renders)) {
            $this->RendezVous[] = $renders;
            $renders->setPlannings($this);
        }

        return $this;
    }

    public function removeRenders(RendezVous $renders): self
    {
        if ($this->renders->removeElement($renders)) {
            $this->renders->removeElement($renders);
            // set the owning side to null (unless already changed)
            if ($renders->getPlannings() === $this) {
                $renders->setPlannings(null);
            }
        }

        return $this;
    }



    public function getPersonnel(): ?User
    {
        return $this->personnel;
    }


    public function setPersonnel(?User $personnel): self
    {
        $this->personnel = $personnel;

        return $this;
    }

    public function __toString(){
        return (string)$this->getNomP();
    }

    }
