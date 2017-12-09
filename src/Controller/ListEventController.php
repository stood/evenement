<?php
/**
 * This file is part of the evenement package.
 *
 */

namespace App\Controller;

use App\Db\ApplicationSchema\EventModel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * @author Mikael Paris <stood86@gmail.com>
 */
class ListEventController extends Controller
{
    public function show()
    {
        $events = $this->get('pomm')
            ->getDefaultSession()
            ->getModel(EventModel::class)
            ->findWithCategoryAndNbRegister();

        return $this->render('event/list.html.twig', ['events' => $events]);
    }
}