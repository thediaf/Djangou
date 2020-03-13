<?php

namespace App\Form\Admin;

use App\Entity\Translate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TranslateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('word')
            ->add('classe', TextType::class, [
                'required' => false
            ])
            // ->add('language')
            // ->add('words')
            ->add('translates', CollectionType::class, [
                'entry_type' => TranslateWordType::class,
                'entry_options' => ['source_language' => $options['source_language']],
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Translate::class,
            'source_language' => ''
        ]);

        $resolver->setAllowedTypes('source_language', 'string');
    }
}
