<?php

namespace App\Form;

use App\Entity\Language;
use App\Entity\Search;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('word', null, [
                'label' => false,
                'attr' => ['placeholder' => 'mot']
            ])
            ->add('wordLanguage', EntityType::class, [
                'required' => false,
                'label' => false,
                'class' => Language::class,
                'choice_label' => 'name'
            ])
            ->add('translateLanguage', EntityType::class, [
                'required' => false,
                'label' => false,
                'class' => Language::class,
                'choice_label' => 'name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
        ]);
    }
}
