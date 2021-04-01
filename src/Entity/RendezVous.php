<?php

namespace App\Entity;

use App\Repository\RendezVousRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=RendezVousRepository::class)
 */
class RendezVous
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("post:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Champs Obligatoire")
     * @Groups("post:read")
     */
    private $nomRDV;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Champs Obligatoire")
     * @Groups("post:read")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(message="Champs Obligatoire")
     * @Groups("post:read")
     */
    private $dateRDV;



    /**
     * @ORM\ManyToOne(targetEntity=Patient::class, inversedBy="rendezVous")
     * @Groups("post:read")
     */
    private $patient;



    /**
     * @ORM\ManyToOne(targetEntity=Planning::class, inversedBy="renders")
     * @ORM\JoinColumn(nullable = true)
     * @Groups("post:read")
     */
    private $plannings;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="rendezVouses")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("post:read")
     */
    private $user;

    public function __construct()
    {


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

    /**
     * @return mixed
     */
    public function getPatient()
    {
        return $this->patient;
    }

    /**
     * @param mixed $patient
     */
    public function setPatient($patient): void
    {
        $this->patient = $patient;
    }



    public function __toString(){
        return (string)$this->getNomRDV();
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }
}
