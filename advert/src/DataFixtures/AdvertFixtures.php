<?php

namespace App\DataFixtures;

use App\Entity\Advert;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker\Factory;

class AdvertFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
    	$faker = Factory::create();
        for ($i=1; $i <= 500 ; $i++) 
        { 
            $advert = new Advert();
            $advert->setTitle($faker->jobTitle);
            $advert->setAuthor($faker->name);
            $advert->setContent($faker->text);
            $advert->setPublished(true);
            $advert->setDate(new \DateTime('now'));
            $advert->setImage($this->getReference('image'.rand(0, 2)));
            $advert->addCategorie($this->getReference('categorie'.$i));
            $manager->persist($advert);
            $manager->flush();
            $this -> addReference('advert'.$i, $advert);
        }
        
    }
    public function getOrder(){
    	return 2;
    }
}
