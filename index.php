<?php
/**
 * Created by PhpStorm.
 * User: extendeal
 * Date: 13/06/18
 * Time: 14:30
compo */

require __DIR__ . '\vendor\autoload.php';

use invoicesgenerator\generators\Writers\FieldsWriter;
use invoicesgenerator\generators\XLSXGenerator;

try {
    $generator = new XLSXGenerator(__DIR__ . '\\example\\', 'test.xlsx');
    $generator->setTemplate(__DIR__ . '\\example\\template.xlsx');

    $map = [
        'map' => [
            0 => [
                ':total' => 'Funciona',
            ]
        ]
    ];
    $generator->writeTemplate(new FieldsWriter(), $map);

    $map2 = [
        'limit' => 2,
        'map' => [
            0 => [
                ':total' => 'Funciona',
            ]
        ]
    ];
    $generator->writeTemplate(new FieldsWriter(), $map2);
} catch (\Exception $e) {
    var_dump($e->getMessage());
}
