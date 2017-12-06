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
WITH 
  windowquery (month, nb_register) 
  as 
  (
    SELECT to_char(register.created_at, 'month') as month,  count(register.register_id) as nb_register FROM application.register register GROUP BY to_char(register.created_at, 'month') 
  ) 
SELECT 'Total' as month, SUM(nb_register) as nb_register FROM windowquery UNION ALL SELECT month, nb_register FROM windowquery
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