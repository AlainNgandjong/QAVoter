<?php

namespace App\DataFixtures;

use App\Factory\AnswerFactory;
use App\Factory\QuestionFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AnswerFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        AnswerFactory::createMany(50);

        AnswerFactory::new()->needsApproval()->createMany(20);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            QuestionFixtures::class
        ];
    }
}
