<?php

namespace App\Exports;

use App\Contract;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;

class constract implements FromCollection
{

    use Exportable;
    public $objectData;

    public function setData($obj)
    {
        $this->objectData = $obj;
    }
    
    public function collection()
    {
        return $this->objectData;
    }
}
