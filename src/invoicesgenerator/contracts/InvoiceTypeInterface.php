<?php
/**
 * Created by PhpStorm.
 * User: Cesar Dutten
 * Date: 13/6/2018
 * Time: 22:28
 */

namespace invoicesgenerator\contracts;

interface InvoiceTypeInterface
{
    public function process(GeneratorInterface $generator);
}