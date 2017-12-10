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
class DeleteRegistrationController extends Controller
{
    public function process(Request $request, $registerId)
    {
        $register = $this->get('pomm')
            ->getDefaultSession()
            ->getModel(RegisterModel::class)
            ->deleteByPK(['register_id' => $registerId]);

        return $this->redirectToRoute('event_registration_list');
    }
}