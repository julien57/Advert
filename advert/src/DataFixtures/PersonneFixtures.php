<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Personne;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker\Factory;

class PersonneFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
    	$statutList = array('Silver', 'Gold', 'Premium' );
    	$faker = Factory::create();
    	for ($i=0; $i < 20 ; $i++) 
        { 
            $pers = new Personne();
            $pers->setName($faker->name);
			$pers->setMail($faker->email);
			$pers->setStatut($faker->randomElement($statutList));
            $manager->persist($pers);
            $manager->flush();
            $this -> addReference('personne'.$i, $pers);
        }
    }
    public function getOrder()
    {
        return 1;
    }
}
