<?php

namespace TCG\Voyager\FormFields;

class TotalPriceText extends AbstractHandler
{
    
    protected $codename = 'totalPriceText';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('voyager::formfields.totalPriceText', [
            'row'             => $row,
            'options'         => $options,
            'dataType'        => $dataType,
            'dataTypeContent' => $dataTypeContent,
        ]);
    }
}
