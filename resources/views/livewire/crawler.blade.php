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
                            <div class="form-group">
                                <label for="">تعداد واکشی</label>
                                <input type="text" 
                                class="form-control border border-1" name="" id="" value='{{$crawler->max}}' aria-describedby="helpId" placeholder="">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="">هر چند ثانیه یکبار</label>
                                <input type="text" 
                                class="form-control" name="" id="" value='{{$crawler->every_secend}}' aria-describedby="helpId" placeholder="">
                            </div>
                        </div>
                        <div class="col-sm-3">
                        
                        </div>
                        <div class="col-sm-3">
                            @if ($crawler->type == 'json')
                            <button type="submit" wire:click='readjson()' class="btn btn-primary">شروع خزش</button>
                            @elseif($crawler->type == 'urlk')
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
                @foreach ($results['data'] as $item)
                <tr>
                        <td>{!!$item['title_fa']!!}</td>
                        <td><a href="{!!$item['title_fa']!!}"> {!!$item['title_fa']!!} </a> </td>
                        <td>{!!$item['product_type']!!}</td>
                        <td><img width="100px" src="{!!$item['mainImage']!!}" alt=""></td>
                        <td><a wire:click='addProduct({!!json_encode($item)!!})' class="btn btn-success">افزودن به محصولات</a></td>    
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th> <a wire:click='addAllProduct()' class="btn btn-success">افزودن گروهی همه محصولات</a> </th>
                </tr>
            </tfoot>
        </table>
    @endif
</div>
