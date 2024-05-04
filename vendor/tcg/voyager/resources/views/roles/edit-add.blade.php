@extends('voyager::master')

@section('page_title', __('voyager::generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular'))

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ __('voyager::generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular') }}
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">
                    <!-- form start -->
                    <form class="form-edit-add" role="form"
                          action="@if(isset($dataTypeContent->id)){{ route('voyager.'.$dataType->slug.'.update', $dataTypeContent->id) }}@else{{ route('voyager.'.$dataType->slug.'.store') }}@endif"
                          method="POST" enctype="multipart/form-data">

                        <!-- PUT Method if we are editing -->
                        @if(isset($dataTypeContent->id))
                            {{ method_field("PUT") }}
                        @endif

                        <!-- CSRF TOKEN -->
                        {{ csrf_field() }}

                        <div class="panel-body">

                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @foreach($dataType->addRows as $row)
                                <div class="form-group">
                                    <label for="name">{{ $row->getTranslatedAttribute('display_name') }}</label>

                                    {!! Voyager::formField($row, $dataType, $dataTypeContent) !!}

                                </div>
                            @endforeach

                            <label for="permission">{{ __('voyager::generic.permissions') }}</label><br>
                            <a href="#" class="permission-select-all">{{ __('voyager::generic.select_all') }}</a> / <a href="#"  class="permission-deselect-all">{{ __('voyager::generic.deselect_all') }}</a>
                            <ul class="permissions checkbox">
                                <?php
                                    $role_permissions = (isset($dataTypeContent)) ? $dataTypeContent->permissions->pluck('key')->toArray() : [];
                                ?>
                                @foreach(Voyager::model('Permission')->all()->groupBy('table_name') as $table => $permission)
                            
                                @if (Auth::user()->role_id != 1 && Str::contains($table, 'roles'))
                                    @continue
                                @endif
                                    <li>
                                        <input type="checkbox" id="{{$table}}" class="permission-group">
                                        <label for="{{$table}}"><strong>{{\Illuminate\Support\Str::title(str_replace('_',' ', $table))}}</strong></label>
                                        <ul>
                                            @foreach($permission as $key => $perm)
                                            
                                                <li>
                                                    <input type="checkbox" id="permission-{{$perm->id}}" name="permissions[{{$perm->id}}]" class="the-permission" value="{{$perm->id}}" @if(in_array($perm->key, $role_permissions)) checked @endif>
                                                    {{-- <label for="permission-{{$perm->id}}">{{\Illuminate\Support\Str::title(str_replace('_', ' ', $perm->key))}}</label> --}}
                                                   
                                                    @if (Str::contains($perm->key, 'browse'))
                                                        <label for="permission-{{$perm->id}}">بارگزاری  {{str_replace('browse_', ' ', $perm->key)}}</label>
                                                    @elseif (Str::contains($perm->key, 'edit'))
                                                        <label for="permission-{{$perm->id}}">ویرایش  {{str_replace('edit_', ' ', $perm->key)}}</label>
                                                    @elseif (Str::contains($perm->key, 'read'))
                                                        <label for="permission-{{$perm->id}}">مشاهده  {{str_replace('read_', ' ', $perm->key)}}</label>
                                                    @elseif (Str::contains($perm->key, 'add'))
                                                        <label for="permission-{{$perm->id}}">افزودن  {{str_replace('add_', ' ', $perm->key)}}</label>
                                                    @elseif (Str::contains($perm->key, 'delete'))
                                                        <label for="permission-{{$perm->id}}">حذف  {{str_replace('delete_', ' ', $perm->key)}}</label>
                                                    @endif
                                                
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </div><!-- panel-body -->
                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary">{{ __('voyager::generic.submit') }}</button>
                        </div>
                    </form>

                    <div style="display:none">
                        <input type="hidden" id="upload_url" value="{{ route('voyager.upload') }}">
                        <input type="hidden" id="upload_type_slug" value="{{ $dataType->slug }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script>
        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();

            $('.permission-group').on('change', function(){
                $(this).siblings('ul').find("input[type='checkbox']").prop('checked', this.checked);
            });

            $('.permission-select-all').on('click', function(){
                $('ul.permissions').find("input[type='checkbox']").prop('checked', true);
                return false;
            });

            $('.permission-deselect-all').on('click', function(){
                $('ul.permissions').find("input[type='checkbox']").prop('checked', false);
                return false;
            });

            function parentChecked(){
                $('.permission-group').each(function(){
                    var allChecked = true;
                    $(this).siblings('ul').find("input[type='checkbox']").each(function(){
                        if(!this.checked) allChecked = false;
                    });
                    $(this).prop('checked', allChecked);
                });
            }

            parentChecked();

            $('.the-permission').on('change', function(){
                parentChecked();
            });
        });
    </script>
@stop
