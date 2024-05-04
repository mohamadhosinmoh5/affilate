<?php

namespace App\Http\Controllers;

use App\Consultant;
use Illuminate\Http\Request;
use App\Imports\ContractImportClass;
use App\Contract;
use App\Notif;
use App\ContractDetail;
use App\Contractor;
use Hekmatinasser\Verta\Verta;
use Carbon\Carbon;
use  Maatwebsite\Excel\Facades\Excel;
use Rap2hpoutre\FastExcel\FastExcel;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use PhpOffice\PhpSpreadsheet\Collection\Cells;

// use  Excel;
// use  Excel;

class ExcelController extends Controller
{
    public $cells = [];
    public $maxid;
    public function index()
    {
        return view('voyager::export');
    }

    public function importView()
    {
        return view('voyager::import');
    }

    public function import(Request $request)
    {
        // Validate the uploaded file
        // $request->validate([
        //     'file' => 'required|mimes:xlsx,xls',
        // ]);

        // Get the uploaded file
        $file = $request->file('file');

        $reader = ReaderEntityFactory::createXLSXReader();
        $reader->open($file);
        # read each cell of each row of each sheet
        $reader->setShouldPreserveEmptyRows(true);
        $this->maxid = Contract::max('id');
        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                // foreach ($row->getCells() as $key =>  $cell) {
                //         echo $cell . ':::' . $key . '<br>';
                //     }
                $rows = $row->getCells();
                // if((!empty($rows[16]->getValue())))
                //     dd($rows[16]->getValue());

                if($rows[7]->getValue() != '')
                    $subject = 'فاينانس';
                elseif($rows[8]->getValue() != '')
                    $subject = 'آبرسانی';
                elseif($rows[9]->getValue() != '')
                    $subject = 'فاضلاب';

                $contract = '';
                $consultants = '';
                if(($rows[10]->getValue() == 'مشاور')){
                    $contract = $rows[11]->getValue();
                }else{
                    $consultants = $rows[11]->getValue();
                }
                   
                    
                $notification_48_num = '';
                $notification_48_num = '';
                if($rows[47]->getValue() == '48'){
                    $notification_48_num = '48';
                }else{
                    $notification_46_num = '46';
                }

                $this->cells[] = [
                    'designCode' => ['code' => (!empty($rows[1]->getValue())) ? $rows[1]->getValue() : 0],
                    'contract_number' => (!empty($rows[2]->getValue())) ? $rows[2]->getValue() : 0,
                    'project_code' => (!empty($rows[2]->getValue())) ? $rows[2]->getValue() : 0,
                    'contract_title' => (!empty($rows[4]->getValue())) ? $rows[4]->getValue() : '',
                    'contractDetail' => [
                        'subject' => $subject,
                        'control_system' => (!empty($rows[12]->getValue())) ? $rows[12]->getValue() : '',
                        'land_delivery_date' => (!empty($rows[26]->getValue())) ? $rows[26]->getValue() : 0,
                        'price_list' => (!empty($rows[5]->getValue())) ? $rows[5]->getValue() : 0,
                    ],
                    'city' => (!empty($rows[9]->getValue())) ? $rows[9]->getValue() : '',
                    'consultants' => ['name' => $consultants],
                    'contractors' => ['name' =>  $contract],
                    'contract_date' => (!empty($rows[13]->getValue())) ? ChnageDate($rows[13]->getValue()) : '',
                    'notice_number' => (!empty($rows[14]->getValue())) ? $rows[14]->getValue() : 0,
                    'notice_date' => (!empty($rows[15]->getValue())) ? ChnageDate($rows[15]->getValue()) : '',
                    'contract_time' => (!empty($rows[16]->getValue())) ? $rows[16]->getValue() : 0,
                    'agreement_coe' => (!empty($rows[17]->getValue())) ? $rows[17]->getValue() : 0,
                    'contract_first_amount' => (!empty($rows[24]->getValue())) ? (int)$rows[24]->getValue() : 0,
                    'contract_final_amount' => (!empty($rows[25]->getValue())) ? (int)$rows[25]->getValue() : 0,
                    'statements'=> [
                        'statement_number' => (!empty($rows[55]->getValue())) ? $rows[55]->getValue() : 0,
                        'statement_final_amount' => (!empty($rows[58]->getValue())) ? (int)$rows[58]->getValue() : 0,
                        'statement_final_letter_number' => (!empty($rows[59]->getValue())) ? (int)$rows[59]->getValue() : 0 ,
                        'statement_final_letter_date' => (!empty($rows[60]->getValue())) ? ChnageDate($rows[60]->getValue()) : 0,
                        'consultant_approved_amount' => (!empty($rows[57]->getValue())) ? (int)$rows[57]->getValue() : 0,
                        'statement_last_amount' => 0,
                        'statement_next_amount' => 0,
                        // '_period_operation_start' => '',
                        // '_period_operation_end' => '',
                        // 'physical_progress_percentage' => '',
                    ],
                    'extensions'=> [
                        'extension_period_time' => (!empty($rows[45]->getValue())) ? $rows[45]->getValue() : 0,
                        'contract_end_date' => (!empty($rows[46]->getValue())) ? ChnageDate($rows[46]->getValue()) : 0,
                        // 'allowed_days' => '',
                        'extention_number' => (!empty($rows[43]->getValue())) ? $rows[43]->getValue() : 0
                    ],
                    // 'deposits' =>[
                    //     'advance_deposit_release_letter_number_1' => '',
                    //     'advance_deposit_release_date_1' => '',
                    //     'number_letter_release_guarantee_performance_obligations' => '',
                    //     'number_release_letter_deposit_good_work' => '',
                    //     'number_release_letter_deposit_good_work_final' => '',
                    //     'advance_deposit_release_letter_number_2' => '',
                    //     'advance_deposit_release_date_2' => '',
                    //     'advance_deposit_release_letter_number_3' => '',
                    //     'advance_deposit_release_date_3' => '',
                    //     'date_release_guarantee_performance_obligations' => '',
                    //     'date_release_letter_deposit_good_work' => '',
                    //     'date_release_letter_deposit_good_work_final' => ''
                    // ],
                    'adjustment' => [
                        'statement_adjustment_number' => (!empty($rows[65]->getValue())) ? $rows[65]->getValue() : 0,
                        'statement_adjustment_number_final_amount' => (!empty($rows[64]->getValue())) ? (int)$rows[64]->getValue() : 0,
                        'statement_adjustment_number_final_letter_number' => (!empty($rows[65]->getValue())) ? $rows[65]->getValue() : 0,
                        'statement_adjustment_number_final_letter_date' => (!empty($rows[66]->getValue())) ? ChnageDate($rows[66]->getValue()) : '',
                        'statement_adjustment_number_last_amount' => 0,
                        'statement_adjustment_number_first_amount' => 0,
                        'physical_progress_percentage' => (!empty($rows[67]->getValue())) ? $rows[67]->getValue() : 0,
                    ],
                    // 'incrementAmount' => [
                    //     'status' => '',
                    //     'date' => '',
                    //     'increment_percent' => '',
                    //     'last_amount' => '',
                    //     'new_amount' => '',
                    //     'increment_number' => '',
                    // ],
                    'deliveryTermination' => [
                        'provisional_delivery_date' => (!empty($rows[50]->getValue())) ? ChnageDate($rows[50]->getValue()) : '',
                        'number_notification_temporary_delivery' => (!empty($rows[51]->getValue())) ? $rows[51]->getValue() : 0,
                        'notification_46_letter_number' => $notification_46_num,
                        'notification_48_letter_number' => $notification_48_num,
                    ],
                    // 'consultant' => [
                    //     'name' => (!empty($rows[53]->getValue())) ? $rows[53]->getValue() : '',
                    //     'connector_phone' => (!empty($rows[54]->getValue())) ? $rows[54]->getValue() : 0,
                    // ],
                    // 'contractor' => [
                    //     'name' => '',
                    //     'adress' => '',
                    //     'melli_code' => '',
                    //     'registration_number' => '',
                    //     'connector_name' => '',
                    //     'connector_phone' => '',
                    // ],
                    'certainAdjustment' => [
                        'final_adjustment_amount' => (!empty($rows[75]->getValue())) ? (int)$rows[75]->getValue() : 0,
                        'adjustment_amount_letter_number' => (!empty($rows[76]->getValue())) ? (int)$rows[76]->getValue() : 0,
                        'adjustment_amount_letter_date' => (!empty($rows[77]->getValue())) ? ChnageDate((int)$rows[77]->getValue()) : '',
                    ],
                    'certainStatement' => [
                        // 'percentage_final_physical_progress' => '',
                        'status_statement_amount' => (!empty($rows[70]->getValue())) ? (int)$rows[70]->getValue() : 0,
                        'status_statement_date' => (!empty($rows[71]->getValue())) ? ChnageDate($rows[71]->getValue()) : '',
                        'status_statement_letter_number' => (!empty($rows[72]->getValue())) ? $rows[72]->getValue() : 0,
                    ]


                    // 'contract_time' => (!empty($rows[]->getValue())) ? $rows[16]->getValue(),
                    // 'contract_time' => (!empty($rows[]->getValue())) ? $rows[16]->getValue(),
                ];
            }
        
