<?php
/**
 * Created by PhpStorm.
 * User: Cesar Dutten
 * Date: 13/6/2018
 * Time: 22:43
 */

namespace invoicesgenerator\generators;

use invoicesgenerator\Filesystem;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use invoicesgenerator\contracts\WriterInterface;
use PhpOffice\PhpSpreadsheet\Writer\Exception as WriterException;
use PhpOffice\PhpSpreadsheet\Reader\Exception as ReaderException;

/**
 * Class XLSXGenerator
 * @package invoicesgenerator\generators
 *
 * @property Spreadsheet $spreadsheet
 * @property string $outputDir
 * @property string $outputFileName
 */
class XLSXGenerator
{
    private $spreadsheet;
    private $outputDir;
    private $outputFileName;

    /**
     * XLSXGenerator constructor.
     * @param $outputDir
     * @param $outputFileName
     * @throws \Exception
     */
    public function __construct($outputDir, $outputFileName)
    {
        $this->setOutputDir($outputDir);
        $this->outputFileName = $outputFileName;
        $this->spreadsheet = new Spreadsheet();
    }

    /**
     * Sets the path to save the generated file
     * @param $outputDir
     * @throws \Exception
     */
    public function setOutputDir($outputDir)
    {
        if (! Filesystem::isDirectory($outputDir)) {
            throw new \Exception("The output directory ({$outputDir}) doesn\'t exist");
        }

        if (! Filesystem::isWritable($outputDir)) {
            throw new \Exception('The output directory ($outputDir) isn\'t writable');
        }
        $this->outputDir = $outputDir;
    }

    /**
     * @param $sheet
     * @param array $data
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function render($sheet, $data)
    {
        $activeSheet = $this->spreadsheet->setActiveSheetIndex($sheet);
        foreach ($data as $cell => $value) {
            $activeSheet->setCellValue($cell, $value);
        }
        $this->save();
    }

    /**
     * Saves the Excel
     * @throws WriterException
     */
    public function save()
    {
        $writer = IOFactory::createWriter($this->spreadsheet, 'Xlsx');
        $writer->save($this->outputDir . $this->outputFileName);
        $this->spreadsheet->disconnectWorksheets();
        unset($this->spreadsheet);
    }

    /**
     * @param $templateFile
     * @throws ReaderException
     */
    public function setTemplate($templateFile)
    {
        $this->spreadsheet = IOFactory::load($templateFile);
    }

    /**
     * @param WriterInterface $writer
     * @param $map
     * @throws WriterException
     */
    public function writeTemplate(WriterInterface $writer, $map)
    {
        $this->spreadsheet = $writer->setSpreadsheet($this->spreadsheet)
                                    ->setOpts($map)
                                    ->setValues($map)
                                    ->write();
        $this->save();
    }
}