<?php
/**
 * This file is part of the evenement package.
 *
 */

namespace App\Controller;

use App\Db\ApplicationSchema\Register;
use App\Form\Type\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * @author Mikael Paris <stood86@gmail.com>
 */
class RegistrationController extends Controller
{
    public function process(Request $request)
    {
        $register = new Register([
            'event'     => null,
            'lastname'  => null,
            'firstname' => null,
            'email'     => null
        ]);

        $form = $this->createForm(RegistrationType::class, $register);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('pomm')
                ->getDefaultSession()
                ->getModel('\App\Db\ApplicationSchema\RegisterModel')
                ->insertOne($register);

            return $this->redirect($this->generateUrl('event_registration_list'));
        }

        return $this->render('register/create.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}