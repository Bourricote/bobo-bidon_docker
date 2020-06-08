<?php


namespace App\Entity;

/**
 * Class FoodSearch
 * @package App\Entity
 */
class FoodSearch
{
    /**
     * @var Category | null
     */
    private $category;

    /**
     * @var string | null
     */
    private $searchText;

    /**
     * @var(type="integer")
     */
    private $isHighFodmap;

    /**
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * @param Category|null $category
     */
    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    /**
     * @return string|null
     */
    public function getSearchText(): ?string
    {
        return $this->searchText;
    }

    /**
     * @param string|null $searchText
     */
    public function setSearchText(?string $searchText): void
    {
        $this->searchText = $searchText;
    }

    /**
     * @return int|null
     */
    public function getIsHighFodmap(): ?int
    {
        return $this->isHighFodmap;
    }

    /**
     * @param int|null $isHighFodmap
     * @return $this
     */
    public function setIsHighFodmap(?int $isHighFodmap): self
    {
        $this->isHighFodmap = $isHighFodmap;

        return $this;
    }

}
