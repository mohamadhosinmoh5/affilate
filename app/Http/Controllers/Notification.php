<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contract;
use App\Notif;
use App\ContractDetail;
use App\Extension;
use Illuminate\Support\Facades\Auth;

use Hekmatinasser\Verta\Verta;
use Carbon\Carbon;
class Notification extends Controller
{
    public function UpdateNotife()
    {
        $contracts = Contract::all();
        $export = [];
        $notife = [];
        foreach ($contracts as $key => $contract) {
            $data = null;
            if(!empty2($contract->ContractDetail) && !empty($contract->ContractDetail->land_delivery_date) && strlen($contract->ContractDetail->land_delivery_date) == 9 && $contract->ContractDetail->land_delivery_date != 0){
                $data = Verta::parse(ChnageDate($contract->ContractDetail->land_delivery_date));
            
           
                if($data !== null){
                    // dd($contract->contract_time);
                    if((int)$contract->contract_time != 0 )
                        $data = $data->addMonths((int)$contract->contract_time);
                    
                    if(!empty2($contract->extensions)){
                        $maxExtention =  $contract->extensions->sum('extention_number');
                        $data = $data->addDays((int)$maxExtention);
                        
                    }
                    
                    $diffNow = $data->diffDays();
                    $now = verta('now');

                    if($diffNow <= 10 && $data->gt($now) ){
                        $n = Notif::updateOrCreate(
                            [
                                'contract_id' => $contract->id
                            ],
                            [
                            'contract_id' => $contract->id,
                            'title' => $contract->contract_title,
                            'day_avg' => (string)$diffNow,
                            // 'end_date' =>   $data->timestamp,
                            // 'read' => 0,
                            ],
                        );
                            
                        $export[] = [
                            'title' => $contract->contract_title,
                            'day_avg' => (string)$diffNow,
                            'read' => $n->read
                        ];

                    }elseif($data->lt($now)){

                        $n = Notif::updateOrCreate(
                            [
                                'contract_id' => $contract->id
                            ],
                            [
                            'contract_id' =>  $contract->id,
                            'title' => $contract->contract_title,
                            'day_avg' => 0,
                            'day_last' => (string)$diffNow,
                            // 'end_date' => $data->timestamp,
                            // 'read' => 0,
                            ]
                        );
                        
                        $export[] = [
                            'title' => $contract->contract_title,
                            'day_last' => (string)$diffNow,
                            'read' => $n->read
                        ];

                    
                    }else{
                        $export[] = [
                            'noChange' => 1,
                        ];
                    }
                }
            }
        }

        $export['count'] =  Notif::WhereIn('read',[null,0])->count();

        if($_GET['count'] != $export['count'])
            $export['refresh'] = 1;
        else
            $export['refresh'] = 0;
        
        return $export;
    }

    public function notifView()
    {
        $notifs = Notif::paginate(20);
        return view('voyager::notifacition',compact('notifs'));
    }
    public function updateRead(Request $request)
    {
       Notif::WhereIn('read',[null,0])->update(['read' => Auth::user()->id]);

        return true;

    }
}
