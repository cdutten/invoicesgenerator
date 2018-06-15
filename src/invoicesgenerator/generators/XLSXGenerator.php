<?php
/**
 * Created by PhpStorm.
 * User: Laura
 * Date: 13/6/2018
 * Time: 22:43
 */

namespace invoicesgenerator\generators;

use invoicesgenerator\contracts\GeneratorInterface;

class XLSXGenerator implements GeneratorInterface
{
    public function put($path, $content)
    {
        // TODO: Implement put() method.
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