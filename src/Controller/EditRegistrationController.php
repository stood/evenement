<?php
/**
 * This file is part of the evenement package.
 *
 */

namespace App\Controller;

use App\Db\ApplicationSchema\RegisterModel;
use App\Form\Type\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * @author Mikael Paris <stood86@gmail.com>
 */
class EditRegistrationController extends Controller
{
    public function process(Request $request, $registerId)
    {
        $register = $this->get('pomm')
            ->getDefaultSession()
            ->getModel(RegisterModel::class)
            ->findWithEvent($registerId);

        $form = $this->createForm(RegistrationType::class, $register, ['active_subscriber' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('pomm')
                ->getDefaultSession()
                ->getModel(RegisterModel::class)
                ->updateOne(
                    $register,
                    ['lastname', 'firstname', 'email', 'event_id']
                );

            return $this->redirectToRoute('event_registration_list');
        }

        return $this->render('register/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}