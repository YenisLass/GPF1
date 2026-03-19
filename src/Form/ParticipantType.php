<?php
namespace App\Form;

use App\Entity\Ecurie;
use App\Entity\GrandPrix;
use App\Entity\Participant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ecurie', EntityType::class, [
                'class' => Ecurie::class,
                'choice_label' => 'nomEcurie',
            ])
            ->add('grandPrix', EntityType::class, [
                'class' => GrandPrix::class,
                'choice_label' => function (GrandPrix $grandPrix) {
                    return $grandPrix->getCircuit() ? $grandPrix->getCircuit()->getNomCircuit() . ' - ' . $grandPrix->getDateDebut() : 'GP du ' . $grandPrix->getDateDebut();
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
            'data_class' => Participant::class,
        ]);
    }
}