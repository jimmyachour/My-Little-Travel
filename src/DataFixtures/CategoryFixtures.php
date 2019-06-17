<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    const CATEGORIES = ['état-unis', 'asie', 'europe', 'afrique', 'amérique du sud', 'europe de l\'est'];

    public function load(ObjectManager $manager)
    {

        foreach (self::CATEGORIES as $key => $categoryName) {

            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);
            $this->addReference($key, $category);
        }

        $manager->flush();
    }
}
