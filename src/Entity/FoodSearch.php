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



}
