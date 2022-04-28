<?php

namespace App\DataFixtures;

use App\Entity\Question;
use App\Factory\QuestionFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class QuestionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        QuestionFactory::createMany(15);

        QuestionFactory::new()
            ->unpublished()
            ->createMany(5)
        ;

        $manager->flush();
    }
}
