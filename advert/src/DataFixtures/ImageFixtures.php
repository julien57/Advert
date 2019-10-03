<?php

namespace App\DataFixtures;

    use App\Entity\Image;
    use Doctrine\Bundle\FixturesBundle\Fixture;
    use Doctrine\Common\Persistence\ObjectManager;
    use Doctrine\Common\DataFixtures\AbstractFixture;
    use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
    use Faker\Factory;

class ImageFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
    	$faker = Factory::create();
        for ($i=1; $i <= 30 ; $i++) 
        { 
        	$image = new Image();
        	$image->setUrl($faker->imageUrl($width = 250, $height = 100));
        	$image->setPath($faker->imageUrl($width = 250, $height = 100));
        	$manager->persist($image);
        	$manager->flush();
        	$this -> addReference('image'.$i, $image);
        }

        
    }
    public function getOrder(){
    	return 1;
    }
}
