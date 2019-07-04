@extends('layouts.master')

@section('title')
    Mod Manager
@endsection

@section('content-header')
    <h1>Mod Manager<small>Install curated, popular mods for your server.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('index') }}">Home</a></li>
        <li><a href="{{ route('server.index', $server->uuidShort) }}">{{ $server->name }}</a></li>
        <li>Mod Manager</li>
        <li class="active">List Mods</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="content">

            <div class="col">
                @foreach($categories as $category)
                    @foreach($category->mods as $categg)
                        @if($categg->game == $server->egg_id)
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">{{ $category->title }}</h3>
                                </div>
                                <div class="box-body table-responsive no-padding">
                                    <table class="table table-hover">
                                        <tbody>
                                        <tr>
                                            <th class="col-xs-2">Name</th>
                                            <th class="col-xs-1">Version</th>
                                            <th class="col-xs-7">Description</th>
                                            <th class="text-center col-xs-2">Install</th>
                                            <th class="text-center col-xs-2">Remove</th>
                                        </tr>
                                        @foreach($category->mods as $mod)
                                            @if($mod->game == $server->egg_id)
                                                <tr>
                                                    <td class="middle col-xs-2">{{$mod->name}}</td>
                                                    <td class="middle col-xs-1"><code>{{$mod->version}}</code></td>
                                                    <td class="col-xs-7">{{$mod->description}}</td>
                                                    <td class="middle text-center col-xs-2">
                                                        <form action="{{ url('server/'.$server->uuidShort.'/mods/install/'.$mod->id) }}" id="function-install{{$mod->id}}" method="POST">
                                                            @csrf
                                                            @method('POST')
                                                            <button type="button" class="btn btn-primary btn-sm">Install Mod</button>
                                                        </form>
                                                    </td>
                                                    <td class="middle text-center col-xs-2">
                                                        <form action="{{ url('server/'.$server->uuidShort.'/mods/remove/'.$mod->id) }}" id="function-delete{{$mod->id}}" method="POST">
                                                            @csrf
                                                            @method('POST')
                                                            <button type="button" class="btn btn-danger btn-sm">Uninstall Mod</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                <script>
                                                    document.getElementById('function-install{{$mod->id}}').onclick = function(){
                                                        console.log(document.getElementById('function-install{{$mod->id}}'));
                                                        swal({
                                                            title: "Are you sure?",
                                                            text: "Our panel will immediately begin installing this mod.",
                                                            type: "info",
                                                            showCancelButton: true,
                                                            confirmButtonColor: "#3085d6",
                                                            confirmButtonText: "Yes, install it!",
                                                            closeOnConfirm: true
                                                        }, function(isConfirm){
                                                            if (isConfirm) document.getElementById('function-install{{$mod->id}}').submit();
                                                        });
                                                    };

                                                    document.getElementById('function-delete{{$mod->id}}').onclick = function(){
                                                        console.log(document.getElementById('function-delete{{$mod->id}}'));
                                                        swal({
                                                            title: "Are you sure?",
                                                            text: "Our panel will immediately begin uninstalling this mod.",
                                                            type: "warning",
                                                            showCancelButton: true,
                                                            confirmButtonColor: "#3085d6",
                                                            confirmButtonText: "Yes, delete it!",
                                                            closeOnConfirm: true
                                                        }, function(isConfirm){
                                                            if (isConfirm) document.getElementById('function-delete{{$mod->id}}').submit();
                                                        });
                                                    };
                                                </script>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('js/frontend/server.socket.js') !!}
    {!! Theme::js('vendor/jquery/date-format.min.js') !!}
    {!! Theme::js('vendor/chartjs/chart.min.js') !!}
    {!! Theme::js('vendor/jquery/jquery.min.js') !!}
    {!! Theme::js('vendor/sweetalert/sweetalert.min.js') !!}
@endsection
