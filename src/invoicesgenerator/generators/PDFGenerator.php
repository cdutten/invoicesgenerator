<?php
/**
 * Created by PhpStorm.
 * User: Laura
 * Date: 13/6/2018
 * Time: 22:43
 */

namespace invoicesgenerator\generators;

use invoicesgenerator\contracts\GeneratorInterface;

class PDFGenerator implements GeneratorInterface
{
    public function put($path, $content)
    {
        // TODO: Implement put() method.
    }

    public function isWritable($path)
    {
        return is_writable($path);
    }

    public function exists($path)
    {
        return file_exists($path);
    }

    public function isDirectory($directory)
    {
        return is_dir($directory);
    }

    public function makeDirectory($path)
    {
        return mkdir($path);
    }

    public function cleanDirectory($directory)
    {
        return $this-><deleteDirectory($directory, true);
    }
}
