<?php
namespace App\Form;
use App\Entity\Ecurie;
use App\Entity\Pilote;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
class PiloteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomPilote')
            ->add('prenomPilote')
            ->add('age')
            ->add('nbTitrePilote')
            ->add('imgPilote', FileType::class, [
                'label' => 'Image du pilote',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                    ])
                ],
            ])
            ->add('ecurie', EntityType::class, [
                'class' => Ecurie::class,
                'choice_label' => 'nomEcurie',
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pilote::class,
        ]);
    }
}