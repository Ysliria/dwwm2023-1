<?php

namespace App\DataFixtures;

use App\Entity\Formation;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public const FORMATION = [
        'DWWM' => 'Développeur Web et Web Mobile',
        'CDA'  => 'Concepteur Développeur d\'Application',
        'CDUI' => 'Concepteur Designer UI',
        'CDLC' => 'Concepteur Développeur Low Code',
        'MS2D' => 'Manager de solutions digitales et data'
    ];

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Création de l'administrateur
        $admin = new User();
        $admin
            ->setFirstname('Mickaël')
            ->setLastname('AUGER')
            ->setPhone('+33123456789')
            ->setEmail('mauger@cefim.eu')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->passwordHasher->hashPassword($admin, 'Test1234*'));

        $manager->persist($admin);

        // Création des utilisateurs
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user
                ->setFirstname($faker->firstName())
                ->setLastname($faker->lastName())
                ->setPhone($faker->e164PhoneNumber())
                ->setEmail($faker->safeEmail())
                ->setRoles($faker->randomElement([['ROLE_USER'], ['ROLE_REFERENT']]))
                ->setPassword($this->passwordHasher->hashPassword($user, 'Test1234*'));

            $manager->persist($user);
        }

        // Création des formations
        for ($i = 0; $i < 10; $i++) {
            $code      = array_rand(self::FORMATION);
            $formation = new Formation();

            $formation
                ->setNom(self::FORMATION[$code])
                ->setCode($code)
                ->setStartedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 week', '+1 month')))
                ->setFinishedAt(
                    \DateTimeImmutable::createFromMutable(
                        $faker->dateTimeBetween($formation->getStartedAt()?->format('Y-m-d'), '+1 year')
                    )
                )
                ->setVille($faker->randomElement(['Tours', 'Orléans']));

            $manager->persist($formation);
        }

        $manager->flush();
    }
}
