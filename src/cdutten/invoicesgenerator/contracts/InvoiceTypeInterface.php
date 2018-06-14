<?php
/**
 * Created by PhpStorm.
 * User: Laura
 * Date: 13/6/2018
 * Time: 22:28
 */

namespace cdutten\invoicesgenerator\contracts;


interface InvoiceTypeInterface
{
    public function process ();
}