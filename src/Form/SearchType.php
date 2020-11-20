<?php

/*
 * This file is part of the Djangou application.
 *
 * (c) Diafra Soumaré and Bechir Ba
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Form;

use App\Entity\Language;
use App\Entity\Search;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('word', null, [
                'label' => false,
                'attr' => ['placeholder' => 'mot'],
            ])
            ->add('wordLanguage', EntityType::class, [
                // 'required' => false,
                'label' => false,
                'class' => Language::class,
                'choice_label' => 'name',
            ])
            ->add('translateLanguage', EntityType::class, [
                // 'required' => false,
                'label' => false,
                'class' => Language::class,
                'choice_label' => 'name',
                // ''
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
