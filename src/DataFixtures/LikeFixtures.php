<?php

namespace App\DataFixtures;

use App\Entity\ArticleLike;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LikeFixtures extends Fixture  implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {


        for($i = 0; $i <=6; $i++) {
            $like = new ArticleLike();
            $like->setArticle($this->getReference('article_' . $i ));
            $like->setUser($this->getReference('writer_' . rand(0,1)));
            $manager->persist($like);
        }
        $manager->flush();

    }

    public function getDependencies()
    {
        return [UserFixtures::class, ArticleFixtures::class];
    }
}
