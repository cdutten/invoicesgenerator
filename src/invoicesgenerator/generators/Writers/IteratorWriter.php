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
     */
    public function setOpts($opts)
    {
        if ($opts['limit']) {
            $this->limit = $opts['limit'];
        }

        if ($opts['map']) {
            $this->map = $this->generateMap($opts['map']);
        }
        return $this;
    }


    /**
     * @param $values
     * @return $this
     */
    public function setValues($values)
    {
        $this->values = $values;
        return $this;
    }

    /**
     * @return Spreadsheet
     */
    public function write()
    {
        // TODO: Implement write() method.
        $activeSheet = $this->spreadsheet->setActiveSheetIndex(0);
        $clonedWorksheet = clone $activeSheet->getSheetByName('Worksheet 1');
        $clonedWorksheet->setTitle();
        $this->spreadsheet->addSheet($clonedWorksheet);

        return $this->spreadsheet;
    }

    /**
     * @param $map
     * @throws PhpSpreadSheetException
     */
    private function generateMap($map)
    {
        foreach ($map as $sheet => $placeholders) {
            foreach (array_keys($placeholders) as $placeholder) {
                $placeholders[$placeholder] = $this->searchPlaceholder($sheet, $placeholder);
            }
            $this->map[$sheet] = $placeholders;
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
                    return $cell->getCoordinate();
                }
            }
        }
        return false;
    }
}