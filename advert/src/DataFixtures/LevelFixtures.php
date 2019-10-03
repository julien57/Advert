<?php

namespace App\DataFixtures;

    use App\Entity\Level;
    use Doctrine\Bundle\FixturesBundle\Fixture;
    use Doctrine\Common\Persistence\ObjectManager;
    use Doctrine\Common\DataFixtures\AbstractFixture;
    use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
    use Faker\Factory;

class LevelFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $levelList = array('debutant', 'intermediaire', 'expert');
        for ($i=0;  $i < count($levelList)-1 ; $i++) 
        {  	
    		$level = new Level();
    		$level->setLevel($levelList[$i]);
            $manager->persist($level);
    	    $manager->flush();
            $this -> addReference('level'.$i, $level);
        }   
    }
    public function getOrder()
    {
        return 1;
    }
}
