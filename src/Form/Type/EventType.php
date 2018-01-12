<?php
/**
 * This file is part of the evenement package.
 *
 */

namespace App\Form\Type;

use App\Db\ApplicationSchema\Event;
use App\Db\ApplicationSchema\Register;
use App\Form\EventListener\AddCategoryFieldSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Mikael Paris <stood86@gmail.com>
 */
class EventType extends AbstractType
{
    protected $subscriber;

    public function __construct(AddCategoryFieldSubscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', CollectionType::class,
                [
                    'entry_type' => TextType::class,
                    'label' => 'Nom'
                ])
            ->add('registrations', CollectionType::class,
                [
                    'entry_type' => RegistrationType::class,
                    'entry_options' => [
                        'active_subscriber' => false
                    ],
                    'label' => 'Inscris',
                    'prototype' => true,
                    'allow_add' => true,
                    'prototype_data' => new Register([
                        'lastname'  => null,
                        'firstname' => null,
                        'email'     => null
                    ])
                ]);

        $builder->addEventSubscriber($this->subscriber);
    }
}