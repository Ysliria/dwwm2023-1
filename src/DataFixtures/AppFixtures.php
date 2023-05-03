<?php

namespace App\DataFixtures;

use App\Entity\Formation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public const FORMATION = [
        'DWWM' => 'Développeur Web et Web Mobile',
        'CDA'  => 'Concepteur Développeur d\'Application',
        'CDUI' => 'Concepteur Designer UI',
        'CDLC' => 'Concepteur Développeur Low Code',
        'MS2D' => 'Manager de solutions digitales et data'
    ];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $code = array_rand(self::FORMATION);
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
