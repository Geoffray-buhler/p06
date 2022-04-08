<?php

namespace App\Form;

use App\Entity\Trick;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class NewTrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name',TextType::class,['label'=>'Nom de la figure','required' => true])
            ->add('Definition',TextareaType::class,['label'=>'Définition','required' => true])
            ->add('Categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'Name',
                'multiple' => false, 
                'required' => true
            ])
            ->add('Medias',FileType::class,['mapped' => false,'label' => 'Photo ou vidéo','multiple' => true,'required' => false])
            ->add('Youtube',CollectionType::class,['mapped' => false,'entry_type' => TextType::class])
            ->add('Submit',SubmitType::class,['label' => 'Envoyer','attr'=>['class'=>'button-primaire']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
