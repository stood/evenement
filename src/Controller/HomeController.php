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
class HomeController extends Controller
{
    public function hello()
    {
        return $this->render('general/home.html.twig');
    }
}