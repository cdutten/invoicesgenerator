<?php
/**
 * Created by PhpStorm.
 * User: extendeal
 * Date: 13/06/18
 * Time: 14:37
 */

namespace invoicesgenerator;

use invoicesgenerator\contracts\GeneratorInterface;
use invoicesgenerator\contracts\InvoiceTypeInterface;

class Invoice implements InvoiceTypeInterface
{
    public function process(GeneratorInterface $generator)
    {
        // TODO: Implement process() method.
    }
}