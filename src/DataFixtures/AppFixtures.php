<?php

namespace App\DataFixtures;

use App\Entity\Item;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->faker = Factory::create();

        for ($i = 0; $i < 50; $i++) {
            $item = new Item();
            $item->setTitle( $this->faker->title);
            $item->setDescription($this->faker->text);
            $item->setImage($this->faker->imageUrl());
            $item->setPrice($this->faker->numberBetween(10,500));
            $manager->persist($item);

        }

        $manager->flush();
    }
}
