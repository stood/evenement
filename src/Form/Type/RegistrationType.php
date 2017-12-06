<?php
/**
 * This file is part of the evenement package.
 *
 */

namespace App\Form\Type;

use App\Form\EventListener\AddEventFieldSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @author Mikael Paris <stood86@gmail.com>
 */
class RegistrationType extends AbstractType
{
    protected $subscriber;

    public function __construct(AddEventFieldSubscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname', TextType::class, ['label' => 'Nom'])
            ->add('firstname', TextType::class, ['label' => 'Prénom'])
            ->add('email', EmailType::class, ['label' => 'Email'])
            ->add('save', SubmitType::class, array('label' => 'Enregistrement'));

        $builder->addEventSubscriber($this->subscriber);

    }

}