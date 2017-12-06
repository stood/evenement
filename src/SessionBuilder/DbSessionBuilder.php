<?php
/**
 * This file is part of the evenement package.
 *
 */

namespace App\SessionBuilder;

use PommProject\Foundation\Converter\PgHstore;
use PommProject\Foundation\Session\Session;
use PommProject\ModelManager\SessionBuilder;


/**
 * @author Mikael Paris <stood86@gmail.com>
 */
class DbSessionBuilder extends SessionBuilder
{
    protected function postConfigure(Session $session)
    {
        parent::postConfigure($session);

        $session
            ->getPoolerForType('converter')
            ->getConverterHolder()
            ->registerConverter('Hstore', new PgHstore(), ['public.hstore']);
    }
}