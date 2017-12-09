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
class StatisticsController extends Controller
{
    public function show()
    {
        $sql = <<<SQL
SELECT to_char(register.created_at, 'month') as "month",  count(register.register_id) as nb_register FROM application.register register GROUP BY ROLLUP (to_char(register.created_at, 'month'))
SQL;
        $result = $this->get('pomm')
            ->getDefaultSession()
            ->getQueryManager()
            ->query($sql, []);

        return $this->render('register/statistics.html.twig', array(
            'result' => $result
        ));
    }
}