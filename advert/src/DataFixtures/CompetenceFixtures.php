<?php

namespace App\DataFixtures;

    use App\Entity\Competence;
    use Doctrine\Bundle\FixturesBundle\Fixture;
    use Doctrine\Common\Persistence\ObjectManager;
    use Doctrine\Common\DataFixtures\AbstractFixture;
    use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
    use Faker\Factory;

class CompetenceFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $skilllist = array('Conduite', 'Commerce', 'PHP', 'React', 'J.S', 'HTML CSS', 'Symfony', 'Laravell', 'Comptabilité' , 'Ruby', 'Python');
        for ($i=0; $i < count($skilllist) ; $i++) 
        { 
            $skill = new Competence();
            $skill->setName($skilllist[$i]);
            $manager->persist($skill);
            $manager->flush();
            $this -> addReference('competence'.$i, $skill);
        }

        
    }
    public function getOrder(){
        return 1;
    }
}
