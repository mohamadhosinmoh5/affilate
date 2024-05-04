<nav class="navbar navbar-default navbar-fixed-top navbar-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button class="hamburger btn-link">
                <span class="hamburger-inner"></span>
            </button>
            @section('breadcrumbs')
            <ol class="breadcrumb hidden-xs">
                @php
                $segments = array_filter(explode('/', str_replace(route('voyager.dashboard'), '', Request::url())));
                $url = route('voyager.dashboard');
                @endphp
                @if(count($segments) == 0)
                    <li class="active"><i class="voyager-boat"></i> {{ __('voyager::generic.dashboard') }}</li>
                @else
                    <li class="active">
                        <a href="{{ route('voyager.dashboard')}}"><i class="voyager-boat"></i> {{ __('voyager::generic.dashboard') }}</a>
                    </li>
                    @foreach ($segments as $segment)
                        @php
                        $url .= '/'.$segment;
                        @endphp
                        @if ($loop->last)
                            <li>{{ ucfirst(urldecode($segment)) }}</li>
                        @else
                            <li>
                                <a href="{{ $url }}">{{ ucfirst(urldecode($segment)) }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            </ol>
            @show
        </div>
        {{-- __('voyager::generic.is_rtl') == 'true' --}}
        <ul class="nav navbar-nav @if (true) navbar-left @else navbar-right @endif">
            @php
               $notifs = App\Notif::paginate(10);
               $count = App\Notif::WhereIn('read',[null,0])->count();
            @endphp
           
            <li class="dropdown profile" id="notif-box">
                <a href="#" class="dropdown-toggle text-right" data-toggle="dropdown" role="button"
                aria-expanded="false">
                
                <div style="position: relative" >
                    <img src="{{url('/assets/image')}}/icons8-notification-64.png" class="profile-img">
                    @if ($count)
                        <div style="background:#ff0101; border-radius:50%;width:25px;height:25px;position: absolute;top:0;left:0;text-align:center;">
                        </div>
                        <span class="notifeCount" style="    position: absolute;
                        z-index: 2;
                        top: -20px;
                        left: 10px;
                        color: white;
                        font-weight: bold;">
                            {{$count}}
                        </span>
                    @endif
                </div>
                </a>

             <ul class="dropdown-menu dropdown-menu-animated">
                    @foreach ($notifs as $item)
                        <li>
                            @if ($item->day_avg > 0 )
                                <div class="alert alert-warning">
                                    مدت {{$item->day_avg}} روز تا پایان قرار داد {{ $item->title}}     باقی مانده است .
                                    <a href="{{url('')}}/admin/delivery-terminations">جهت تحویل یا خاتمه اقدام کنید </a>
                                </div>
                            @else
                                <div class="alert alert-danger">
                                    مدت {{ $item->day_last}}روز از قرار داد {{ $item->title}} گذشته است
                                    <a href="{{url('')}}/admin/papers/create">جهت ارسال نامه کلیک کنید </a> 
                                </div>
                            @endif
                        </li>
                    @endforeach

                    <div class="row">
                        <h6 class="text-center">برای دیدن اعلانات بیشتر
                            <a href="{{url('')}}/admin/notif">کلیک کنید </a>
                        </h6>

                    </div>
                </ul>

                
            </li>
            <li class="dropdown profile">
                <a href="#" class="dropdown-toggle text-right" data-toggle="dropdown" role="button"
                   aria-expanded="false"><img src="{{ $user_avatar }}" class="profile-img"> <span
                            class="caret"></span></a>
                <ul class="dropdown-menu dropdown-menu-animated">
                    <li class="profile-img">
                        <img src="{{ $user_avatar }}" class="profile-img">
                        <div class="profile-body">
                            <h5>{{ Auth::user()->name }}</h5>
                            <h6>{{ Auth::user()->email }}</h6>
                        </div>
                    </li>
                    <li class="divider"></li>
                    <?php $nav_items = config('voyager.dashboard.navbar_items'); ?>
                    @if(is_array($nav_items) && !empty($nav_items))
                    @foreach($nav_items as $name => $item)
                    <li {!! isset($item['classes']) && !empty($item['classes']) ? 'class="'.$item['classes'].'"' : '' !!}>
                        @if(isset($item['route']) && $item['route'] == 'voyager.logout')
                        <form action="{{ route('voyager.logout') }}" method="POST">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-block">
                                @if(isset($item['icon_class']) && !empty($item['icon_class']))
                                <i class="{!! $item['icon_class'] !!}"></i>
                                @endif
                                {{__($name)}}
                            </button>
                        </form>
                        @else
                        <a href="{{ isset($item['route']) && Route::has($item['route']) ? route($item['route']) : (isset($item['route']) ? $item['route'] : '#') }}" {!! isset($item['target_blank']) && $item['target_blank'] ? 'target="_blank"' : '' !!}>
                            @if(isset($item['icon_class']) && !empty($item['icon_class']))
                            <i class="{!! $item['icon_class'] !!}"></i>
                            @endif
                            {{__($name)}}
                        </a>
                        @endif
                    </li>
                    @endforeach
                    @endif
                </ul>
            </li>
        </ul>
    </div>
</nav>


<script>
        setTimeout(() => {
      
      $('#notif-box').click(function(){
 
      $.ajax({
                  type: "post",
                  url: "{{url('')}}/updateRead",
                  data:{'_token':'{{csrf_token()}}'},
                  success: function (response)
                  {
                      if(response)
                      {
                          console.log(response);
                      }
                  }
              });
  })

  setInterval(() => {
      $.ajax({
          type: "get",
          url: "{{url('')}}/updateNotife?count={{$count}}",
          success: function (response)
          {
              if(response)
              {
                  var count = $('.notifeCount').html();
                  $('.notifeCount').html(response.count); 

                  if(response.refresh == 1){
                      location.reload();
                  }
              }
          }
      });
  }, 60000);
}, 500);

</script>