        $reader->close();
        foreach ($this->cells as $key => $cell) {
            $this->maxid++;
           if(!empty($cell['contract_number'])){
                $contarct = new Contract;
                $contarct->id = $this->maxid;
                $contarct->fill($cell);
                $lastContact = Contractor::Where('name','=',$cell['contractors']['name'])->first();
                $lastConst = Consultant::Where('name','=',$cell['consultants']['name'])->first();

                if($cell['designCode']['code'] != 0){
                    $code =  $contarct->designCode()->create($cell['designCode']);
                    $contarct->designCode()->sync($code->id);
                }
                if($cell['consultants']['name'] != ''){
                    if(empty2($lastConst)){
                        $const1 = $contarct->consultant()->create($cell['consultants']);
                        $contarct->consultant_id = $const1->id;
                    }else{
                        $contarct->consultant_id = $lastConst->id;
                    }
                }

                if($cell['contractors']['name'] != ''){
                    if(empty2($lastContact)){
                        $cont1 = $contarct->contractor()->create($cell['contractors']);
                        $contarct->contractor_id = $cont1->id;
                    }else{
                        $contarct->contractor_id = $lastContact->id;
                    }

                }

                $contarct->save();
                $contarct->contractDetail()->create($cell['contractDetail']);
                if($cell['statements']['statement_final_amount'] != 0)
                    $contarct->statements()->create($cell['statements']);
                if($cell['adjustment']['statement_adjustment_number_final_amount'] != 0)
                    $contarct->adjustment()->create($cell['adjustment']);
                if($cell['certainAdjustment']['final_adjustment_amount'] != 0)
                    $contarct->certainAdjustment()->create($cell['certainAdjustment']);
                if($cell['certainStatement']['status_statement_amount'] != 0 )
                    $contarct->certainStatement()->create($cell['certainStatement']);

                if($cell['extensions']['extension_period_time'] != 0 )
                    $contarct->extensions()->create($cell['extensions']);
                if($cell['deliveryTermination']['provisional_delivery_date'] != 0 )
                    $contarct->deliveryTermination()->create($cell['deliveryTermination']);
                
                
           }
        }

        return redirect()->back()->with('success', 'اکسل اپلود شد ');
    }
}
}
