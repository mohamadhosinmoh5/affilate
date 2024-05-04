<?php

namespace App\Imports;


// use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use App\Contract;
use Maatwebsite\Excel\Concerns\ToModel;

class ContractImportClass implements ToModel
{
    public function model(array $row)
    {
        // Define how to create a model from the Excel row data
        dd($row);
        return new contract([
            'title' => $row[0],
            'column2' => $row[1],
            // Add more columns as needed
        ]);
    }
}
