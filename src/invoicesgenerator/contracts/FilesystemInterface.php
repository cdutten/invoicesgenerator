<?php
/**
 * Created by PhpStorm.
 * User: Cesar Dutten
 * Date: 13/6/2018
 * Time: 22:48
 */

namespace invoicesgenerator\contracts;

interface FilesystemInterface
{
    public static function isWritable($path);

    public static function exists($path);

    public static function isDirectory($directory);

    public static function makeDirectory($path, $mode = 0755, $recursive = false);

    public static function delete($paths);

    public static function deleteDirectory($directory, $preserve);

    public static function cleanDirectory($directory);
}
