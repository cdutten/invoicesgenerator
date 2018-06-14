<?php
/**
 * Created by PhpStorm.
 * User: Laura
 * Date: 13/6/2018
 * Time: 22:43
 */

namespace cdutten\invoicesgenerator\generators;

use cdutten\invoicesgenerator\contracts\GeneratorInterface;

class PDFGenerator implements GeneratorInterface
{
    public function put($path, $content)
    {
        // TODO: Implement generate() method.
    }

    public function isWritable($path)
    {
        // TODO: Implement isWritable() method.
    }

    public function exists($path)
    {
        // TODO: Implement exists() method.
    }

    public function isDirectory($directory)
    {
        // TODO: Implement isDirectory() method.
    }

    public function makeDirectory($path)
    {
        // TODO: Implement makeDirectory() method.
    }

    public function cleanDirectory($directory)
    {
        // TODO: Implement cleanDirectory() method.
    }
}
