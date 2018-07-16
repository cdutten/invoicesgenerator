<?php
/**
 * Created by PhpStorm.
 * User: cdutten
 * Date: 15/07/2018
 * Time: 12:27
 */

namespace Tests;

use invoicesgenerator\generators\XLSXGenerator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PHPUnit\Framework\TestCase;

class XLSXGeneratorTest extends TestCase
{
    public function testXlsxGenerate()
    {
        $filePath = __DIR__. '\\..\\' . 'example\\';
        $filename = 'test.xlsx';
        try {
            $spreadsheet = new XLSXGenerator($filePath, $filename);
            $spreadsheet->render('0', ['c1' => 'HOLA ESTEFI']);
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
        $this->assertFileExists($filePath . $filename);
        //Todo: check if the $data is in the excel
    }
}
