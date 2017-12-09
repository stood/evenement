<?php
/**
 * This file is part of the evenement package.
 *
 */

namespace App\SessionBuilder;

use PommProject\Foundation\Converter\PgHstore;
use PommProject\Foundation\Converter\ConverterHolder;
use PommProject\ModelManager\SessionBuilder;


/**
 * @author Mikael Paris <stood86@gmail.com>
 */
class DbSessionBuilder extends SessionBuilder
{
    protected function initializeConverterHolder(ConverterHolder $converter_holder)
    {
        parent::initializeConverterHolder($converter_holder);

        $converter_holder
            ->registerConverter('Hstore', new PgHstore(), ['public.hstore']);
    }
}