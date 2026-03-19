<?php
namespace App\Form;

use App\Entity\Circuit;
use App\Entity\GrandPrix;
use App\Entity\Meteo;
use App\Entity\Participant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GrandPrixType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDebut')
            ->add('heureDebut')
            ->add('heureFin')
            ->add('circuit', EntityType::class, [
                'class' => Circuit::class,
                'choice_label' => 'nomCircuit',
            ])
            ->add('meteo', EntityType::class, [
                'class' => Meteo::class,
                'choice_label' => 'nomMeteo',
            ])
            ->add('participant', EntityType::class, [
                'class' => Participant::class,
                'choice_label' => function (Participant $participant) {
                    return $participant->getEcurie() ? $participant->getEcurie()->getNomEcurie() : 'Aucune écurie';
                },
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GrandPrix::class,
        ]);
    }
}