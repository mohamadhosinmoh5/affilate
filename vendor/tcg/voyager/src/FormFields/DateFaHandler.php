<?php

namespace TCG\Voyager\FormFields;

class DateFaHandler extends AbstractHandler
{
    protected $codename = 'DateFa';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('voyager::formfields.date_fa', [
            'row'             => $row,
            'options'         => $options,
            'dataType'        => $dataType,
            'dataTypeContent' => $dataTypeContent,
        ]);
    }
}
