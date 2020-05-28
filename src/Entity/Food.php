<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FoodRepository")
 */
class Food
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $fodmap;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="foods")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\Column(type="integer")
     */
    private $oligos;

    /**
     * @ORM\Column(type="integer")
     */
    private $fructose;

    /**
     * @ORM\Column(type="integer")
     */
    private $polyols;

    /**
     * @ORM\Column(type="integer")
     */
    private $lactose;


    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFodmap(): ?string
    {
        return $this->fodmap;
    }

    /**
     * @param bool $fodmap
     * @return $this
     */
    public function setFodmap(bool $fodmap): self
    {
        $this->setFodmap = $fodmap;

        return $this;
    }

    /**
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * @param Category|null $category
     * @return $this
     */
    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }


    public function getOligos(): ?int
    {
        return $this->oligos;
    }


    public function setOligos($oligos): self
    {
        $this->oligos = $oligos;
        return $this;
    }


    public function getFructose(): ?int
    {
        return $this->fructose;
    }


    public function setFructose($fructose): self
    {
        $this->fructose = $fructose;
        return $this;
    }


    public function getPolyols(): ?int
    {
        return $this->polyols;
    }


    public function setPolyols($polyols): self
    {
        $this->polyols = $polyols;
        return $this;
    }


    public function getLactose(): ?int
    {
        return $this->lactose;
    }


    public function setLactose($lactose): self
    {
        $this->lactose = $lactose;
        return $this;
    }


}
