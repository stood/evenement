<?php
/**
 * This file is part of the evenement package.
 *
 */

namespace App\Form\EventListener;

use App\Db\ApplicationSchema\EventModel;
use PommProject\Foundation\Pomm;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;


/**
 * @author Mikael Paris <stood86@gmail.com>
 */
class AddEventFieldSubscriber implements EventSubscriberInterface
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

        $form->add('event', ChoiceType::class, [
            'label' => 'Evenement',
            'choices' => $this->getEvents(),
            'choice_label' => function($elt) {
                return $elt->getName()['fr'];
            },
            'placeholder' => 'Choisir un événement',
            'choice_value' => function($elt) {
                if ($elt !== null) {
                    return $elt->getEventId();
                }
            },
            'required' => true,
            'attr' => ['class'=>'form-control']
        ]);
    }

    public function postSubmit(FormEvent $event)
    {
        $data = $event->getData();

        if ($data->getEvent() != null) {
            $data->set('event_id', $data->getEvent()->getEventId());
        }

        return;
    }

    private function getEvents()
    {
        return $this->pomm
            ->getDefaultSession()
            ->getModel(EventModel::class)
            ->findAll();
    }

}