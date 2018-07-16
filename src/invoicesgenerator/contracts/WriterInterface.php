<?php
/**
 * Created by PhpStorm.
 * User: cdutten
 * Date: 15/07/2018
 * Time: 15:21
 */

namespace invoicesgenerator\contracts;

use PhpOffice\PhpSpreadsheet\Spreadsheet;

interface WriterInterface
{
    /**
     * @param Spreadsheet $spreadsheet
     * @return $this
     */
    public function setSpreadsheet(Spreadsheet $spreadsheet);

    /**
     * @param $opts
     * @return $this
     */
    public function setOpts($opts);

    /**
     * @param $values
     * @return $this
     */
    public function setValues($values);

    /**
     * @return Spreadsheet
     */
    public function write();
}