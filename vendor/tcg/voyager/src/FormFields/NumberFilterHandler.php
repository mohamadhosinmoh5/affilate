<?php

namespace TCG\Voyager\FormFields;

class NumberFilterHandler extends AbstractHandler
{
    
    protected $codename = 'numberFilter';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('voyager::formfields.numberFilter', [
            'row'             => $row,
            'options'         => $options,
            'dataType'        => $dataType,
            'dataTypeContent' => $dataTypeContent,
        ]);
    }
}
