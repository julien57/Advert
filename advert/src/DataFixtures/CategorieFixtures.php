<?php

namespace App\DataFixtures;

    use App\Entity\Categorie;
    use Doctrine\Bundle\FixturesBundle\Fixture;
    use Doctrine\Common\Persistence\ObjectManager;
    use Doctrine\Common\DataFixtures\AbstractFixture;
    use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
    use Faker\Factory;

class CategorieFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for ($i=1; $i <= 30 ; $i++) 
        { 
            $cate = new Categorie();
            $cate->setName($faker->jobTitle);
            $manager->persist($cate);
            $manager->flush();
            $this -> addReference('categorie'.$i, $cate);
        }        
    }
    public function getOrder(){
        return 1;
    }
}
