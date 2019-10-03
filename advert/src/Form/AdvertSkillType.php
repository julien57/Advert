<?php

namespace App\Form;

use App\Entity\AdvertSkill;
use App\Entity\Advert;
use App\Entity\Competence;
use App\Entity\Level;
use App\Form\AdvertType;
use App\Form\CompetenceType;
use App\Form\LevelType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AdvertSkillType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Advert', AdvertType::class)
            ->add('Competence', EntityType::class, array(
                'class' => Competence::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,))
            ->add('Level', EntityType::class, array(
                'class' => Level::class,
                'choice_label' => 'level',
                'multiple' => false,
                'expanded' => true,))
            ->add('save', submitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AdvertSkill::class,
        ]);
    }
}
