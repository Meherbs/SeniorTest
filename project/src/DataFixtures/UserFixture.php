<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;

class UserFixture extends Fixture
{
    private $userPasswordHasherInterface;

    public function __construct (UserPasswordHasherInterface $userPasswordHasherInterface) 
    {
        $this->userPasswordHasherInterface = $userPasswordHasherInterface;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('test');
        $user->setRoles(['ROLE_USER']);

        $plaintextPassword = 'password';
        // hash the password (based on the security.yaml config for the $user class)
        $hashedPassword = $this->userPasswordHasherInterface->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashedPassword);

        $moderator = new User();
        $moderator->setUsername('admin');
        $moderator->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        $moderator->setPassword($this->userPasswordHasherInterface->hashPassword(
            $moderator,
            $plaintextPassword
        ));

        $manager->persist($user);
        $manager->persist($moderator);

        $manager->flush();
    }
}
