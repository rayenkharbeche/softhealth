<?php

namespace App\Entity;

use App\Repository\ConsultationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ConsultationRepository::class)
 */
class Consultation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $numC;

    /**
     * @ORM\Column(type="date")
     */
    private $dateC;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $text;
    /**
     * @ORM\OneToOne(targetEntity=Patient::class, cascade={"persist"})
     */
    private $patient;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $views;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumC(): ?int
    {
        return $this->numC;
    }

    public function setNumC(int $numC): self
    {
        $this->numC = $numC;

        return $this;
    }

    public function getDateC(): ?\DateTimeInterface
    {
        return $this->dateC;
    }

    public function setDateC(\DateTimeInterface $dateC): self
    {
        $this->dateC = $dateC;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
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
    public function __toString()
    {
        return (string)$this->getPatient();

    }

    public function getViews(): ?int
    {
        return $this->views;
    }

    public function setViews(?int $views): self
    {
        $this->views = $views;

        return $this;
    }



}
