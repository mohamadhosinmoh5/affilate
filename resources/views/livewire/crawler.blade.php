<div>
      {{-- <div class="container-fluid"> --}}
        <div class="alert alert-warning">
            سیستم جامع خزنده سایت ها با قابل مدیریت
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="my-select">کدام خزش را شروع کنیم؟</label>
                    <select wire:change='setCrawler(event.target.value)' id="my-select" class="form-control">
                        <option  value="">هیچکدام</option>
                        @foreach ($allCrawlers as $item)
                            <option value="{{$item->id}}" >{{$item->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-sm-6">
                @if($crawler)
               
                    <div class="row">
                        

                        <div class="col-sm-3">
                            @if ($crawler->type == 'json')
                                <button type="submit" wire:click='readjson()' class="btn btn-primary">شروع خزش</button>
                            @elseif($crawler->type == 'url')
                                <button type="submit" wire:click='startCrawler()' class="btn btn-primary">شروع خزش</button>
                            @endif
                           
                        </div>
                    </div>
                @endif
              
            </div>
        </div>
    {{-- </div> --}}

    @if ($results)
        <table class="table table-light">
            <thead class="thead-light">
                <tr>
                    @foreach ($results['head'] as $item)
                        <th>{{ $item}}</th>
                    @endforeach
                    <th>عملیات ها</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $product_details = [];
                @endphp
                @foreach ($results['data'] as $key => $item)
                <tr>
                        <td>{!!$item['title_fa']!!}</td>
                        <td><a href="{!!$item['title_fa']!!}"> {!!$item['title_fa']!!} </a> </td>
                        <td>{!!$item['product_type']!!}</td>
                        <td><img width="100px" src="{!!$item['mainImage']!!}" alt=""></td>
                        <td>
                            @if ($item['status'] ==1)
                                <div class="alert alert-success">کاوش شده</div>
                                @else
                                <div class="alert alert-danger">کاوش نشده</div>
                            @endif
                        </td>
                        <td><a wire:click='addProduct({!!json_encode($item)!!})' class="btn btn-success">افزودن به محصولات</a></td>
                       
                        @php
                            $product_details[] = $item;
                        @endphp
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>
                       <div class="row">
                            <div class="col-6"><a href="#" wire:click='crawlPage({{$page-1}})'>صفحه قبلی </a> </div>
                            <div class="col-6"> <a href="#" wire:click='crawlPage({{$page+1}})'>صفحه بعدی </a> </div>
                        </div>
                    </th>
                    <th>
                        <a wire:click='addAllProduct({!!json_encode($product_details)!!})' class="btn btn-success">افزودن گروهی همه محصولات</a> 
                    </th>
                </tr>
            </tfoot>
        </table>
    @endif
    <div wire:loading class="fixed-Loader">
        <div  class="loader"></div>
    </div>
  
    @if (!empty2($notif))
        <div id="modal" class="modal" >
            <img src="https://100dayscss.com/codepen/alert.png" width="44" height="38" />
                <span class="title">خطا در عملیات</span>
           
                @foreach ($notif as $item)
                    @if (!is_array($item))
                        <p>{!!$item!!}</p>
                    @else
                        @foreach ($item as $data)
                            <p>{!!$data!!}</p>
                        @endforeach
                    @endif
                @endforeach
                
                <div id="button" class="button">بستن</div>
        </div>
    @endif
        
        <script>
            document.getElementById('button').addEventListener('click',()=>{
                document.getElementById('modal').style.display = 'none';
            })
         </script>
</div>

