<?php
/**
 * This file is part of the evenement package.
 *
 */

namespace App\Form\Type;

use App\Db\ApplicationSchema\Register;
use App\Form\EventListener\AddEventFieldSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            ->add('email', EmailType::class, ['label' => 'Email']);

        if ($options['active_subscriber']) {
            $builder->addEventSubscriber($this->subscriber);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(['active_subscriber']);
    }
}