<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    const CATEGORIES = [
        [
            'name' => 'Produits laitiers',
            'sugar' => 'Disaccharides',
            'week' => 3,
        ],
        [
            'name' => 'Autres',
            'sugar' => '',
            'week' => 4,
        ],
        [
            'name' => 'Produits céréaliers',
            'sugar' => 'Oligosaccharides',
            'week' => 5,
        ],
        [
            'name' => 'Légumes verts',
            'sugar' => 'Oligosaccharides',
            'week' => 6,
        ],
        [
            'name' => 'Fruits',
            'sugar' => 'Monosaccharides',
            'week' => 7,
        ],
        [
            'name' => 'Divers',
            'sugar' => 'Polyols',
            'week' => 8,
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::CATEGORIES as $data) {
            $category = new Category();
            $category->setName($data['name']);
            $category->setSugar($data['sugar']);
            $category->setDietWeek($data['week']);
            $manager->persist($category);
        }

        $manager->flush();
    }
}
