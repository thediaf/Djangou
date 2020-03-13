<?php

namespace App\Form\Admin;

use App\Entity\Language;
use App\Entity\Translate;
use App\Repository\LanguageRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TranslateWordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('word')
            ->add('language', EntityType::class, [
                'class' => Language::class,
                'choice_label' => 'name',
                'query_builder' => function(LanguageRepository $languageRepository) use($options) {
                    return $languageRepository->createQueryBuilder('l')
                        ->where('l.name != :lang')
                        ->setParameter('lang', $options['source_language']);
                }
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
