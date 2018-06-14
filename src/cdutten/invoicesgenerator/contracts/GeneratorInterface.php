<?php
/**
 * Created by PhpStorm.
 * User: Laura
 * Date: 13/6/2018
 * Time: 22:48
 */

namespace cdutten\invoicesgenerator\contracts;


interface GeneratorInterface
{

    public function put($path, $content);

    public function isWritable($path);

    public function exists($path);

    public function isDirectory($directory);

    public function makeDirectory($path);

    public function cleanDirectory($directory);
}
