<?php

namespace App\DataFixtures;

use App\Entity\Project;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixture extends Fixture
{

    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }


    public function load(ObjectManager $manager): void
    {
        
        for($i=0;$i<3;$i++){
            $project = new Project();
            $project->setTitle($this->faker->domainWord);

            $manager->persist($project);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
