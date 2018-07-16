<?php
/**
 * Created by PhpStorm.
 * User: cdutten
 * Date: 15/07/2018
 * Time: 13:43
 */

namespace invoicesgenerator\generators\Writers;

use invoicesgenerator\contracts\WriterInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Exception as PhpSpreadSheetException;

/**
 * Class FieldsWriter
 * @package invoicesgenerator\generators\Writers
 *
 * //Todo: reduce the number of Foreachs if possible
 */
class FieldsWriter implements WriterInterface
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
     * Sets the spreadshet to write
     * @param Spreadsheet $spreadsheet
     * @return $this
     */
    public function setSpreadSheet(Spreadsheet $spreadsheet)
    {
        $this->spreadsheet = $spreadsheet;
        return $this;
    }

    /**
     * Set the map to search in the template
     * @param array $map
     * @throws \Exception
     * @return $this
     */
    public function setOpts($opts = [])
    {
        if ($opts['map']) {
            $this->generateMap($opts['map']);
            return $this;
        }
    }

    /**
     * Set the values to write in the cells
     * @param array $values
     * @return $this
     */
    public function setValues($values = [])
    {
        $this->values = $values;
        return $this;
    }

    /**
     * Generate the map of placeholders
     * @param array $map
     * @throws  PhpSpreadSheetException
     */
    private function generateMap($map)
    {
        //Todo: if the placeholder doesn't exist
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
        //Todo: Improve the method to work with more than one sheet
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

    /**
     * @throws \Exception
     * @return Spreadsheet $this->spreadsheet
     */
    public function write()
    {
        if (empty($this->map)) {
            throw new \Exception('Undefined map to write');
        }

        if (empty($this->values)) {
            throw new \Exception('Undefined values to write');
        }

        foreach ($this->map as $sheet => $placeholders) {
            $activeSheet = $this->spreadsheet->setActiveSheetIndex($sheet);
            foreach ($placeholders as $placeholder => $cell) {
                $activeSheet->setCellValue($cell, $this->values[$sheet][$placeholder]);
            }
        }
        return $this->spreadsheet;
    }
}
