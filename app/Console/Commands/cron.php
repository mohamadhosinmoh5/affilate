<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Contract;
use App\Extension;
use App\Notif;
use App\ContractDetail;
use Hekmatinasser\Verta\Verta;
use Carbon\Carbon;

class cron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'run notife in voyger';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $contracts = Contract::all();

        $notife = [];
        foreach ($contracts as $key => $contract) {
            $data = null;
            if(!empty2($contract->ContractDetail)){
                    $data = Verta::parse($contract->ContractDetail->land_delivery_date);
            }
           
            if($data !== null){
                $data = $data->addMonths((int)$contract->contract_time);
                
                if(!empty2($contract->extensions)){
                    $maxExtention =  $contract->extensions->sum('extention_number');
                    $data = $data->addDays((int)$maxExtention);
                    
                }
                
                $diffNow = $data->diffDays();
                $now = verta('now');

                if($diffNow <= 3 && $data->gt($now) ){
                    $notif = Notif::updateOrCreate(
                        [
                            'contract_id' => $contract->id
                        ],
                        [
                        'contract_id' => $contract->id,
                        'title' => $contract->contract_title,
                        'day_avg' => (string)$diffNow,
                        'end_date' =>   $data->timestamp
                        ],
                    );
                        
                    echo "$contract->contract_title آپدیت شد";
                
                }elseif($data->lt($now)){
                    $notif = Notif::updateOrCreate(
                        [
                            'contract_id' => $contract->id
                        ],
                        [
                        'contract_id' =>  $contract->id,
                        'title' => $contract->contract_title,
                        'day_avg' => 0,
                        'end_date' => $data->timestamp
                        ]
                    );
                       
                    echo "$contract->contract_title آپدیت شد";
                }else{
                   
                    echo 'اتفاقی رخ نداد';
                }
            }
          
            
        }
    }
}
