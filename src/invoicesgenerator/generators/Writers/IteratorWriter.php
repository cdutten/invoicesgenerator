<?php
/**
 * Created by PhpStorm.
 * User: cdutten
 * Date: 15/07/2018
 * Time: 13:41
 */

namespace invoicesgenerator\generators\Writers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use invoicesgenerator\contracts\WriterInterface;
use PhpOffice\PhpSpreadsheet\Exception as PhpSpreadSheetException;
use PhpOffice\PhpSpreadsheet\Worksheet\RowIterator;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Class IteratorWriter
 * @package invoicesgenerator\generators\Writers
 */
class IteratorWriter implements WriterInterface
{
    /**
     * @var array $map
     */
    private $map = [];

    /**
     * @var array $values
     */
    private $values = [];

    /**
     * @var Spreadsheet $spreadsheet
     */
    private $spreadsheet;

    /**
     * @var int $limit
     */
    private $limit;

    /**
     * @param Spreadsheet $spreadsheet
     * @return $this
     */
    public function setSpreadsheet(Spreadsheet $spreadsheet)
    {
        $this->spreadsheet = $spreadsheet;
        return $this;
    }

    /**
     * @param array $opts
     * @return $this
     * @throws PhpSpreadSheetException
     */
    public function setOpts($opts)
    {
        if ($opts['limit']) {
            $this->limit = $opts['limit'];
        }

        if ($opts['map']) {
            $this->generateMap($opts['map']);
        }
        return $this;
    }


    /**
     * @param $opts
     * @return $this
     */
    public function setValues($opts)
    {
        $this->values = $opts['map'];
        return $this;
    }

    /**
     * @return Spreadsheet
     * @throws PhpSpreadSheetException
     *
     * // TODO: Implement write() method.
     * $activeSheet = $this->spreadsheet->setActiveSheetIndex(0);
     * $clonedWorksheet = clone $activeSheet->getSheetByName('Worksheet 1');
     * $clonedWorksheet->setTitle();
     * $this->spreadsheet->addSheet($clonedWorksheet);
     */
    public function write()
    {
        $activeSheet = $this->spreadsheet->setActiveSheetIndex($this->map['sheet']);
        $iterator = $activeSheet->getRowIterator(2, 17);
        foreach ($this->values[$this->map['sheet']] as $iteration => $values) {
            $this->loopData($iterator, $this->map['iteration'], $values);
        }

        return $this->spreadsheet;
    }

    /**
     * @param RowIterator $iterator
     * @param $placeholderColumn
     * @param $values
     * @return mixed
     */
    private function loopData(RowIterator $iterator, $placeholderColumn, $values)
    {
        foreach ($values as $placeholder => $value) {
            $coordinates = $placeholderColumn[$placeholder] . $iterator->key();
            $iterator->current()->getWorksheet()->setCellValue($coordinates, $value);
        }
        $iterator->next();
    }

    /**
     * @param $map
     * @throws PhpSpreadSheetException
     */
    private function generateMap($map)
    {
        foreach ($map as $sheet => $placeholders) {
            $coordinates = [];
            foreach (array_keys($placeholders[0]) as $placeholder) {
                $coordinates[$placeholder] = $this->searchPlaceholder($sheet, $placeholder);
            }
            $this->map = ['sheet' => $sheet,
                          'iteration' => $coordinates ];
        }
    }

    /**
     * Search the placeholder and returns the coordinate
     * @param $placeholder
     * @param $sheet
     * @throws PhpSpreadSheetException
     * @return mixed
     */
    private function searchPlaceholder($sheet, $placeholder)
    {
        $worksheet = $this->spreadsheet->setActiveSheetIndex($sheet);
        foreach ($worksheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            try {
                $cellIterator->setIterateOnlyExistingCells(true);
            } catch (PhpSpreadSheetException $e) {
                //Todo: make a Fileloger
                $e->getMessage();
            }
            foreach ($cellIterator as $cell) {
                if ($cell->getValue() == $placeholder) {
                    return $cell->getColumn();
                }
            }
        }
        return false;
    }
}