<?php
/**
 * This file is part of the evenement package.
 *
 */

namespace App\Form\EventListener;

use App\Db\ApplicationSchema\CategoryModel;
use App\Db\ApplicationSchema\EventModel;
use PommProject\Foundation\Pomm;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;


/**
 * @author Mikael Paris <stood86@gmail.com>
 */
class AddCategoryFieldSubscriber implements EventSubscriberInterface
{
    protected $pomm;

    public function __construct(Pomm $pomm)
    {
        $this->pomm = $pomm;
    }

    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::POST_SUBMIT  => 'postSubmit'
        ];
    }

    public function preSetData(FormEvent $event)
    {
        $form = $event->getForm();

        $form->add('category', ChoiceType::class, [
            'label' => 'Catégorie',
            'choices' => $this->getCategorys(),
            'choice_label' => function($elt) {
                return $elt->getName()['fr'];
            },
            'placeholder' => 'Choisir une catégorie',
            'choice_value' => function($elt) {
                if ($elt !== null) {
                    return $elt->getCategoryId();
                }
            },
            'required' => true,
            'attr' => ['class'=>'form-control']
        ]);
    }

    public function postSubmit(FormEvent $event)
    {
        $data = $event->getData();

        if ($data->getCategory() != null) {
            $data->set('category_id', $data->getCategory()->getCategoryId());
        }

        return;
    }

    private function getCategorys()
    {
        return $this->pomm
            ->getDefaultSession()
            ->getModel(CategoryModel::class)
            ->findAll();
    }

}