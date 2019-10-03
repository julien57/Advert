<?php

namespace App\DataFixtures;

use App\Entity\Application;
    use Doctrine\Bundle\FixturesBundle\Fixture;
    use Doctrine\Common\Persistence\ObjectManager;
    use Doctrine\Common\DataFixtures\AbstractFixture;
    use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
    use Faker\Factory;

class ApplicationFixtures extends Fixture  implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
  		$faker = Factory::create();
        for ($i=0; $i < 100 ; $i++) 
        { 
            $app = new Application();
            $app->setAuthor($faker->name);
			$app->setContent($faker->text);
			$app->setDate(new \DateTime('now'));
			$app->setAdvert($this->getReference('advert'.rand(1, 30)));
            $manager->persist($app);
            $manager->flush();
            $this -> addReference('application'.$i, $app);
        }

        
    }
    public function getOrder(){
        return 3;
    }
}
