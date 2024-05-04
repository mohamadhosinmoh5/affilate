<?php

namespace App\Livewire;

use Livewire\Component;
use App\Contract;
use App\Contractor;
use App\CertainAdjustment;
use App\CertainStatement;
use App\DeliveryTermination;
use App\DesignCode;
use App\Extension;
use App\Statement;
use App\Deposit;
use App\Adjustment;
use App\Consultant;
use App\Exports\constract;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Arr;
use  Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportData extends Component
{
    use WithPagination, WithoutUrlPagination;

    protected $datas;
    protected $baseDatas;
    public $typeFilter='contract';
    public $consultants;
    public $contractor;
    public $designCode;
    public $update;
    protected $query;
    public $filters = [];
    public $subFilter = [];
    public $checkContStatus='0';
    public $count;
    public $dateCont;
    public $paginates;
    public $page =1;
    public $paginate=15;
    public $dateFaContractStart;
    public $dateFaContractEnd;

    public function mount()
    {
        $this->consultants = Consultant::all();
        $this->contractor = Contractor::all();
        $this->designCode = DesignCode::all();
        $this->query = Contract::query();
       
        $this->setDatas();
    }

    public function setFilter($model,$name,$type,$value,$subFilter=null)
    {
       
        if(empty2($value)){
            unset($this->subFilter[$type][$model][$subFilter][$name]);
            unset($this->filters[$type][$model][$name]);
            $this->setDatas();
            return;
        }
      
        if($subFilter !== null)
            $this->subFilter[$type][$model][$subFilter][$name] =  $value;
        else
            $this->filters[$type][$model][$name]= $value;
        $this->setDatas();
    }


    public function setStartDate($model,$name,$date=null,$submodel=null){
        if(empty2($date)){
            unset($this->subFilter['date'][$model][$submodel][$name]);
            unset($this->filters['date'][$model][$name]);
            $this->setDatas();
            return;
        }
            
        if($submodel != null)
            $this->subFilter['date'][$model][$submodel][$name]['startDate'] =  $date;
        else
            $this->filters['date'][$model][$name]['startDate']= $date;

        $this->setDatas();
    }

    public function setEndDate($model,$name,$date=null,$submodel=null){
            if(empty2($date)){
                unset($this->subFilter['date'][$model][$submodel][$name]);
                unset($this->filters['date'][$model][$name]);
                $this->setDatas();
            return;
            }

            if($submodel != null)
                $this->subFilter['date'][$model][$submodel][$name]['endDate'] =  $date;
            else
                $this->filters['date'][$model][$name]['endDate']= $date;
        $this->setDatas();
    }

    public function checkFilter($model) :void
    {
        
            if(
                !empty2($this->filters) && array_key_exists('text',$this->filters)
                    ||
                !empty2($this->subFilter) && array_key_exists('text',$this->subFilter)
            )
            {
                if(!empty2($this->filters) && array_key_exists('text',$this->filters) && !empty2($this->filters['text'][$model])){
                    foreach ($this->filters['text'][$model] as $key => $value) {
                            $this->query->Where("$key",'LIKE',"%$value%");
                    }
                }
                if(!empty2($this->subFilter) && array_key_exists('text',$this->subFilter) && !empty2($this->subFilter['text'][$model])){
                    foreach ($this->subFilter['text'][$model] as $subModel => $values) {
                        foreach ($values as $name => $value) {
                            $this->query->WhereHas($subModel,function($q) use($name,$value){
                                $q->Where($name,'LIKE',"%$value%");
                            });
                        }
                    }
                }
            }

            if(
                !empty2($this->filters) && array_key_exists('checkBox',$this->filters)
                    ||
                !empty2($this->subFilter) && array_key_exists('checkBox',$this->subFilter)
            )
            {
                
                if(!empty2($this->filters) && array_key_exists('checkBox',$this->filters) && !empty2($this->filters['checkBox'][$model])){
                    foreach ($this->filters['checkBox'][$model] as $name => $value) {
                        $this->query->Where($name,$value);
                    }
                }
                if(!empty2($this->subFilter) && array_key_exists('checkBox',$this->subFilter) && !empty2($this->subFilter['checkBox'][$model])){
                    foreach ($this->subFilter['checkBox'][$model] as $subModel => $values) {
                        foreach ($values as $name => $value) {
                            $this->query->WhereHas($subModel,function($q) use($name,$value){
                                    $q->Where("$name",$value);
                            });
                        }
                    }
                }
            }

            if(
                !empty2($this->filters) && array_key_exists('date',$this->filters)
                    ||
                !empty2($this->subFilter) && array_key_exists('date',$this->subFilter)
            )
            {
                
                if(!empty2($this->filters) && array_key_exists('date',$this->filters) && !empty2($this->filters['date'][$model])){
                    foreach ($this->filters['date'][$model] as $name => $value) {
                        if(array_key_exists('startDate',$value))
                            $this->query->where($name,'>=',$value['startDate']);
                        if(array_key_exists('endDate',$value))
                            $this->query->where($name,'<=',$value['endDate']);
                    }
                }

                if(!empty2($this->subFilter) && array_key_exists('date',$this->subFilter) && !empty2($this->subFilter['date'][$model])){
                    foreach ($this->subFilter['date'][$model] as $subModel => $values) {
                        foreach ($values as $name => $value) {
                            $this->query->WhereHas($subModel,function($q) use($name,$value){
                                if(array_key_exists('startDate',$value))
                                    $q->where($name,'>=',$value['startDate']);
                                if(array_key_exists('endDate',$value))
                                    $q->where($name,'<=',$value['endDate']);
                            });
                        }
                    }
                }
            }

    }

    public function setFilterView($type)
    {
        $this->filters = [];
        $this->subFilter = [];
        $this->typeFilter=$type;
        $this->setDatas($type);
    }

    public function nextPage($page)
    {
        $this->page = $page + 1;
        $this->setDatas();
    }

    public function lastPage($page)
    {
        $this->page = $page - 1;
        $this->setDatas();
    }

    public function changePage($page)
    {
        $this->page = $page;
        $this->setDatas();
    }

    public function setDatas($paginate = true)
    {
        if($this->typeFilter=='contract'){
            $this->query = Contract::query();
            $this->query->with(
                'statements','contractDetail',
                'extensions','deliveryTermination','certainAdjustment',
                'certainStatement','adjustment','deposit',
                'consultant','contractor','designCode'
            );
            $this->checkFilter('contract');
            
            if($paginate){
                $this->paginates = [
                    'total'=>$this->query->count(),
                    'perPage' => $this->paginate,
                    'totalPage' => $this->query->count() / $this->paginate,
                    'currentPage' => $this->page,
                    'skip' => $this->page * $this->paginate
                 ];

                if($this->paginates['total'] > 15)
                    $this->query->skip($this->paginates['skip']);
                $this->datas = $this->query->take($this->paginate)->get();

            }else
                $this->datas = $this->query->get();
            
            if($paginate)
                $this->baseDatas = $this->datas;
            else
                $this->baseDatas = null;
                $this->count = $this->query->count();
            if(!empty2($this->datas))
                $this->datas =  $this->datas->map(function($item){
                    $lastKey = !empty2($item->statements) ? count($item->statements) -1 : '';
                    $lastKeyAd = !empty2($item->adjustment) ? count($item->adjustment) -1: '';
                    $lastdes = !empty2($item->designCode) ? count($item->designCode) -1 :'';
                    
                    return [
                        'نام شهرستان' => (!empty2($item)) ? $item->city: '___',
                        'نام مجتمع' =>  (!empty2($item)) ? $item->complex_name: '___',
                        'نوع پروژه' =>  (!empty2($item->contractDetail)) ? $item->contractDetail->contract_subject: '___',
                        // 'طرح' => (!empty2($item->designCode)) ? $item->designCode[$lastdes]->title: '___',
                        'طرح' => (!empty2($item->designCode)) ? FieldsToString($item->designCode,'title') : '___',
                        'نام پروژه' => (!empty2($item)) ? $item->contract_title: '___',
                        'تاریخ قرار داد ' => (!empty2($item)) ? $item->contract_date: '___',
                        'شماره قرار داد ' => (!empty2($item)) ? $item->contract_number: '___',
                        'پیمانکار' => (!empty2($item->contractor)) ? $item->contractor->name: '___',
                        'مشاور' =>  (!empty2($item->consultant)) ? $item->consultant->name: '___',
                        'مدت قرارداد' => (!empty2($item)) ? $item->contract_time: '___',
                        'مبلغ اولیه قرارداد (ريال)' => (!empty2($item)) ? number_format($item->contract_first_amount): '___',
                        'مبلغ نهایی قرارداد (ريال) با احتساب افزایش 25 درصد' => ($item) ? number_format($item->contract_final_amount): '___',
                        'ضریب پیمان' => ($item) ? $item->agreement_coe: '___',
                        'وضعیت قرارداد' => ($item) ? $item->contract_status: '___',
                        // more
                        'درصد پرداخت نقد' => (!empty2($item->cash_percent_method)) ? $item->cash_percent_method: '___',
                        'درصد پرداخت اسناد خزانه' => (!empty2($item->designCode)) ? $item->document_percent_method: '___',
                        //DETAIL
                        'فهرست بهای برآورد' => ($item->contractDetail) ? $item->contractDetail->price_list: '___',
                        'دستگاه نظارت' =>($item->contractDetail) ? $item->contractDetail->control_system: '___',
                        'شماره ابلاغيه' => ($item->contractDetail) ? $item->contractDetail->notice_number: '___',
                        'تاریخ ابلاغ' => ($item->contractDetail) ? $item->contractDetail->notice_date: '___',
                        'تاریخ تحویل زمین' => ($item->contractDetail) ? $item->contractDetail->land_delivery_date: '___',
                        // TAMDID
                        'شماره تمدید' =>  ($item->extensions) ? $item->extensions->extention_number: '___',
                        'مدت تمدید ابلاغ شده(روز)' =>  ($item->extensions) ? $item->extensions->extension_period_time: '___',
                        'تاریخ پایان قرارداد + تمدید ابلاغ شده' => ($item->extensions) ? $item->extensions->contract_end_date: '___',
                        'روزهای مجاز' => ($item->extensions) ? $item->extensions->allowed_days: '___',
                        //Tahvil & khateme
                        'شماره خاتمه پیمان' => (!empty2($item->deliveryTermination) ) ? $item->deliveryTermination->contract_termination_number: '___',
                        'تاریخ خاتمه پیمان' => (!empty2($item->deliveryTermination) ) ? $item->deliveryTermination->contract_termination_date: '___',
                        'تاریخ تحویل موقت (صورتجلسه)' => (!empty2($item->deliveryTermination) ) ? $item->deliveryTermination->minutes_number: '___',
                        'شنامه ابلاغ تحویل موقت' => (!empty2($item->deliveryTermination) ) ? $item->deliveryTermination->number_notification_temporary_delivery: '___',
                        'تاریخ تحویل موقت (صورتجلسه) '=> (!empty2($item->deliveryTermination) ) ? $item->deliveryTermination->provisional_delivery_date: '___',
                        'ش نامه ابلاغ تحویل موقت' => (!empty2($item->deliveryTermination) ) ? $item->deliveryTermination->number_notification_temporary_delivery: '___',
                        'شماره صورتجلسه' => (!empty2($item->deliveryTermination) ) ? $item->deliveryTermination->minutes_number: '___',
                        'تاریخ ابلاغ 46' => (!empty2($item->deliveryTermination) ) ? $item->deliveryTermination->notification_46_date: '___',
                        'شماره نامه ابلاغ 46' => (!empty2($item->deliveryTermination) ) ? $item->deliveryTermination->notification_46_letter_number: '___',
                        'تاریخ ابلاغ 48' => (!empty2($item->deliveryTermination) ) ? $item->deliveryTermination->notification_48_date: '___',
                        'شماره نامه ابلاغ 48' => (!empty2($item->deliveryTermination) ) ? $item->deliveryTermination->notification_48_letter_number: '___',
                        'تاریخ تحویل قطعی(صورتجلسه)' => (!empty2($item->deliveryTermination) ) ? $item->deliveryTermination->definite_delivery_date: '___',
                        'شماره نامه ابلاغ تحویل قطعی' =>  (!empty2($item->deliveryTermination) ) ? $item->deliveryTermination->Confirmation_delivery_letter_number: '___',
                        
                        //seporde
                        'شماره نامه آزادسازی ضمانتنامه سپرده پیش پرداخت 1' => (!empty2($item->deposit) ) ? $item->deposit->advance_deposit_release_letter_number_1: '___',
                        'تاریخ آزادسازی ضمانتنامه سپرده پیش پرداخت 1' => (!empty2($item->deposit) ) ? $item->deposit->advance_deposit_release_date_1: '___',
                        'شماره نامه آزادسازی ضمانتنامه سپرده پیش پرداخت 2' => (!empty2($item->deposit) ) ? $item->deposit->advance_deposit_release_letter_number_2: '___',
                        'تاریخ آزادسازی ضمانتنامه سپرده پیش پرداخت 2' => (!empty2($item->deposit) ) ? $item->deposit->advance_deposit_release_date_2	: '___',
                        'شماره نامه آزادسازی ضمانتنامه سپرده پیش پرداخت 3' => (!empty2($item->deposit) ) ? $item->deposit->advance_deposit_release_letter_number_3: '___',
                        'تاریخ آزادسازی ضمانتنامه سپرده پیش پرداخت 3' => (!empty2($item->deposit) ) ? $item->deposit->advance_deposit_release_date_3: '___',
                        'تاریخ نامه آزادسازی ضمانتنامه اجرای تعهدات' => (!empty2($item->deposit) ) ? $item->deposit->date_release_guarantee_performance_obligations: '___',
                        'شماره نامه آزادسازی ضمانتنامه اجرای تعهدات' =>   (!empty2($item->deposit) ) ? $item->deposit->number_letter_release_guarantee_performance_obligations: '___',
                        'شماره نامه آزادسازی سپرده حسن انجام کار(نیمه اول)' => (!empty2($item->deposit) ) ? $item->deposit->number_release_letter_deposit_good_work: '___',
                        'تاریخ نامه آزادسازی سپرده حسن انجام کار(نیمه اول)' => (!empty2($item->deposit) ) ? $item->deposit->date_release_letter_deposit_good_work: '___',
                        'تاریخ نامه آزادسازی سپرده حسن انجام کار(نهایی)' => (!empty2($item->deposit) ) ? $item->deposit->date_release_letter_deposit_good_work_final: '___',
                        'شماره نامه آزادسازی سپرده حسن انجام کار(نهایی)' =>  (!empty2($item->deposit) ) ? $item->deposit->number_release_letter_deposit_good_work_final: '___',
                        //surat vaziat
                        'مبلغ صورت وضعیت قبلی' =>  (!empty2($item->statements) ) ?  $item->statements[$lastKey]->statement_last_amount: '___',
                        'مبلغ صورت وضعیت فعلی' =>  (!empty2($item->statements) ) ?  $item->statements[$lastKey]->statement_final_amount: '___',
                        'خالص صورت وضعیت فعلی' =>  (!empty2($item->statements) ) ?  $item->statements[$lastKey]->statement_next_amount: '___',
                        'شروع دوره کارکرد صورت وضعیت' =>  (!empty2($item->statements) ) ?  $item->statements[$lastKey]->_period_operation_start: '___',
                        'پایان دوره کارکرد صورت وضعیت' =>  (!empty2($item->statements) ) ?  $item->statements[$lastKey]->_period_operation_end: '___',
                        'درصد پیشرفت فیزیکی تا این مرحله' => (!empty2($item->statements) ) ?  $item->statements[$lastKey]->physical_progress_percentage: '___',                        
                        'شماره صورت وضعیت' =>  (!empty2($item->statements) ) ?  $item->statements[$lastKey]->statement_number: '___',
                        'مبلغ آخرین صورت وضعیت' =>(!empty2($item->statements) ) ? number_format($item->statements[$lastKey]->statement_final_amount): '___',
                        'شماره نامه صورت وضعیت' =>(!empty2($item->statements) ) ? $item->statements[$lastKey]->statement_final_letter_number: '___',
                        'تاریخ نامه صورت وضعیت' => (!empty2($item->statements) ) ? $item->statements[$lastKey]->statement_final_letter_date: '___',
                        'مبلغ تایید شده مشاور' => (!empty2($item->statements) ) ? number_format($item->statements[$lastKey]->consultant_approved_amount): '___',
                        // 'شماره صورت وضعیت','مبلغ آخرین صورت وضعیت','شماره نامه آخرین صورت وضعیت','تاریخ نامه آخرین صورت وضعیت',
                        // 'مبلغ تایید شده مشاور' => ,
                        'مبلغ صورت وضعیت تعدیل قبلی' =>  (!empty2($item->adjustment) ) ?  number_format($item->adjustment[$lastKeyAd]->statement_adjustment_number_last_amount): '___',
                        'مبلغ صورت وضعیت تعدیل فعلی' =>  (!empty2($item->adjustment) ) ?  number_format($item->adjustment[$lastKeyAd]->statement_adjustment_number_final_amount): '___',
                        'خالص صورت وضعیت تعدیل فعلی' =>  (!empty2($item->adjustment) ) ?  number_format($item->adjustment[$lastKeyAd]->statement_adjustment_number_first_amount): '___',
                        'درصد پیشرفت فیزیکی تا این مرحله' => (!empty2($item->adjustment) ) ?  $item->adjustment[$lastKeyAd]->physical_progress_percentage: '___',
                        'شماره صورت وضعیت تعدیل' => (!empty2($item->adjustment) ) ? $item->adjustment[$lastKeyAd]->statement_adjustment_number: '___',
                        'مبلغ آخرین صورت وضعیت تعدیل' => (!empty2($item->adjustment) ) ? number_format($item->adjustment[$lastKeyAd]->statement_adjustment_number_final_amount): '___',
                        'شماره نامه صورت وضعیت تعدیل'=>(!empty2($item->adjustment) ) ? $item->adjustment[$lastKeyAd]->statement_adjustment_number_final_letter_number: '___',
                        'تاریخ نامه صورت وضعیت تعدیل' => (!empty2($item->adjustment) ) ? $item->adjustment[$lastKeyAd]->statement_adjustment_number_final_letter_date: '___',
                        // 'شماره تمدید',
                        //tadil qat
                        'مبلغ تعدیل قطعی' => (!empty2($item->certainAdjustment) ) ? number_format($item->certainAdjustment->final_adjustment_amount): '___',
                        'شماره نامه تعدیل قطعی' => (!empty2($item->certainAdjustment) ) ? $item->certainAdjustment->adjustment_amount_letter_number: '___',
                        'تاریخ نامه تعدیل قطعی' => (!empty2($item->certainAdjustment) ) ? $item->certainAdjustment->adjustment_amount_letter_date: '___',
                        //suratvaziat Qati
                        'درصد آخرین پیشرفت فیزیکی' =>  (!empty2($item->certainStatement) ) ? $item->certainStatement->percentage_final_physical_progress: '___',
                        'مبلغ صورت وضعیت قطعی'=> (!empty2($item->certainStatement) ) ? number_format($item->certainStatement->status_statement_amount): '___',
                        'تاریخ صورت وضعیت قطعی'=>(!empty2($item->certainStatement) ) ? $item->certainStatement->status_statement_date: '___',
                        'شماره نامه صورت وضعیت قطعی' => (!empty2($item->certainStatement) ) ? $item->certainStatement->status_statement_letter_number: '___',
                    ];
                });
        }

        if($this->typeFilter=='DeliveryTermination'){
            $this->query = DeliveryTermination::query();
            $this->checkFilter('DeliveryTermination');
            if($paginate)
                {
                $this->paginates = [
                    'total'=>$this->query->count(),
                    'perPage' => $this->paginate,
                    'totalPage' => $this->query->count() / $this->paginate,
                    'currentPage' => $this->page,
                    'skip' => $this->page * $this->paginate
                 ];
                if($this->paginates['total'] > 15)
                    $this->query->skip($this->paginates['skip']);
                $this->datas = $this->query->take($this->paginate)->get();

            }
            else
                $this->datas = $this->query->with('contract')->get();

            if($paginate)
                $this->baseDatas = $this->datas;
            else 
                $this->baseDatas = null;
$this->count = $this->query->count();
            if(!empty2($this->datas))
                $this->datas = $this->datas->map(function($item){
                    return [
                        'نام شهرستان' => (!empty2($item->contract)) ? $item->contract->city: '___',
                        'نام مجتمع' =>  (!empty2($item->contract)) ? $item->contract->complex_name: '___',
                        'نوع پروژه' =>  (!empty2($item->contract) && !empty2($item->contract->contractDetail) ) ? $item->contract->contractDetail->contract_subject: '___',
                        'طرح' => (!empty2($item->contract->designCode)) ? FieldsToString($item->contract->designCode,'title') : '___',
                        'نام پروژه' => (!empty2($item->contract)) ? $item->contract->contract_title: '___',
                        'تاریخ قرار داد ' => (!empty2($item->contract)) ? $item->contract->contract_date: '___',
                        'شماره قرار داد ' => (!empty2($item->contract)) ? $item->contract->contract_number: '___',
                        'پیمانکار' => (!empty2($item->contract) && !empty2($item->contract->contractor)) ? $item->contract->contractor->name: '___',
                        'مشاور' =>  (!empty2($item->contract) && !empty2($item->contract->consultant)) ? $item->contract->consultant->name: '___',
                        'مدت قرارداد' => (!empty2($item->contract)) ? number_format($item->statement_adjustment_number_final_amount): '___',
                        'مبلغ اولیه قرارداد (ريال)' => (!empty2($item->contract)) ? number_format($item->contract->contract_first_amount): '___',
                        'مبلغ نهایی قرارداد (ريال) با احتساب افزایش 25 درصد' => ($item->contract) ? number_format($item->contract->contract_final_amount): '___',
                        'ضریب پیمان' => ($item->contract) ? $item->contract->agreement_coe: '___',
                        'وضعیت قرارداد' => ($item->contract) ? $item->contract->contract_status: '___',
                        //surat vaziat
                        'شماره خاتمه پیمان' => (!empty2($item->contract_termination_number) ) ? $item->contract_termination_number: '___',
                        'تاریخ خاتمه پیمان' => (!empty2($item->contract_termination_date) ) ? $item->contract_termination_date: '___',
                        'تاریخ تحویل موقت (صورتجلسه)' => (!empty2($item->minutes_number) ) ? $item->minutes_number: '___',
                        'شنامه ابلاغ تحویل موقت' => (!empty2($item->number_notification_temporary_delivery) ) ? $item->number_notification_temporary_delivery: '___',
                        'تاریخ تحویل موقت (صورتجلسه) '=> (!empty2($item->provisional_delivery_date) ) ? $item->provisional_delivery_date: '___',
                        'ش نامه ابلاغ تحویل موقت' => (!empty2($item->number_notification_temporary_delivery) ) ? $item->number_notification_temporary_delivery: '___',
                        'شماره صورتجلسه' => (!empty2($item->minutes_number) ) ? $item->minutes_number: '___',
                        'تاریخ ابلاغ 46' => (!empty2($item->notification_46_date) ) ? $item->notification_46_date: '___',
                        'شماره نامه ابلاغ 46' => (!empty2($item->notification_46_letter_number) ) ? $item->notification_46_letter_number: '___',
                        'تاریخ ابلاغ 48' => (!empty2($item->notification_48_date) ) ? $item->notification_48_date: '___',
                        'شماره نامه ابلاغ 48' => (!empty2($item->notification_48_letter_number) ) ? $item->notification_48_letter_number: '___',
                        'تاریخ تحویل قطعی(صورتجلسه)' => (!empty2($item->definite_delivery_date) ) ? $item->definite_delivery_date: '___',
                        'شماره نامه ابلاغ تحویل قطعی' =>  (!empty2($item->Confirmation_delivery_letter_number) ) ? $item->Confirmation_delivery_letter_number: '___',
                    ];
                });
       }

        if($this->typeFilter=='Extension'){
            $this->query = Extension::query();
            $this->checkFilter('Extension');
            if($paginate)
                {
                $this->paginates = [
                    'total'=>$this->query->count(),
                    'perPage' => $this->paginate,
                    'totalPage' => $this->query->count() / $this->paginate,
                    'currentPage' => $this->page,
                    'skip' => $this->page * $this->paginate
                 ];
                if($this->paginates['total'] > 15)
                    $this->query->skip($this->paginates['skip']);
                $this->datas = $this->query->take($this->paginate)->get();

            }
            else
                $this->datas = $this->query->with('contract')->get();
            if($paginate)
                $this->baseDatas = $this->datas;
            else 
                $this->baseDatas = null;
$this->count = $this->query->count();
            if(!empty2($this->datas))
                $this->datas = $this->datas->map(function($item){
                    return [
                        'نام شهرستان' => (!empty2($item->contract)) ? $item->contract->city: '___',
                        'نام مجتمع' =>  (!empty2($item->contract)) ? $item->contract->complex_name: '___',
                        'نوع پروژه' =>  (!empty2($item->contract) && !empty2($item->contract->contractDetail) ) ? $item->contract->contractDetail->contract_subject: '___',
                        'طرح' => (!empty2($item->contract->designCode)) ? FieldsToString($item->contract->designCode,'title') : '___',
                        'نام پروژه' => (!empty2($item->contract)) ? $item->contract->contract_title: '___',
                        'تاریخ قرار داد ' => (!empty2($item->contract)) ? $item->contract->contract_date: '___',
                        'شماره قرار داد ' => (!empty2($item->contract)) ? $item->contract->contract_number: '___',
                        'پیمانکار' => (!empty2($item->contract) && !empty2($item->contract->contractor)) ? $item->contract->contractor->name: '___',
                        'مشاور' =>  (!empty2($item->contract) && !empty2($item->contract->consultant)) ? $item->contract->consultant->name: '___',
                        'مدت قرارداد' => (!empty2($item->contract)) ? number_format($item->statement_adjustment_number_final_amount): '___',
                        'مبلغ اولیه قرارداد (ريال)' => (!empty2($item->contract)) ? number_format($item->contract->contract_first_amount): '___',
                        'مبلغ نهایی قرارداد (ريال) با احتساب افزایش 25 درصد' => ($item->contract) ? number_format($item->contract->contract_final_amount): '___',
                        'ضریب پیمان' => ($item->contract) ? $item->contract->agreement_coe: '___',
                        'وضعیت قرارداد' => ($item->contract) ? $item->contract->contract_status: '___',
                        //surat vaziat
                        'شماره تمدید' =>  ($item->extention_number) ? $item->extention_number: '___',
                        'مدت تمدید ابلاغ شده(روز)' =>  ($item->extension_period_time) ? $item->extension_period_time: '___',
                        'تاریخ پایان قرارداد + تمدید ابلاغ شده' => ($item->contract_end_date) ? $item->contract_end_date: '___',
                        'روزهای مجاز' => ($item->allowed_days) ? $item->allowed_days: '___',
                    ];
                });
       }

       if($this->typeFilter=='Statement'){
            $this->query = Statement::query();
            $this->checkFilter('Statement');
               if($paginate)
                {
                $this->paginates = [
                    'total'=>$this->query->count(),
                    'perPage' => $this->paginate,
                    'totalPage' => $this->query->count() / $this->paginate,
                    'currentPage' => $this->page,
                    'skip' => $this->page * $this->paginate
                 ];
                if($this->paginates['total'] > 15)
                    $this->query->skip($this->paginates['skip']);
                $this->datas = $this->query->take($this->paginate)->get();

            }
            else
                $this->datas = $this->query->with('contract')->get();
            if($paginate)
                $this->baseDatas = $this->datas;
            else 
                $this->baseDatas = null;
            
                $this->count = $this->query->count();
            if(!empty2($this->datas))
                $this->datas = $this->datas->map(function($item){
                    return [
                        'نام شهرستان' => (!empty2($item->contract)) ? $item->contract->city: '___',
                        'نام مجتمع' =>  (!empty2($item->contract)) ? $item->contract->complex_name: '___',
                        'نوع پروژه' =>  (!empty2($item->contract) && !empty2($item->contract->contractDetail) ) ? $item->contract->contractDetail->contract_subject: '___',
                        'طرح' => (!empty2($item->contract->designCode)) ? FieldsToString($item->contract->designCode,'title') : '___',
                        'نام پروژه' => (!empty2($item->contract)) ? $item->contract->contract_title: '___',
                        'تاریخ قرار داد ' => (!empty2($item->contract)) ? $item->contract->contract_date: '___',
                        'شماره قرار داد ' => (!empty2($item->contract)) ? $item->contract->contract_number: '___',
                        'پیمانکار' => (!empty2($item->contract) && !empty2($item->contract->contractor)) ? $item->contract->contractor->name: '___',
                        'مشاور' =>  (!empty2($item->contract) && !empty2($item->contract->consultant)) ? $item->contract->consultant->name: '___',
                        'مدت قرارداد' => (!empty2($item->contract)) ? number_format($item->statement_adjustment_number_final_amount): '___',
                        'مبلغ اولیه قرارداد (ريال)' => (!empty2($item->contract)) ? number_format($item->contract->contract_first_amount): '___',
                        'مبلغ نهایی قرارداد (ريال) با احتساب افزایش 25 درصد' => ($item->contract) ? number_format($item->contract->contract_final_amount): '___',
                        'ضریب پیمان' => ($item->contract) ? $item->contract->agreement_coe: '___',
                        'وضعیت قرارداد' => ($item->contract) ? $item->contract->contract_status: '___',
                        //surat vaziat
                        'مبلغ صورت وضعیت قبلی' =>  (!empty2($item->statement_last_amount) ) ?  $item->statement_last_amount: '___',
                        'مبلغ صورت وضعیت فعلی' =>  (!empty2($item->statement_final_amount) ) ?  $item->statement_final_amount: '___',
                        'خالص صورت وضعیت فعلی' =>  (!empty2($item->statement_next_amount) ) ?  $item->statement_next_amount: '___',
                        'شروع دوره کارکرد صورت وضعیت' =>  (!empty2($item->_period_operation_start) ) ?  $item->_period_operation_start: '___',
                        'پایان دوره کارکرد صورت وضعیت' =>  (!empty2($item->_period_operation_end) ) ?  $item->_period_operation_end: '___',
                        'درصد پیشرفت فیزیکی تا این مرحله' => (!empty2($item->physical_progress_percentage) ) ?  $item->physical_progress_percentage: '___',                        
                        'شماره صورت وضعیت' =>  (!empty2($item->statements) ) ?  $item->statement_number: '___',
                        'شماره صورت وضعیت' =>  (!empty2($item->statement_number) ) ?  $item->statement_number: '___',
                        'مبلغ آخرین صورت وضعیت' =>(!empty2($item->statement_final_amount) ) ? $item->statement_final_amount: '___',
                        'شماره نامه آخرین صورت وضعیت' =>(!empty2($item->statement_final_letter_number) ) ? $item->statement_final_letter_number: '___',
                        'تاریخ نامه آخرین صورت وضعیت' => (!empty2($item->statement_final_letter_date) ) ? $item->statement_final_letter_date: '___',
                        'مبلغ تایید شده مشاور' => (!empty2($item->consultant_approved_amount) ) ? $item->consultant_approved_amount: '___',
                    ];
                });
       }

       if($this->typeFilter=='Adjustment'){
            $this->query = Adjustment::query();
            $this->checkFilter('Adjustment');
               if($paginate)
                {
                $this->paginates = [
                    'total'=>$this->query->count(),
                    'perPage' => $this->paginate,
                    'totalPage' => $this->query->count() / $this->paginate,
                    'currentPage' => $this->page,
                    'skip' => $this->page * $this->paginate
                 ];
                if($this->paginates['total'] > 15)
                    $this->query->skip($this->paginates['skip']);
                $this->datas = $this->query->take($this->paginate)->get();

            }
            else
                $this->datas = $this->query->with('contract')->get();
            if($paginate)
                $this->baseDatas = $this->datas;
            else
                $this->baseDatas = null;
            $this->count = $this->query->count();
            if(!empty2($this->datas))
                $this->datas = $this->datas->map(function($item){
                    return [
                        'نام شهرستان' => (!empty2($item->contract)) ? $item->contract->city: '___',
                        'نام مجتمع' =>  (!empty2($item->contract)) ? $item->contract->complex_name: '___',
                        'نوع پروژه' =>  (!empty2($item->contract) && !empty2($item->contract->contractDetail) ) ? $item->contract->contractDetail->contract_subject: '___',
                        'طرح' => (!empty2($item->contract) && !empty2($item->contract->designCode)) ? FieldsToString($item->contract->designCode,'title') : '___',
                        'نام پروژه' => (!empty2($item->contract)) ? $item->contract->contract_title: '___',
                        'تاریخ قرار داد ' => (!empty2($item->contract)) ? $item->contract->contract_date: '___',
                        'شماره قرار داد ' => (!empty2($item->contract)) ? $item->contract->contract_number: '___',
                        'پیمانکار' => (!empty2($item->contract) && !empty2($item->contract->contractor)) ? $item->contract->contractor->name: '___',
                        'مشاور' =>  (!empty2($item->contract) && !empty2($item->contract->consultant)) ? $item->contract->consultant->name: '___',
                        'مدت قرارداد' => (!empty2($item->contract)) ? number_format($item->statement_adjustment_number_final_amount): '___',
                        'مبلغ اولیه قرارداد (ريال)' => (!empty2($item->contract)) ? number_format($item->contract->contract_first_amount): '___',
                        'مبلغ نهایی قرارداد (ريال) با احتساب افزایش 25 درصد' => ($item->contract) ? number_format($item->contract->contract_final_amount): '___',
                        'ضریب پیمان' => ($item->contract) ? $item->contract->agreement_coe: '___',
                        'وضعیت قرارداد' => ($item->contract) ? $item->contract->contract_status: '___',

                        'مبلغ صورت وضعیت تعدیل قبلی' =>  (!empty2($item->statement_adjustment_number_last_amount) ) ? number_format($item->statement_adjustment_number_last_amount): '___',
                        'مبلغ صورت وضعیت تعدیل فعلی' =>  (!empty2($item->statement_adjustment_number_final_amount) ) ? number_format($item->statement_adjustment_number_final_amount): '___',
                        'خالص صورت وضعیت تعدیل فعلی' =>  (!empty2($item->statement_adjustment_number_first_amount) ) ?  number_format($item->statement_adjustment_number_first_amount): '___',
                        'درصد پیشرفت فیزیکی تا این مرحله' => (!empty2($item->physical_progress_percentage) ) ?  $item->physical_progress_percentage: '___',
                        'شماره صورت وضعیت تعدیل' => (!empty2($item->statement_adjustment_number) ) ? $item->statement_adjustment_number: '___',
                        'مبلغ آخرین صورت وضعیت تعدیل' => (!empty2($item->statement_adjustment_number) ) ? number_format($item->statement_adjustment_number_final_amount): '___',
                        'شماره نامه آخرین صورت وضعیت تعدیل'=>(!empty2($item->statement_adjustment_number) ) ? $item->statement_adjustment_number_final_letter_number: '___',
                        'تاریخ نامه آخرین صورت وضعیت تعدیل' => (!empty2($item->statement_adjustment_number) ) ? $item->statement_adjustment_number_final_letter_date: '___',
                    
                    ];
                });
        }


        if($this->typeFilter=='CertainStatement'){
            $this->query = CertainStatement::query();
            $this->checkFilter('CertainStatement');
               if($paginate)
                {
                $this->paginates = [
                    'total'=>$this->query->count(),
                    'perPage' => $this->paginate,
                    'totalPage' => $this->query->count() / $this->paginate,
                    'currentPage' => $this->page,
                    'skip' => $this->page * $this->paginate
                 ];
                if($this->paginates['total'] > 15)
                    $this->query->skip($this->paginates['skip']);
                $this->datas = $this->query->take($this->paginate)->get();

            }
            else
                $this->datas = $this->query->with('contract')->get();
            if($paginate)
                $this->baseDatas = $this->datas;
            else 
                $this->baseDatas = null;
$this->count = $this->query->count();
            if(!empty2($this->datas))
                $this->datas = $this->datas->map(function($item){
                    return [
                        'نام شهرستان' => (!empty2($item->contract)) ? $item->contract->city: '___',
                        'نام مجتمع' =>  (!empty2($item->contract)) ? $item->contract->complex_name: '___',
                        'نوع پروژه' =>  (!empty2($item->contract) && !empty2($item->contract->contractDetail) ) ? $item->contract->contractDetail->contract_subject: '___',
                        'کد طرح' => (!empty2($item->contract)) ? $item->contract->project_code: '___',
                        'نام پروژه' => (!empty2($item->contract)) ? $item->contract->contract_title: '___',
                        'تاریخ قرار داد ' => (!empty2($item->contract)) ? $item->contract->contract_date: '___',
                        'شماره قرار داد ' => (!empty2($item->contract)) ? $item->contract->contract_number: '___',
                        'پیمانکار' => (!empty2($item->contract) && !empty2($item->contract->contractor)) ? $item->contract->contractor->name: '___',
                        'مشاور' =>  (!empty2($item->contract) && !empty2($item->contract->consultant)) ? $item->contract->consultant->name: '___',
                        'مدت قرارداد' => (!empty2($item->contract)) ? number_format($item->statement_adjustment_number_final_amount): '___',
                        'مبلغ اولیه قرارداد (ريال)' => (!empty2($item->contract)) ? number_format($item->contract->contract_first_amount): '___',
                        'مبلغ نهایی قرارداد (ريال) با احتساب افزایش 25 درصد' => ($item->contract) ? number_format($item->contract->contract_final_amount): '___',
                        'ضریب پیمان' => ($item->contract) ? $item->contract->agreement_coe: '___',
                        'وضعیت قرارداد' => ($item->contract) ? $item->contract->contract_status: '___',

                        'درصد آخرین پیشرفت فیزیکی' =>  (!empty2($item->percentage_final_physical_progress) ) ? $item->percentage_final_physical_progress: '___',
                        'مبلغ صورت وضعیت قطعی'=> (!empty2($item->status_statement_amount) ) ? $item->status_statement_amount: '___',
                        'تاریخ صورت وضعیت قطعی'=>(!empty2($item->status_statement_date) ) ? $item->status_statement_date: '___',
                        'شماره نامه صورت وضعیت قطعی' => (!empty2($item->status_statement_letter_number) ) ? $item->status_statement_letter_number: '___',
                    ];
                });
        }

        if($this->typeFilter=='CertainAdjustment'){
            $this->query = CertainAdjustment::query();
            $this->checkFilter('CertainAdjustment');
               if($paginate)
                {
                $this->paginates = [
                    'total'=>$this->query->count(),
                    'perPage' => $this->paginate,
                    'totalPage' => $this->query->count() / $this->paginate,
                    'currentPage' => $this->page,
                    'skip' => $this->page * $this->paginate
                 ];
                if($this->paginates['total'] > 15)
                    $this->query->skip($this->paginates['skip']);
                $this->datas = $this->query->take($this->paginate)->get();

            }
            else
                $this->datas = $this->query->with('contract')->get();
            if($paginate)
                $this->baseDatas = $this->datas;
            else 
                $this->baseDatas = null;
$this->count = $this->query->count();
            if(!empty2($this->datas))
                $this->datas = $this->datas->map(function($item){
                    return [
                        'نام شهرستان' => (!empty2($item->contract)) ? $item->contract->city: '___',
                        'نام مجتمع' =>  (!empty2($item->contract)) ? $item->contract->complex_name: '___',
                        'نوع پروژه' =>  (!empty2($item->contract) && !empty2($item->contract->contractDetail) ) ? $item->contract->contractDetail->contract_subject: '___',
                        'کد طرح' => (!empty2($item->contract)) ? $item->contract->project_code: '___',
                        'نام پروژه' => (!empty2($item->contract)) ? $item->contract->contract_title: '___',
                        'تاریخ قرار داد ' => (!empty2($item->contract)) ? $item->contract->contract_date: '___',
                        'شماره قرار داد ' => (!empty2($item->contract)) ? $item->contract->contract_number: '___',
                        'پیمانکار' => (!empty2($item->contract) && !empty2($item->contract->contractor)) ? $item->contract->contractor->name: '___',
                        'مشاور' =>  (!empty2($item->contract) && !empty2($item->contract->consultant)) ? $item->contract->consultant->name: '___',
                        'مدت قرارداد' => (!empty2($item->contract)) ? number_format($item->statement_adjustment_number_final_amount): '___',
                        'مبلغ اولیه قرارداد (ريال)' => (!empty2($item->contract)) ? number_format($item->contract->contract_first_amount): '___',
                        'مبلغ نهایی قرارداد (ريال) با احتساب افزایش 25 درصد' => ($item->contract) ? number_format($item->contract->contract_final_amount): '___',
                        'ضریب پیمان' => ($item->contract) ? $item->contract->agreement_coe: '___',
                        'وضعیت قرارداد' => ($item->contract) ? $item->contract->contract_status: '___',

                        'مبلغ تعدیل قطعی' => (!empty2($item->final_adjustment_amount) ) ? $item->final_adjustment_amount: '___',
                        'شماره نامه تعدیل قطعی' => (!empty2($item->adjustment_amount_letter_number) ) ? $item->adjustment_amount_letter_number: '___',
                        'تاریخ نامه تعدیل قطعی' => (!empty2($item->adjustment_amount_letter_date) ) ? $item->adjustment_amount_letter_date: '___',
                    
                    ];
                });
        }

        if($this->typeFilter=='Deposit'){
            $this->query = Deposit::query();
            $this->checkFilter('Deposit');
               if($paginate)
                {
                $this->paginates = [
                    'total'=>$this->query->count(),
                    'perPage' => $this->paginate,
                    'totalPage' => $this->query->count() / $this->paginate,
                    'currentPage' => $this->page,
                    'skip' => $this->page * $this->paginate
                 ];
                if($this->paginates['total'] > 15)
                    $this->query->skip($this->paginates['skip']);
                $this->datas = $this->query->take($this->paginate)->get();

            }
            else
                $this->datas = $this->query->with('contract')->get();
            if($paginate)
                $this->baseDatas = $this->datas;
            else 
                $this->baseDatas = null;
                $this->count = $this->query->count();
            if(!empty2($this->datas))
                $this->datas = $this->datas->map(function($item){
                    return [
                        'نام شهرستان' => (!empty2($item->contract)) ? $item->contract->city: '___',
                        'نام مجتمع' =>  (!empty2($item->contract)) ? $item->contract->complex_name: '___',
                        'نوع پروژه' =>  (!empty2($item->contract) && !empty2($item->contract->contractDetail) ) ? $item->contract->contractDetail->contract_subject: '___',
                        'کد طرح' => (!empty2($item->contract)) ? $item->contract->project_code: '___',
                        'نام پروژه' => (!empty2($item->contract)) ? $item->contract->contract_title: '___',
                        'تاریخ قرار داد ' => (!empty2($item->contract)) ? $item->contract->contract_date: '___',
                        'شماره قرار داد ' => (!empty2($item->contract)) ? $item->contract->contract_number: '___',
                        'پیمانکار' => (!empty2($item->contract) && !empty2($item->contract->contractor)) ? $item->contract->contractor->name: '___',
                        'مشاور' =>  (!empty2($item->contract) && !empty2($item->contract->consultant)) ? $item->contract->consultant->name: '___',
                        'مدت قرارداد' => (!empty2($item->contract)) ? number_format($item->statement_adjustment_number_final_amount): '___',
                        'مبلغ اولیه قرارداد (ريال)' => (!empty2($item->contract)) ? number_format($item->contract->contract_first_amount): '___',
                        'مبلغ نهایی قرارداد (ريال) با احتساب افزایش 25 درصد' => ($item->contract) ? number_format($item->contract->contract_final_amount): '___',
                        'ضریب پیمان' => ($item->contract) ? $item->contract->agreement_coe: '___',
                        'وضعیت قرارداد' => ($item->contract) ? $item->contract->contract_status: '___',

                        'شماره نامه آزادسازی ضمانتنامه سپرده پیش پرداخت 1' => (!empty2($item->advance_deposit_release_letter_number_1) ) ? $item->advance_deposit_release_letter_number_1: '___',
                        'تاریخ آزادسازی ضمانتنامه سپرده پیش پرداخت 1' => (!empty2($item->advance_deposit_release_date_1) ) ? $item->advance_deposit_release_date_1: '___',
                        'شماره نامه آزادسازی ضمانتنامه سپرده پیش پرداخت 2' => (!empty2($item->advance_deposit_release_letter_number_2) ) ? $item->advance_deposit_release_letter_number_2: '___',
                        'تاریخ آزادسازی ضمانتنامه سپرده پیش پرداخت 2' => (!empty2($item->advance_deposit_release_date_2) ) ? $item->advance_deposit_release_date_2	: '___',
                        'شماره نامه آزادسازی ضمانتنامه سپرده پیش پرداخت 3' => (!empty2($item->advance_deposit_release_letter_number_3) ) ? $item->advance_deposit_release_letter_number_3: '___',
                        'تاریخ آزادسازی ضمانتنامه سپرده پیش پرداخت 3' => (!empty2($item->advance_deposit_release_date_3) ) ? $item->advance_deposit_release_date_3: '___',
                        'تاریخ نامه آزادسازی ضمانتنامه اجرای تعهدات' => (!empty2($item->date_release_guarantee_performance_obligations) ) ? $item->date_release_guarantee_performance_obligations: '___',
                        'شماره نامه آزادسازی ضمانتنامه اجرای تعهدات' =>   (!empty2($item->number_letter_release_guarantee_performance_obligations) ) ? $item->number_letter_release_guarantee_performance_obligations: '___',
                        'شماره نامه آزادسازی سپرده حسن انجام کار(نیمه اول)' => (!empty2($item->number_release_letter_deposit_good_work) ) ? $item->number_release_letter_deposit_good_work: '___',
                        'تاریخ نامه آزادسازی سپرده حسن انجام کار(نیمه اول)' => (!empty2($item->date_release_letter_deposit_good_work) ) ? $item->date_release_letter_deposit_good_work: '___',
                        'تاریخ نامه آزادسازی سپرده حسن انجام کار(نهایی)' => (!empty2($item->date_release_letter_deposit_good_work_final) ) ? $item->date_release_letter_deposit_good_work_final: '___',
                        'شماره نامه آزادسازی سپرده حسن انجام کار(نهایی)' =>  (!empty2($item->number_release_letter_deposit_good_work_final) ) ? $item->number_release_letter_deposit_good_work_final: '___',
                        //surat vaziat
                    
                    ];
                });
        }

    }

    public function downloadExcel()
    {
        $this->setDatas(false);
        $obj = new constract;
        $obj->setData($this->datas);
        // Excel::create('sheet', function($excel) {
        
        //     $excel->sheet('sheetExport', function($sheet) {
        
        //         $sheet->fromArray($this->datas);
        
        //     });
        
        // })->export('xls');
        // return (new Collection([
        //     [1, 2, 3], 
        //     [1, 2, 3]
        // ]))->downloadExcel('my-collection.xlsx');
        return Excel::download($obj, 'khuruji.xlsx');
    }

    // public function chnagePage($page)
    // {

    // }

    public function render()
    {
        $this->dispatch('contentChanged');
        return view('livewire.export-data',[
            'datas' => $this->datas,
            'baseData' => $this->baseDatas,
        ]);
    }
}
