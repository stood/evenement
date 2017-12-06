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
class ListRegistrationController extends Controller
{
    public function show()
    {
        $registers = $this->get('pomm')
            ->getDefaultSession()
            ->getModel('\App\Db\ApplicationSchema\RegisterModel')
            ->findAll();

        return $this->render('register/list.html.twig', ['registers' => $registers]);
    }
}