<?php
/**
 * Created by PhpStorm.
 * User: extendeal
 * Date: 13/06/18
 * Time: 14:30
 */

const DS = DIRECTORY_SEPARATOR;

require __DIR__ . DS . ".." . DS . "vendor" . DS ."autoload.php";

use invoicesgenerator\generators\Writers\FieldsWriter;
use invoicesgenerator\generators\Writers\IteratorWriter;
use invoicesgenerator\generators\XLSXGenerator;

try {
    $generator = new XLSXGenerator(__DIR__ . DS . '..' . DS . 'example' . DS, 'test.xlsx');
    $generator->setTemplate(__DIR__ . DS . '..' . DS . 'example' . DS . 'template.xlsx');

    $opts = [
        'map' => [
            0 => [
                'azucar' => 'Funciona',
            ]
        ]
    ];
    $generator->writeTemplate(new FieldsWriter(), $opts);

    $generator->setTemplate(__DIR__ . DS . '..' . DS . 'example' . DS . 'templateIterator.xlsx');
    $opts = [
        'limit' => 2,
        'map' => [
            0 => [
                [':nombre' => 'Loop1',
                 ':precio' => 'Loop1',
                 ':azucar' => 'Loop1',
                 ':carac'  => 'algo' ],

                [':nombre' => 'loop2',
                 ':precio' => 'loop2',
                 ':azucar' => 'diferente',
                 ':carac'  => 'algo' ],

                [':nombre' => 'loop3',
                 ':precio' => 'loop3',
                 ':azucar' => 'diferente',
                 ':carac'  => 'algo' ],

                [':nombre' => 'loop4',
                 ':precio' => 'loop4',
                 ':azucar' => 'diferente',
                 ':carac'  => 'algo' ]

            ]
        ]
    ];
    $generator->writeTemplate(new IteratorWriter(), $opts);
} catch (\Exception $e) {
    var_dump($e->getMessage());
}
