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
                @foreach($results['data'] as $key => $item)
                <tr>
                        <td>{!!$item['title_fa']!!}</td>
                        <td><a href="{!!$item['title_fa']!!}"> {!!$item['title_fa']!!} </a> </td>
                        <td>{!!$item['product_type']!!}</td>
                        <td><img width="100px" src="{!!$item['mainImage']!!}" alt=""></td>
                        <td>
                            @if ($item['status'] == 1)
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
                            <div class="col-sm-6"><a href="#" class="btn btn-info" wire:click='crawlPage({{$page-1}})'>صفحه قبلی </a> </div>
                            <div class="col-sm-6"> <a href="#" class="btn btn-info" wire:click='crawlPage({{$page+1}})'>صفحه بعدی </a> </div>
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
        <!-- Modal -->
        <div id="notifeModal" class="costumModel">
            <div class="row costumModelBox">
                <div class="col-sm-12 title">
                    اعلان ها
                </div>
                <div class="col-sm-12">
                    @foreach ($notif as $item)
                        @if (!is_array($item))
                            <p>{!!$item!!}</p>
                        @else
                            @foreach ($item as $data)
                                <p>{!!$data!!}</p>
                            @endforeach
                        @endif
                    @endforeach
                </div>

                <div class="col-sm-12">
                    <button wire:click="closeModal()" class="btn btn-danger">بستن</button>
                </div>
            </div>
        </div>
    @endif
  
</div>

