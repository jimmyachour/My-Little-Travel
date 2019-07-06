<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    const IMG_LINK = [
        'https://www.worldelse.com/wp-content/uploads/2016/04/PHOTO-COUV-CALIFORNIE-1.jpg',
        'https://www.worldelse.com/wp-content/uploads/2016/03/Chine.jpg',
        'https://www.worldelse.com/wp-content/uploads/2017/03/Ponton-2-copie.jpg',
        'https://www.worldelse.com/wp-content/uploads/2016/05/P1010917-1.jpg',
        'https://www.worldelse.com/wp-content/uploads/2016/03/Irlande.jpg',
        'https://www.worldelse.com/wp-content/uploads/2016/03/Philippines.jpg',
        'https://www.worldelse.com/wp-content/uploads/2019/02/Abu-Dhabi2500.jpg'
    ];

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for($i = 0 ; $i < count(self::IMG_LINK) ; $i++) {

            $article = new Article();

            $article->setTitle($faker->sentence);
            $article->setContent($faker->text(1000));
            $article->setAuthor($this->getReference('writer_' . rand(0,1)));
            $article->setImg(self::IMG_LINK[$i]);
            $article->getDate(new \DateTime($faker->dateTimeThisCentury->format($format = 'Y-m-d')));
            $article->setCategory($this->getReference(rand(0, 5)));
            $this->addReference('article_' . $i, $article);

            $manager->persist($article);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [UserFixtures::class,CategoryFixtures::class];
    }
}
