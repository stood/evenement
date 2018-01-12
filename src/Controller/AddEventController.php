<?php
/**
 * This file is part of the evenement package.
 *
 */

namespace App\Controller;

use App\Db\ApplicationSchema\Event;
use App\Db\ApplicationSchema\EventModel;
use App\Form\Type\EventType;
use App\Form\Type\RegistrationType;
use App\Db\ApplicationSchema\ModelLayer\EventLayer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * @author Mikael Paris <stood86@gmail.com>
 */
class AddEventController extends Controller
{
    public function process(Request $request)
    {
        $event = new Event([
            'name'          => ['fr' => '', 'en' => ''],
            'category'      => null,
            'registrations' => []
        ]);

        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $eventLayer = $this->get('pomm')
                ->getDefaultSession()
                ->getModelLayer(EventLayer::class);

            $eventLayer->createEvent($event);

            return $this->redirectToRoute('event_list');
        }

        return $this->render('event/create.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}