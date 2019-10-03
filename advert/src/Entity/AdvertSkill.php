<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdvertSkillRepository")
 */
class AdvertSkill
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Advert", cascade={"persist", "remove"})
     * @Assert\Valid
     */
    private $Advert;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Competence")
     */
    private $Competence;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Level")
     */
    private $Level;

    public function __construct()
    {
        $this->Competence = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdvert(): ?Advert
    {
        return $this->Advert;
    }

    public function setAdvert(?Advert $Advert): self
    {
        $this->Advert = $Advert;

        return $this;
    }

    /**
     * @return Collection|Competence[]
     */
    public function getCompetence(): Collection
    {
        return $this->Competence;
    }

    public function addCompetence(Competence $competence): self
    {
        if (!$this->Competence->contains($competence)) {
            $this->Competence[] = $competence;
        }

        return $this;
    }

    public function removeCompetence(Competence $competence): self
    {
        if ($this->Competence->contains($competence)) {
            $this->Competence->removeElement($competence);
        }

        return $this;
    }

    public function getLevel(): ?Level
    {
        return $this->Level;
    }

    public function setLevel(?Level $Level): self
    {
        $this->Level = $Level;

        return $this;
    }
}
