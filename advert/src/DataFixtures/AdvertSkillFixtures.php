<?php

namespace App\DataFixtures;

	use App\Entity\AdvertSkill;
    use Doctrine\Bundle\FixturesBundle\Fixture;
    use Doctrine\Common\Persistence\ObjectManager;
    use Doctrine\Common\DataFixtures\AbstractFixture;
    use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
    use Faker\Factory;

class AdvertSkillFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
    	$faker = Factory::create();
        for ($i=1; $i <= 30 ; $i++) 
        { 
        $advertSkill = new AdvertSkill();
        $advertSkill->setAdvert($this->getReference('advert'.$i));
        $advertSkill->addCompetence($this->getReference('competence'.rand(0, 10)));
        $advertSkill->setLevel($this->getReference('level'.rand(0, 2)));
        $manager->persist($advertSkill);
        $manager->flush();
        $this -> addReference('advertSkill'.$i, $advertSkill);
    }
     
    }
    public function getOrder(){
    	return 3;
    }
}
