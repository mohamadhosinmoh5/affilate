

    <div class="row" style="padding: 50px !important;" dir="rtl">
        {{-- <div class="col-sm-12 text-center">
            <h1>سیستم جامع جستجو پیشرفته شرکت آب و فاضلاب</h1>
        </div>
        @if ($typeFilter=='contract')
            <div class="col-sm-12">
                <div class="input-group">
                    <div class="box-search">
                        <input class="search" wire:input.live="setFilter('contract','contract_title','text',event.target.value)" type="search" placeholder="جستجو کنید">
                        <img width="50px" src="{{url('assets')}}/images/search.png" alt="">
                    </div>
                </div>
            </div>
        @endif --}}

    {{--  --}}
        <div class="row nav-box" >
            {{-- <div class="alert alert-info text-center">
                بریم برای فیلتر کردن تا همونی که می خوای رو پیدا کنیم
            </div> --}}

            <ul class="nav nav-tabs ">
                <li class="nav-item">
                  <a @if ($typeFilter=='contract') class="nav-link active" @else class="nav-link"  @endif wire:click.live="setFilterView('contract')">فیلتر قرار داد</a>
                </li>
                <li class="nav-item">
                  <a @if ($typeFilter=='Statement') class="nav-link active" @else class="nav-link"  @endif wire:click.live="setFilterView('Statement')" >فیلتر صورت وضعیت</a>
                </li>
                <li class="nav-item">
                  <a @if ($typeFilter=='Adjustment') class="nav-link active" @else class="nav-link"  @endif wire:click.live="setFilterView('Adjustment')" >فیلتر تعدیل ها</a>
                </li>
                <li class="nav-item">
                    <a @if ($typeFilter=='DeliveryTermination') class="nav-link active" @else class="nav-link"  @endif wire:click.live="setFilterView('DeliveryTermination')" >فیلتر تمدید ها</a>
                </li>
                <li class="nav-item">
                    <a @if ($typeFilter=='CertainStatement') class="nav-link active" @else class="nav-link"  @endif wire:click.live="setFilterView('CertainStatement')" >فیلتر صورت وضعیت قطعی </a>
                  </li>
                <li class="nav-item">
                <a @if ($typeFilter=='CertainAdjustment') class="nav-link active" @else class="nav-link"  @endif wire:click.live="setFilterView('CertainAdjustment')" >فیلتر تعدیل قطعی </a>
                </li>
                <li class="nav-item">
                <a @if ($typeFilter=='Extension') class="nav-link active" @else class="nav-link"  @endif wire:click.live="setFilterView('Extension')" >فیلتر تمدید ها</a>
                </li>
                <li class="nav-item">
                    <a @if ($typeFilter=='deposit') class="nav-link active" @else class="nav-link"  @endif wire:click.live="setFilterView('deposit')" >سپرده</a>
                </li>
              </ul>
        </div>
      
        @if ($typeFilter=='contract')
            <div class="row">
                <div class="col-sm-3">
                    <div class="row">
                        <div class="col-sm-12 mt-3">
                            <div class="form-group">
                                <label for="my-select">نوع قرار داد</label>
                                <select id="my-select" class="form-control mt-3" wire:change.live="setFilter('contract','contract_subject','text',event.target.value,'contractDetail')">
                                    <option value="">مهم نیست</option>
                                    <option value="آبرسانی">آبرسانی</option>
                                    <option value="فاینانس">فاینانس</option>
                                    <option value="فاضلاب">فاضلاب</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 mt-3">
                            <div class="form-group">
                                <label for="my-select">شهرستان</label>
                                <select id="my-select" class="form-control mt-3" wire:change.live="setFilter('contract','city','text',event.target.value)">
                                    <option value="">همه شهر ها</option>
                                    <option value="گرگان">گرگان</option>
                                    <option value="اق قلا">اق قلا</option>
                                    <option value="فاضلاب">فاضل آباد</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 mt-3">
                            <div class="form-group">
                                <label for="my-select">وضعیت قرار داد</label>
                                <select id="my-select" class="form-control mt-3" wire:change.live="setFilter('contract','contract_status','checkBox',event.target.value)">
                                    <option value="فعال">فعال</option>
                                    <option value="غیر فعال">غیر فعال</option>
                                </select>
                            </div>
                        </div>
                    </div>
                 
                </div>
                <div class="col-sm-3">
                    <div class="row mt-3">
                        <div class="form-group">
                            <label for="my-select">مشاور</label>
                            <select id="my-select" class="form-control mt-3" wire:change.live="setFilter('contract','name','text',event.target.value,'consultant')">
                                <option value="">مهم نیست</option>
                                @foreach ($consultants as $item)
                                    <option value="{{$item->name}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-sm-12 mt-3">
                            <div class="form-group" id="designSelector">
                                <label for="select">طرح</label>
                                <select id="select" class="form-control mt-3"  wire:input.live="setFilter('contract','title','text',event.target.value,'designCode')">
                                    <option value="">همه طرح ها</option>
                                    @foreach ($designCode as $item)
                                        <option value="{{$item->title}}">{{$item->title}} کد: ({{$item->code}})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-sm-3">
                    <div class="row">
                        <div class="col-sm-12 mt-3">
                            <div class="form-group">
                                <label for="my-select"> شماره قرار داد</label>
                               <div class="form-group">
                                 <input type="text" class="form-control"  wire:input.live="setFilter('contract','contract_number','text',event.target.value)">
                               </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 mt-3">
                            <div class="form-group">
                                <label for="my-select"> نام مجتمع</label>
                               <div class="form-group">
                                 <input type="text" class="form-control"  wire:input.live="setFilter('contract','complex_name','text',event.target.value)">
                               </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-sm-3">
                    <div class="row">
                        <div class="col-sm-12 mt-3">
                            <div class="form-group">
                                <label for="my-select"> عنوان قرار داد</label>
                               <div class="form-group">
                                 <input type="text" class="form-control"  wire:input.live="setFilter('contract','contract_title','text',event.target.value)">
                               </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="form-group">
                            <label for="my-select">پیمانکار</label>
                            <select id="my-select" class="form-control mt-3"  wire:change.live="setFilter('contract','name','text',event.target.value,'contractor')">
                                <option value="">مهم نیست</option>
                                @foreach ($contractor as $item)
                                    <option value="{{$item->name}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- datecontract --}}
                    <div class="row mt-3">
                        <h6 class="dateLable"> تاریخ قرارداد</h6>
                        <div class="col-sm-6">
                            <div class="form-group">
                               
                                <input type="date" class="form-control dateFa" value="1400-01-1" min="1370-01-01" max="1403-12-31" id="dateFaContractOne" wire:change.live="setStartDate('contract','contract_date',event.target.value)">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                               
                                <input type="date" class="form-control dateFa" value="1400-01-1" min="1370-01-01" max="1403-12-31" id="dateFaContractTow" wire:model='dateFaContractEnd' wire:change.live="setEndDate('contract','contract_date',event.target.value)">
                                <label for="mb-2" style="position: relative; bottom: 35px; left: 20px;">  تا  </label>
                            </div>
                        </div>
                     
                    </div>

                </div>
            </div>
        @endif

        @if ($typeFilter=='Statement')
        <div class="row">
            <div class="col-sm-3">
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select">نوع قرار داد</label>
                            <select id="my-select" class="form-control mt-3" wire:change.live="setFilter('Statement','contract_subject','text',event.target.value,'contract.contractDetail')">
                                <option value="">مهم نیست</option>
                                <option value="آبرسانی">آبرسانی</option>
                                <option value="فاینانس">فاینانس</option>
                                <option value="فاضلاب">فاضلاب</option>
                            </select>
                        </div>
                    </div>
                </div>
                {{--  --}}
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select">شهرستان</label>
                            <select id="my-select" class="form-control mt-3" wire:change.live="setFilter('Statement','city','text',event.target.value,'contract')">
                                <option value="">همه شهر ها</option>
                                <option value="گرگان">گرگان</option>
                                <option value="اق قلا">اق قلا</option>
                                <option value="فاضلاب">فاضل آباد</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select">وضعیت قرار داد</label>
                            <select id="my-select" class="form-control mt-3" wire:change.live="setFilter('Statement','contract_status','checkBox',event.target.value,'contract')">
                                <option value="فعال">فعال</option>
                                <option value="غیر فعال">غیر فعال</option>
                            </select>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-sm-3">
                <div class="row mt-3">
                    <div class="form-group">
                        <label for="my-select">مشاور</label>
                        <select id="my-select" class="form-control mt-3" wire:change.live="setFilter('Statement','name','text',event.target.value,'contract.consultant')">
                            <option value="">مهم نیست</option>
                            @foreach ($consultants as $item)
                                <option value="{{$item->name}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select"> شماره قرار داد</label>
                           <div class="form-group">
                             <input type="text" class="form-control"  wire:input.live="setFilter('Statement','contract_number','text',event.target.value,'contract')">
                           </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select"> عنوان قرار داد</label>
                           <div class="form-group">
                             <input type="text" class="form-control"  wire:input.live="setFilter('Statement','contract_title','text',event.target.value,'contract')">
                           </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select"> نام مجتمع</label>
                           <div class="form-group">
                             <input type="text" class="form-control"  wire:input.live="setFilter('Statement','complex_name','text',event.target.value,'contract')">
                           </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">

                <div class="row mt-4">
                    <div class="form-group">
                        <label for="my-select">پیمانکار</label>
                        <select id="my-select" class="form-control mt-3"  wire:change.live="setFilter('Statement','name','text',event.target.value,'contract.contractor')">
                            <option value="">مهم نیست</option>
                            @foreach ($contractor as $item)
                                <option value="{{$item->name}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group" id="designSelector">
                            <label for="select">طرح</label>
                            <select id="select" class="form-control mt-3"  wire:input.live="setFilter('Statement','title','text',event.target.value,'contract.designCode')">
                                <option value="">همه طرح ها</option>
                                @foreach ($designCode as $item)
                                    <option value="{{$item->title}}">{{$item->title}} کد: ({{$item->code}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <h6 class="dateLable"> تاریخ قرارداد</h6>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="date" value="1400-01-1" min="1370-01-01" max="1403-12-31" class="form-control" id="dateStatementOne"  wire:change.live="setStartDate('Statement','contract_date',event.target.value,'contract')" >
                        </div>
                        
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="date" class="form-control dateFa" value="1400-01-1" min="1370-01-01" max="1403-12-31" id="dateStatementTow" wire:change.live="setEndDate('Statement','contract_date',event.target.value,'contract')" >
                            <label for="mb-2" style="position: relative; bottom: 35px; left: 20px;">  تا  </label>
                        </div>
                    </div>
                 
                </div>

            </div>
        </div>
        @endif

        @if ($typeFilter=='Adjustment')
        <div class="row">
              <div class="col-sm-3">
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select">نوع قرار داد</label>
                            <select id="my-select" class="form-control mt-3" wire:change.live="setFilter('Adjustment','contract_subject','text',event.target.value,'contract.contractDetail')">
                                <option value="">مهم نیست</option>
                                <option value="آبرسانی">آبرسانی</option>
                                <option value="فاینانس">فاینانس</option>
                                <option value="فاضلاب">فاضلاب</option>
                            </select>
                        </div>
                    </div>
                </div>
                {{--  --}}
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select">شهرستان</label>
                            <select id="my-select" class="form-control mt-3" wire:change.live="setFilter('Adjustment','city','text',event.target.value,'contract')">
                                <option value="">همه شهر ها</option>
                                <option value="گرگان">گرگان</option>
                                <option value="اق قلا">اق قلا</option>
                                <option value="فاضلاب">فاضل آباد</option>
                            </select>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-sm-3">
                <div class="row mt-3">
                    <div class="form-group">
                        <label for="my-select">مشاور</label>
                        <select id="my-select" class="form-control mt-3" wire:change.live="setFilter('Adjustment','name','text',event.target.value,'contract.consultant')">
                            <option value="">مهم نیست</option>
                            @foreach ($consultants as $item)
                                <option value="{{$item->name}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select"> شماره قرار داد</label>
                           <div class="form-group">
                             <input type="text" class="form-control"  wire:input.live="setFilter('Adjustment','contract_number','text',event.target.value,'contract')">
                           </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select">وضعیت قرار داد</label>
                            <select id="my-select" class="form-control mt-3" wire:change.live="setFilter('Adjustment','contract_status','checkBox',event.target.value,'contract')">
                                <option value="فعال">فعال</option>
                                <option value="غیر فعال">غیر فعال</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select"> عنوان قرار داد</label>
                           <div class="form-group">
                             <input type="text" class="form-control"  wire:input.live="setFilter('Adjustment','contract_title','text',event.target.value,'contract')">
                           </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select"> نام مجتمع</label>
                           <div class="form-group">
                             <input type="text" class="form-control"  wire:input.live="setFilter('Adjustment','complex_name','text',event.target.value,'contract')">
                           </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">

                <div class="row mt-4">
                    <div class="form-group">
                        <label for="my-select">پیمانکار</label>
                        <select id="my-select" class="form-control mt-3"  wire:change.live="setFilter('Adjustment','name','text',event.target.value,'contract.contractor')">
                            <option value="">مهم نیست</option>
                            @foreach ($contractor as $item)
                                <option value="{{$item->name}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group" id="designSelector">
                            <label for="select">طرح</label>
                            <select id="select" class="form-control mt-3"  wire:input.live="setFilter('Adjustment','title','text',event.target.value,'contract.designCode')">
                                <option value="">همه طرح ها</option>
                                @foreach ($designCode as $item)
                                    <option value="{{$item->title}}">{{$item->title}} کد: ({{$item->code}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <h6 class="dateLable"> تاریخ قرارداد</h6>
                    <div class="col-sm-6">
                        <div class="form-group">
                           
                            <input type="text" class="form-control" id="dateOne" wire:change.live="setStartDate('Adjustment','contract_date',event.target.value,'contract')">
                            <script>
                                    $('#dateOne').pDatepicker({
                                    initialValueType: "persian",
                                    format: "YYYY/MM/DD",
                                    onSelect: "year",
                                    persianDigit:true,
                                    calendar:{
                                        persian:{
                                            locale:'en'
                                        }
                                    },
                                    onSelect: function(date){
                                         @this.setStartDate('Adjustment','contract_date',$('#dateOne').val(),'contract');
                                    },
                                });
                            </script>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">  
                            <input type="date" class="form-control dateFa" value="1400-01-1" min="1370-01-01" max="1403-12-31" wire:change.live="setEndDate('Adjustment','contract_date',event.target.value,'contract')">
                            <script>
                                    $('#dateOne').pDatepicker({
                                    initialValueType: "persian",
                                    format: "YYYY/MM/DD",
                                    onSelect: "year",
                                    persianDigit:true,
                                    calendar:{
                                        persian:{
                                            locale:'en'
                                        }
                                    },
                                    onSelect: function(date){
                                        @this.setEndDate('Adjustment','contract_date',$('#dateOne').val(),'contract');
                                    },
                                });
                            </script>
                            <label for="mb-2" style="position: relative; bottom: 35px; left: 20px;">  تا  </label>
                        </div>
                    </div>
                 
                </div>

            </div>
        </div>
        @endif

        @if ($typeFilter=='DeliveryTermination')
        <div class="row">
            <div class="col-sm-3">
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select">نوع قرار داد</label>
                            <select id="my-select" class="form-control mt-3" wire:change.live="setFilter('DeliveryTermination','contract_subject','text',event.target.value,'contract.contractDetail')">
                                <option value="">مهم نیست</option>
                                <option value="آبرسانی">آبرسانی</option>
                                <option value="فاینانس">فاینانس</option>
                                <option value="فاضلاب">فاضلاب</option>
                            </select>
                        </div>
                    </div>
                </div>
                {{--  --}}
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select">شهرستان</label>
                            <select id="my-select" class="form-control mt-3" wire:change.live="setFilter('DeliveryTermination','city','text',event.target.value,'contract')">
                                <option value="">همه شهر ها</option>
                                <option value="گرگان">گرگان</option>
                                <option value="اق قلا">اق قلا</option>
                                <option value="فاضلاب">فاضل آباد</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select">وضعیت قرار داد</label>
                            <select id="my-select" class="form-control mt-3" wire:change.live="setFilter('DeliveryTermination','contract_status','checkBox',event.target.value,'contract')">
                                <option value="فعال">فعال</option>
                                <option value="غیر فعال">غیر فعال</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="row mt-3">
                    <div class="form-group">
                        <label for="my-select">مشاور</label>
                        <select id="my-select" class="form-control mt-3" wire:change.live="setFilter('DeliveryTermination','name','text',event.target.value,'contract.consultant')">
                            <option value="">مهم نیست</option>
                            @foreach ($consultants as $item)
                                <option value="{{$item->name}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select"> شماره قرار داد</label>
                           <div class="form-group">
                             <input type="text" class="form-control"  wire:input.live="setFilter('DeliveryTermination','contract_number','text',event.target.value,'contract')">
                           </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select"> عنوان قرار داد</label>
                           <div class="form-group">
                             <input type="text" class="form-control"  wire:input.live="setFilter('DeliveryTermination','contract_title','text',event.target.value,'contract')">
                           </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select"> نام مجتمع</label>
                           <div class="form-group">
                             <input type="text" class="form-control"  wire:input.live="setFilter('DeliveryTermination','complex_name','text',event.target.value,'contract')">
                           </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">

                <div class="row mt-4">
                    <div class="form-group">
                        <label for="my-select">پیمانکار</label>
                        <select id="my-select" class="form-control mt-3"  wire:change.live="setFilter('DeliveryTermination','name','text',event.target.value,'contract.contractor')">
                            <option value="">مهم نیست</option>
                            @foreach ($contractor as $item)
                                <option value="{{$item->name}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group" id="designSelector">
                            <label for="select">طرح</label>
                            <select id="select" class="form-control mt-3"  wire:input.live="setFilter('DeliveryTermination','title','text',event.target.value,'contract.designCode')">
                                <option value="">همه طرح ها</option>
                                @foreach ($designCode as $item)
                                    <option value="{{$item->title}}">{{$item->title}} کد: ({{$item->code}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <h6 class="dateLable"> تاریخ قرارداد</h6>
                    <div class="col-sm-6">
                        <div class="form-group">   
                            <input type="date" class="form-control dateFa" value="1400-01-1" min="1370-01-01" max="1403-12-31" id="dateOne" wire:change.live="setStartDate('DeliveryTermination','contract_date',event.target.value,'contract')">
                            <script>
                                $('#dateOne').pDatepicker({
                                initialValueType: "persian",
                                format: "YYYY/MM/DD",
                                onSelect: "year",
                                persianDigit:true,
                                calendar:{
                                    persian:{
                                        locale:'en'
                                    }
                                },
                                onSelect: function(date){
                                    @this.setStartDate('DeliveryTermination','contract_date',$('#dateOne').val(),'contract');
                                },
                            });
                        </script>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            
                            <input type="date" class="form-control dateFa" value="1400-01-1" min="1370-01-01" max="1403-12-31" id="dateTow" wire:change.live="setEndDate('DeliveryTermination','contract_date',event.target.value,'contract')">
                            <script>
                                    $('#dateTow').pDatepicker({
                                    initialValueType: "persian",
                                    format: "YYYY/MM/DD",
                                    onSelect: "year",
                                    persianDigit:true,
                                    calendar:{
                                        persian:{
                                            locale:'en'
                                        }
                                    },
                                    onSelect: function(date){
                                        @this.setEndDate('DeliveryTermination','contract_date',$('#dateTow').val(),'contract');
                                    },
                                });
                            </script>
                            <label for="mb-2" style="position: relative; bottom: 35px; left: 20px;">  تا  </label>
                        </div>
                    </div>
                 
                </div>

            </div>
        </div>
        @endif

        @if ($typeFilter=='CertainStatement')
        <div class="row">
            <div class="col-sm-3">
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select">نوع قرار داد</label>
                            <select id="my-select" class="form-control mt-3" wire:change.live="setFilter('CertainStatement','contract_subject','text',event.target.value,'contract.contractDetail')">
                                <option value="">مهم نیست</option>
                                <option value="آبرسانی">آبرسانی</option>
                                <option value="فاینانس">فاینانس</option>
                                <option value="فاضلاب">فاضلاب</option>
                            </select>
                        </div>
                    </div>
                </div>
                {{--  --}}
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select">شهرستان</label>
                            <select id="my-select" class="form-control mt-3" wire:change.live="setFilter('CertainStatement','city','text',event.target.value,'contract')">
                                <option value="">همه شهر ها</option>
                                <option value="گرگان">گرگان</option>
                                <option value="اق قلا">اق قلا</option>
                                <option value="فاضلاب">فاضل آباد</option>
                            </select>
                        </div>
                    </div>
                </div>

                
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select">وضعیت قرار داد</label>
                            <select id="my-select" class="form-control mt-3" wire:change.live="setFilter('CertainStatement','contract_status','checkBox',event.target.value,'contract')">
                                <option value="فعال">فعال</option>
                                <option value="غیر فعال">غیر فعال</option>
                            </select>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-sm-3">
                <div class="row mt-3">
                    <div class="form-group">
                        <label for="my-select">مشاور</label>
                        <select id="my-select" class="form-control mt-3" wire:change.live="setFilter('CertainStatement','name','text',event.target.value,'contract.consultant')">
                            <option value="">مهم نیست</option>
                            @foreach ($consultants as $item)
                                <option value="{{$item->name}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select"> شماره قرار داد</label>
                           <div class="form-group">
                             <input type="text" class="form-control"  wire:input.live="setFilter('CertainStatement','contract_number','text',event.target.value,'contract')">
                           </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select"> عنوان قرار داد</label>
                           <div class="form-group">
                             <input type="text" class="form-control"  wire:input.live="setFilter('CertainStatement','contract_title','text',event.target.value,'contract')">
                           </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select"> نام مجتمع</label>
                           <div class="form-group">
                             <input type="text" class="form-control"  wire:input.live="setFilter('CertainStatement','complex_name','text',event.target.value,'contract')">
                           </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">

                <div class="row mt-4">
                    <div class="form-group">
                        <label for="my-select">پیمانکار</label>
                        <select id="my-select" class="form-control mt-3"  wire:change.live="setFilter('CertainStatement','name','text',event.target.value,'contract.contractor')">
                            <option value="">مهم نیست</option>
                            @foreach ($contractor as $item)
                                <option value="{{$item->name}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group" id="designSelector">
                            <label for="select">طرح</label>
                            <select id="select" class="form-control mt-3"  wire:input.live="setFilter('CertainStatement','title','text',event.target.value,'contract.designCode')">
                                <option value="">همه طرح ها</option>
                                @foreach ($designCode as $item)
                                    <option value="{{$item->title}}">{{$item->title}} کد: ({{$item->code}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <h6 class="dateLable"> تاریخ قرارداد</h6>
                    <div class="col-sm-6">
                        <div class="form-group">
                            
                            <input type="text" id="dateOne" class="form-control dateFa" wire:change.live="setStartDate('CertainStatement','contract_date',event.target.value,'contract')">
                            <script>
                                    $('#dateOne').pDatepicker({
                                    initialValueType: "persian",
                                    format: "YYYY/MM/DD",
                                    onSelect: "year",
                                    persianDigit:true,
                                    calendar:{
                                        persian:{
                                            locale:'en'
                                        }
                                    },
                                    onSelect: function(date){
                                        @this.setStartDate('CertainStatement','contract_date',$('#dateOne').val(),'contract');
                                    },
                                });
                            </script>    
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                           
                            <input type="date" class="form-control dateFa" value="1400-01-1" min="1370-01-01" max="1403-12-31" id="dateTow" wire:change.live="setEndDate('CertainStatement','contract_date',event.target.value,'contract')">
                            <script>
                                    $('#dateTow').pDatepicker({
                                    initialValueType: "persian",
                                    format: "YYYY/MM/DD",
                                    onSelect: "year",
                                    persianDigit:true,
                                    calendar:{
                                        persian:{
                                            locale:'en'
                                        }
                                    },
                                    onSelect: function(date){
                                        @this.setEndDate('CertainStatement','contract_date',$('#dateTow').val(),'contract');
                                    },
                                });
                            </script>
                            <label for="mb-2" style="position: relative; bottom: 35px; left: 20px;">  تا  </label>
                        </div>
                    </div>
                 
                </div>

            </div>
        </div>
        @endif

        @if ($typeFilter=='CertainAdjustment')
        <div class="row">
            <div class="col-sm-3">
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select">نوع قرار داد</label>
                            <select id="my-select" class="form-control mt-3" wire:change.live="setFilter('CertainAdjustment','contract_subject','text',event.target.value,'contract.contractDetail')">
                                <option value="">مهم نیست</option>
                                <option value="آبرسانی">آبرسانی</option>
                                <option value="فاینانس">فاینانس</option>
                                <option value="فاضلاب">فاضلاب</option>
                            </select>
                        </div>
                    </div>
                </div>
                {{--  --}}
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select">شهرستان</label>
                            <select id="my-select" class="form-control mt-3" wire:change.live="setFilter('CertainAdjustment','city','text',event.target.value,'contract')">
                                <option value="">همه شهر ها</option>
                                <option value="گرگان">گرگان</option>
                                <option value="اق قلا">اق قلا</option>
                                <option value="فاضلاب">فاضل آباد</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select">وضعیت قرار داد</label>
                            <select id="my-select" class="form-control mt-3" wire:change.live="setFilter('CertainStatement','contract_status','checkBox',event.target.value,'contract')">
                                <option value="فعال">فعال</option>
                                <option value="غیر فعال">غیر فعال</option>
                            </select>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-sm-3">
                <div class="row mt-3">
                    <div class="form-group">
                        <label for="my-select">مشاور</label>
                        <select id="my-select" class="form-control mt-3" wire:change.live="setFilter('CertainAdjustment','name','text',event.target.value,'contract.consultant')">
                            <option value="">مهم نیست</option>
                            @foreach ($consultants as $item)
                                <option value="{{$item->name}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select"> شماره قرار داد</label>
                           <div class="form-group">
                             <input type="text" class="form-control"  wire:input.live="setFilter('CertainAdjustment','contract_number','text',event.target.value,'contract')">
                           </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select"> عنوان قرار داد</label>
                           <div class="form-group">
                             <input type="text" class="form-control"  wire:input.live="setFilter('CertainAdjustment','contract_title','text',event.target.value,'contract')">
                           </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select"> نام مجتمع</label>
                           <div class="form-group">
                             <input type="text" class="form-control"  wire:input.live="setFilter('CertainAdjustment','complex_name','text',event.target.value,'contract')">
                           </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">

                <div class="row mt-4">
                    <div class="form-group">
                        <label for="my-select">پیمانکار</label>
                        <select id="my-select" class="form-control mt-3"  wire:change.live="setFilter('CertainAdjustment','name','text',event.target.value,'contract.contractor')">
                            <option value="">مهم نیست</option>
                            @foreach ($contractor as $item)
                                <option value="{{$item->name}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group" id="designSelector">
                            <label for="select">طرح</label>
                            <select id="select" class="form-control mt-3"  wire:input.live="setFilter('CertainAdjustment','title','text',event.target.value,'contract.designCode')">
                                <option value="">همه طرح ها</option>
                                @foreach ($designCode as $item)
                                    <option value="{{$item->title}}">{{$item->title}} کد: ({{$item->code}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <h6 class="dateLable"> تاریخ قرارداد</h6>
                    <div class="col-sm-6">
                        <div class="form-group">
                           
                            <input type="date" class="form-control dateFa" value="1400-01-1" min="1370-01-01" max="1403-12-31" id="dateOne" wire:change.live="setStartDate('CertainAdjustment','contract_date',event.target.value,'contract')">
                            <script>
                                $('#dateOne').pDatepicker({
                                initialValueType: "persian",
                                format: "YYYY/MM/DD",
                                onSelect: "year",
                                persianDigit:true,
                                calendar:{
                                    persian:{
                                        locale:'en'
                                    }
                                },
                                onSelect: function(date){
                                    @this.setStartDate('CertainStatement','contract_date',$('#dateOne').val(),'contract');
                                },
                            });
                        </script>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                          
                            <input type="date" class="form-control dateFa" value="1400-01-1" min="1370-01-01" max="1403-12-31" id="dateTow" wire:change.live="setEndDate('CertainAdjustment','contract_date',event.target.value,'contract')">
                            <script>
                                    $('#dateTow').pDatepicker({
                                    initialValueType: "persian",
                                    format: "YYYY/MM/DD",
                                    onSelect: "year",
                                    persianDigit:true,
                                    calendar:{
                                        persian:{
                                            locale:'en'
                                        }
                                    },
                                    onSelect: function(date){
                                        @this.setEndDate('CertainAdjustment','contract_date',$('#dateTow').val(),'contract');
                                    },
                                });
                            </script>
                            <label for="mb-2" style="position: relative; bottom: 35px; left: 20px;">  تا  </label>
                        </div>
                    </div>
                 
                </div>

            </div>
        </div>
        @endif

        @if ($typeFilter=='Extension')
        <div class="row">
            <div class="col-sm-3">
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select">نوع قرار داد</label>
                            <select id="my-select" class="form-control mt-3" wire:change.live="setFilter('Extension','contract_subject','text',event.target.value,'contract.contractDetail')">
                                <option value="">مهم نیست</option>
                                <option value="آبرسانی">آبرسانی</option>
                                <option value="فاینانس">فاینانس</option>
                                <option value="فاضلاب">فاضلاب</option>
                            </select>
                        </div>
                    </div>
                </div>
                {{--  --}}
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select">شهرستان</label>
                            <select id="my-select" class="form-control mt-3" wire:change.live="setFilter('Extension','city','text',event.target.value,'contract')">
                                <option value="">همه شهر ها</option>
                                <option value="گرگان">گرگان</option>
                                <option value="اق قلا">اق قلا</option>
                                <option value="فاضلاب">فاضل آباد</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select">وضعیت قرار داد</label>
                            <select id="my-select" class="form-control mt-3" wire:change.live="setFilter('Extension','contract_status','checkBox',event.target.value,'contract')">
                                <option value="فعال">فعال</option>
                                <option value="غیر فعال">غیر فعال</option>
                            </select>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-sm-3">
                <div class="row mt-3">
                    <div class="form-group">
                        <label for="my-select">مشاور</label>
                        <select id="my-select" class="form-control mt-3" wire:change.live="setFilter('Extension','name','text',event.target.value,'contract.consultant')">
                            <option value="">مهم نیست</option>
                            @foreach ($consultants as $item)
                                <option value="{{$item->name}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select"> شماره قرار داد</label>
                           <div class="form-group">
                             <input type="text" class="form-control"  wire:input.live="setFilter('Extension','contract_number','text',event.target.value,'contract')">
                           </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select"> عنوان قرار داد</label>
                           <div class="form-group">
                             <input type="text" class="form-control"  wire:input.live="setFilter('Extension','contract_title','text',event.target.value,'contract')">
                           </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select"> نام مجتمع</label>
                           <div class="form-group">
                             <input type="text" class="form-control"  wire:input.live="setFilter('Extension','complex_name','text',event.target.value,'contract')">
                           </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">

                <div class="row mt-4">
                    <div class="form-group">
                        <label for="my-select">پیمانکار</label>
                        <select id="my-select" class="form-control mt-3"  wire:change.live="setFilter('Extension','name','text',event.target.value,'contract.contractor')">
                            <option value="">مهم نیست</option>
                            @foreach ($contractor as $item)
                                <option value="{{$item->name}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group" id="designSelector">
                            <label for="select">طرح</label>
                            <select id="select" class="form-control mt-3"  wire:input.live="setFilter('Extension','title','text',event.target.value,'contract.designCode')">
                                <option value="">همه طرح ها</option>
                                @foreach ($designCode as $item)
                                    <option value="{{$item->title}}">{{$item->title}} کد: ({{$item->code}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <h6 class="dateLable"> تاریخ قرارداد</h6>
                    <div class="col-sm-6">
                        <div class="form-group">
                            
                            <input type="date" class="form-control dateFa" value="1400-01-1" min="1370-01-01" max="1403-12-31" id="dateOne" wire:change.live="setStartDate('Extension','contract_date',event.target.value,'contract')">
                            <script>
                                    $('#dateOne').pDatepicker({
                                    initialValueType: "persian",
                                    format: "YYYY/MM/DD",
                                    onSelect: "year",
                                    persianDigit:true,
                                    calendar:{
                                        persian:{
                                            locale:'en'
                                        }
                                    },
                                    onSelect: function(date){
                                        @this.setStartDate('Extension','contract_date',$('#dateOne').val(),'contract');
                                    },
                                });
                            </script>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="date" class="form-control dateFa" value="1400-01-1" min="1370-01-01" max="1403-12-31" id="dateTow" wire:change.live="setEndDate('Extension','contract_date',event.target.value,'contract')">
                            <script>
                                    $('#dateTow').pDatepicker({
                                    initialValueType: "persian",
                                    format: "YYYY/MM/DD",
                                    onSelect: "year",
                                    persianDigit:true,
                                    calendar:{
                                        persian:{
                                            locale:'en'
                                        }
                                    },
                                    onSelect: function(date){
                                        @this.setEndDate('Extension','contract_date',$('#dateTow').val(),'contract');
                                    },
                                });
                            </script>
                            <label for="mb-2" style="position: relative; bottom: 35px; left: 20px;">  تا  </label>
                        </div>
                    </div>
                 
                </div>

            </div>
        </div>
        @endif

        @if ($typeFilter=='deposit')
        <div class="row">
            <div class="col-sm-3">
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select">نوع قرار داد</label>
                            <select id="my-select" class="form-control mt-3" wire:change.live="setFilter('deposit','contract_subject','text',event.target.value,'contract.contractDetail')">
                                <option value="">مهم نیست</option>
                                <option value="آبرسانی">آبرسانی</option>
                                <option value="فاینانس">فاینانس</option>
                                <option value="فاضلاب">فاضلاب</option>
                            </select>
                        </div>
                    </div>
                </div>
                {{--  --}}
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select">شهرستان</label>
                            <select id="my-select" class="form-control mt-3" wire:change.live="setFilter('deposit','city','text',event.target.value,'contract')">
                                <option value="">همه شهر ها</option>
                                <option value="گرگان">گرگان</option>
                                <option value="اق قلا">اق قلا</option>
                                <option value="فاضلاب">فاضل آباد</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select">وضعیت قرار داد</label>
                            <select id="my-select" class="form-control mt-3" wire:change.live="setFilter('deposit','contract_status','checkBox',event.target.value,'contract')">
                                <option value="فعال">فعال</option>
                                <option value="غیر فعال">غیر فعال</option>
                            </select>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-sm-3">
                <div class="row mt-3">
                    <div class="form-group">
                        <label for="my-select">مشاور</label>
                        <select id="my-select" class="form-control mt-3" wire:change.live="setFilter('deposit','name','text',event.target.value,'contract.consultant')">
                            <option value="">مهم نیست</option>
                            @foreach ($consultants as $item)
                                <option value="{{$item->name}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select"> شماره قرار داد</label>
                           <div class="form-group">
                             <input type="text" class="form-control"  wire:input.live="setFilter('deposit','contract_number','text',event.target.value,'contract')">
                           </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select"> عنوان قرار داد</label>
                           <div class="form-group">
                             <input type="text" class="form-control"  wire:input.live="setFilter('deposit','contract_title','text',event.target.value,'contract')">
                           </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="my-select"> نام مجتمع</label>
                           <div class="form-group">
                             <input type="text" class="form-control"  wire:input.live="setFilter('deposit','complex_name','text',event.target.value,'contract')">
                           </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">

                <div class="row mt-4">
                    <div class="form-group">
                        <label for="my-select">پیمانکار</label>
                        <select id="my-select" class="form-control mt-3"  wire:change.live="setFilter('deposit','name','text',event.target.value,'contract.contractor')">
                            <option value="">مهم نیست</option>
                            @foreach ($contractor as $item)
                                <option value="{{$item->name}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <div class="form-group" id="designSelector">
                            <label for="select">طرح</label>
                            <select id="select" class="form-control mt-3"  wire:input.live="setFilter('deposit','title','text',event.target.value,'contract.designCode')">
                                <option value="">همه طرح ها</option>
                                @foreach ($designCode as $item)
                                    <option value="{{$item->title}}">{{$item->title}} کد: ({{$item->code}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <h6 class="dateLable"> تاریخ قرارداد</h6>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="date" class="form-control dateFa" value="1400-01-1" min="1370-01-01" max="1403-12-31" id="dateOne" wire:change.live="setStartDate('deposit','contract_date',event.target.value,'contract')">
                            
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="date" class="form-control dateFa" value="1400-01-1" min="1370-01-01" max="1403-12-31" id="dateTow" wire:change.live="setEndDate('deposit','contract_date',event.target.value,'contract')">

                            <label for="mb-2" style="position: relative; bottom: 35px; left: 20px;">  تا  </label>
                        </div>
                    </div>
                 
                </div>

            </div>
        </div>
        @endif

        {{-- table --}}
          
        <div class="row">
            <div class="col-sm-12 text-end">
                <div class="row">
                    <div class="col-sm-4">
                        <label for="export-file" onclick="exel()" id="toEXCEL">خروجی اکسل از جدول<img width="50px" src="{{url('assets')}}/images/excel.png" alt=""></label>
                    </div>
                    <div class="col-sm-4">
                    <label   wire:click='downloadExcel()' id="toEXCEL">خروجی کامل اکسل از دیتابیس<img width="50px" src="{{url('assets')}}/images/excel.png" alt=""></label>
                    </div>
                    <div class="col-sm-4">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input">
                                        <span class="input-group-text" style = "position: relative; right: 36%;" id="my-addon">تعداد نمایش خروجی</span>
                                        <input class="form-control" style = "position: relative; right: 36%;" type="text" wire:model='paginate' wire:input.live='setDatas()'>
                                    </div>
                                    <div>
    
                                </div>
                            </div>
                            </div>

                            <div class="col-sm-4">
                                
                                <span class="input-group-text" id="my-addon">

                                    {{$this->paginate}}
                                    از
                                    {{$this->paginates['total']}}  
                                
                                </span>
                               
                            </div>
                        </div>

            
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-sm-12 text-center">
                <span wire:loading  class="loader2"></span>
                <span wire:loading wire:target="downloadExcel" class="alert alert-warning">خروجی گرفتن از تمامی داده ها ممکن است کمی به طول بیانجامد کمی صبور باشید</span>
            </div>
            <div class="table-box" class="col-sm-12">
                @if (!empty2($datas))
                <table class="table" id="customers_table">
                        <thead >
                            
                            <tr>
                                @foreach (array_keys($datas[0]) as $item)
                                    <th> {{$item}} </th>
                                @endforeach 
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $items)
                                <tr>
                                   @php
                                  // dd($items);l
                                   @endphp
                                @foreach ($items as $key =>  $item)
                                    @if($key == 'نام پروژه')
                                    <td style="max-width:300px; text-wrap: wrap; min-width: 250px;" >
                                    {{ $item}} </td>
                                    
                                    @else
                                    <td>{{ $item}} </td>
                                    @endif
                                    @endforeach 
                                </tr>
                            @endforeach
                        </tbody>
                        
                    </table>
                </div>
                <div class="row text-center">
                  
                    @if (!empty2($baseData))
                    @php
                      
                        $total = $paginates['total'];
                        $perPage = $paginates['perPage'];
                        $totalPage = $paginates['totalPage'];
                        $lastPage = $page - 1;
                        $nextPage = $page + 1;
                       
                    @endphp
                        @if ($totalPage > 1)
                            <nav aria-label="Page navigation example mt-4">
                                <ul class="pagination">
                                    @if ($totalPage > 1 && $page > 1)
                                        <li class="page-item"><a class="page-link" wire:click='lastPage("{{$page}}")' >قبلی</a></li>
                                    @else
                                        <li class="page-item disabled" disabled><a class="page-link">قبلی</a></li>
                                    @endif
                                    @for ($i = 1; $i <= $totalPage; $i++)
                                            @if ($i > ($page + 15) || $i < $page)
                                            @if ($i == 1)
                                                <li class="page-item {{ $page == $i ? 'active' : '' }}" wire:click='changePage("{{$i}}")' ><a class="page-link">{{$i}}</a></li>
                                            @endif
                                            @if ($i == ((int)$totalPage - 1))
                                                <li class="page-item {{ $page == $i ? 'active' : '' }}" wire:click='changePage("{{$i}}")' ><a class="page-link">{{$i}}</a></li>
                                            @endif
                                            @else
                                                <li class="page-item {{ $page == $i ? 'active' : '' }}" wire:click='changePage("{{$i}}")' ><a class="page-link">{{$i}}</a></li>
                                            @endif
                                    @endfor
                                    @if ($nextPage < $totalPage )
                                        <li class="page-item"  wire:click='nextPage("{{$page}}")' ><a class="page-link" >بعدی</a></li>
                                    @else
                                        <li class="page-item disabled" disabled><a class="page-link">بعدی</a></li>
                                    @endif
                                </ul>
                              </nav>
                        @endif
                    @endif
                </div>
                @else
                    <div class="alert alert-danger text-center">
                        دیتایی برای نمایش وجود ندارد
                    </div>
                @endif
        </div>

    
    </div>

        <script>
                document.addEventListener('livewire:init', () => {
                    Livewire.on('contentChanged', (event) => {
                        console.log($('#dateFaContractOne'));
                        $('#dateFaContractOne').pDatepicker({
                                        initialValueType: "persian",
                                        format: "YYYY/MM/DD",
                                        onSelect: "year",
                                        persianDigit:true,
                                        calendar:{
                                            persian:{
                                                locale:'en'
                                            }
                                        },
                                        onSelect: function(date){
                                            @this.setStartDate('contract','contract_date',$('#dateFaContractOne').val());
                                        },
                                    });
                        });
                    });
        // window.addEventListener('contentChanged', event => {
           
               
        // });
            // $('#dateFaContractOne').persianDatepicker(
            //     {
            //     months: ["فروردین", "اردیبهشت", "خرداد", "تیر", "مرداد", "شهریور", "مهر", "آبان", "آذر", "دی", "بهمن", "اسفند"],
            //     dowTitle: ["شنبه", "یکشنبه", "دوشنبه", "سه شنبه", "چهارشنبه", "پنج شنبه", "جمعه"],
            //     shortDowTitle: ["ش", "ی", "د", "س", "چ", "پ", "ج"],
            //     showGregorianDate: !1,
            //     persianNumbers: !0,
            //     formatDate: "YYYY/MM/DD",
            //     selectedBefore: !1,
            //     selectedDate: null,
            //     startDate: null,
            //     endDate: null,
            //     prevArrow: '\u25c4',
            //     nextArrow: '\u25ba',
            //     theme: 'default',
            //     alwaysShow: !1,
            //     selectableYears: null,
            //     selectableMonths: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
            //     cellWidth: 25, // by px
            //     cellHeight: 20, // by px
            //     fontSize: 13, // by px
            //     isRTL: !1,
            //     calendarPosition: {
            //         x: 0,
            //         y: 0,
            //     },
            //     onShow: function () {},
            //     onHide: function () {},
            //     onSelect: function () {},
            //     onRender: function () {}
            // });
            // function setDate2(){
                    // $('#dateFaContractOne').pDatepicker({
                    //     initialValueType: "persian",
                    //     format: "YYYY/MM/DD",
                    //     onSelect: "year",
                    //     persianDigit:true,
                    //     calendar:{
                    //         persian:{
                    //             locale:'en'
                    //         }
                    //     },
                    //     onSelect: function(date){
                    //         @this.setStartDate('contract','contract_date',$('#dateFaContractOne').val());
                    //     },
                    // });

            //         $('#dateFaContractTow').pDatepicker({
            //             initialValueType: "persian",
            //             format: "YYYY/MM/DD",
            //             onSelect: "year",
            //             persianDigit:true,
            //             calendar:{
            //                 persian:{
            //                     locale:'en'
            //                 }
            //             },
            //             onSelect: function(date){
            //                 @this.setEndDate('contract','contract_date',$('#dateFaContractTow').val());
            //             },
            //         });

            //         $('#dateStatementOne').pDatepicker({
            //             initialValueType: "persian",
            //             format: "YYYY/MM/DD",
            //             onSelect: "year",
            //             persianDigit:true,
            //             calendar:{
            //                 persian:{
            //                     locale:'en'
            //                 }
            //             },
            //             onSelect: function(date){
            //                 @this.setStartDate('Statement','contract_date',$('#dateStatementOne').val(),'contract');
            //             },
            //         });

            //         $('#dateStatementTow').pDatepicker({
            //             initialValueType: "persian",
            //             format: "YYYY/MM/DD",
            //             onSelect: "year",
            //             persianDigit:true,
            //             calendar:{
            //                 persian:{
            //                     locale:'en'
            //                 }
            //             },
            //             onSelect: function(date){
            //                 @this.setEndDate('Statement','contract_date',$('#dateStatementTow').val(),'contract');
            //             },
            //         });
            // }

            // setInterval(() => {
            //     setDate2();
            // },1000);
        // $('#dateOne').pDatepicker({
        //     initialValueType: "persian",
        //     format: "YYYY/MM/DD",
        //     onSelect: "year",
        //     persianDigit:true,
        //     calendar:{
        //         persian:{
        //             locale:'en'
        //         }
        //     },
        //     onSelect: function(date){
        //         @this.setStartDate('deposit','contract_date',$('#dateOne').val(),'contract');
        //     },
        // });
        // $('#dateOne').pDatepicker({
        //     initialValueType: "persian",
        //     format: "YYYY/MM/DD",
        //     onSelect: "year",
        //     persianDigit:true,
        //     calendar:{
        //         persian:{
        //             locale:'en'
        //         }
        //     },
        //     onSelect: function(date){
        //         @this.setStartDate('deposit','contract_date',$('#dateOne').val(),'contract');
        //     },
        // });
        // $('#dateOne').pDatepicker({
        //     initialValueType: "persian",
        //     format: "YYYY/MM/DD",
        //     onSelect: "year",
        //     persianDigit:true,
        //     calendar:{
        //         persian:{
        //             locale:'en'
        //         }
        //     },
        //     onSelect: function(date){
        //         @this.setStartDate('deposit','contract_date',$('#dateOne').val(),'contract');
        //     },
        // });
        // $('#dateOne').pDatepicker({
        //     initialValueType: "persian",
        //     format: "YYYY/MM/DD",
        //     onSelect: "year",
        //     persianDigit:true,
        //     calendar:{
        //         persian:{
        //             locale:'en'
        //         }
        //     },
        //     onSelect: function(date){
        //         @this.setStartDate('deposit','contract_date',$('#dateOne').val(),'contract');
        //     },
        // });
        // $('#dateOne').pDatepicker({
        //     initialValueType: "persian",
        //     format: "YYYY/MM/DD",
        //     onSelect: "year",
        //     persianDigit:true,
        //     calendar:{
        //         persian:{
        //             locale:'en'
        //         }
        //     },
        //     onSelect: function(date){
        //         @this.setStartDate('deposit','contract_date',$('#dateOne').val(),'contract');
        //     },
        // });
        // $('#dateOne').pDatepicker({
        //     initialValueType: "persian",
        //     format: "YYYY/MM/DD",
        //     onSelect: "year",
        //     persianDigit:true,
        //     calendar:{
        //         persian:{
        //             locale:'en'
        //         }
        //     },
        //     onSelect: function(date){
        //         @this.setStartDate('deposit','contract_date',$('#dateOne').val(),'contract');
        //     },
        // });
        // $('#dateOne').pDatepicker({
        //     initialValueType: "persian",
        //     format: "YYYY/MM/DD",
        //     onSelect: "year",
        //     persianDigit:true,
        //     calendar:{
        //         persian:{
        //             locale:'en'
        //         }
        //     },
        //     onSelect: function(date){
        //         @this.setStartDate('deposit','contract_date',$('#dateOne').val(),'contract');
        //     },
        // });
        // $('#dateOne').pDatepicker({
        //     initialValueType: "persian",
        //     format: "YYYY/MM/DD",
        //     onSelect: "year",
        //     persianDigit:true,
        //     calendar:{
        //         persian:{
        //             locale:'en'
        //         }
        //     },
        //     onSelect: function(date){
        //         @this.setStartDate('deposit','contract_date',$('#dateOne').val(),'contract');
        //     },
        // });
        // $('#dateOne').pDatepicker({
        //     initialValueType: "persian",
        //     format: "YYYY/MM/DD",
        //     onSelect: "year",
        //     persianDigit:true,
        //     calendar:{
        //         persian:{
        //             locale:'en'
        //         }
        //     },
        //     onSelect: function(date){
        //         @this.setStartDate('deposit','contract_date',$('#dateOne').val(),'contract');
        //     },
        // });
        // $('#dateOne').pDatepicker({
        //     initialValueType: "persian",
        //     format: "YYYY/MM/DD",
        //     onSelect: "year",
        //     persianDigit:true,
        //     calendar:{
        //         persian:{
        //             locale:'en'
        //         }
        //     },
        //     onSelect: function(date){
        //         @this.setStartDate('deposit','contract_date',$('#dateOne').val(),'contract');
        //     },
        // });
        </script>
