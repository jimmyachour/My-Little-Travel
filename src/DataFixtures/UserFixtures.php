<?php

namespace App\DataFixtures;
use Faker;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        // Admin
        $user = new User();
        $user->setLastname($faker->lastName);
        $user->setFirstname($faker->firstName);
        $user->setCity($faker->city);
        $user->setBirthDate(new \DateTime($faker->dateTimeThisCentury->format('Y-m-d')));
        $user->setImgProfil('0.jpg');
        $user->setEmail('admin@admin.fr');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($this->encoder->encodePassword($user,'admin'));
        $this->addReference('admin', $user);
        $manager->persist($user);

        // User 1
        $user = new User();
        $user->setLastname($faker->lastName);
        $user->setFirstname($faker->firstName);
        $user->setCity($faker->city);
        $user->setBirthDate(new \DateTime($faker->dateTimeThisCentury->format('Y-m-d')));
        $user->setImgProfil('0.jpg');
        $user->setEmail('user1@user.fr');
        $user->setPassword($this->encoder->encodePassword($user,'user'));
        $manager->persist($user);

        // User 2
        $user = new User();
        $user->setLastname($faker->lastName);
        $user->setFirstname($faker->firstName);
        $user->setCity($faker->city);
        $user->setBirthDate(new \DateTime($faker->dateTimeThisCentury->format('Y-m-d')));
        $user->setImgProfil('0.jpg');
        $user->setEmail('user2@user.fr');
        $user->setPassword($this->encoder->encodePassword($user,'user'));
        $manager->persist($user);

        $manager->flush();
    }
}
