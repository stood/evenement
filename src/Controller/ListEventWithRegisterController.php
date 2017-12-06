<?php
/**
 * This file is part of the evenement package.
 *
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * @author Mikael Paris <stood86@gmail.com>
 */
class ListEventWithRegisterController extends Controller
{
    public function show()
    {
        $events = $this->get('pomm')
            ->getDefaultSession()
            ->getModel('\App\Db\ApplicationSchema\EventModel')
            ->findWithRegister();

        return $this->render('event/list_with_register.html.twig', ['events' => $events]);
    }
}