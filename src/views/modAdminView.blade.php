@extends('layouts.admin')
@section('title')
    Locations &rarr; View &rarr; {{ $mod->name }}
@endsection
@section('content-header')
    <h1>{{ $mod->name }}</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('index') }}">Admin</a></li>
        <li><a href="{{ route('mod.index') }}">Mod Manager</a></li>
        <li class="active">{{ $mod->name }}</li>
    </ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">View Mod</h3>
                </div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Version</th>
                            <th>Category</th>
                            <th>FolderName</th>
                            <th>Game</th>
                            <th>Author</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                        <tr>
                            <td>{{ $mod->name }}</td>
                            <td>{{ $mod->description }}</td>
                            <td>{{ $mod->version }}</td>
                            <td>{{ $mod->category->title }}</td>
                            <td>{{ $mod->foldername }}</td>
                            <td>{{ $mod->game }}</td>
                            <td>{{ $mod->author }}</td>
                            <td><a href="{{ route('mod.edit', $mod) }}" class="btn btn-success btn-sm">Edit</a> </td>
                            <td><form action="{{ route('mod.destroy', $mod) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" id="function-delete" class="btn btn-danger btn-sm">Delete</button>
                                </form></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer-scripts')
    @parent
    {!! Theme::js('vendor/jquery/jquery.min.js') !!}

    <script>
        $('#function-delete').on('click',function(e){
            e.preventDefault();
            let form = $(this).parents('form');
            swal({
                title: "Are you sure?",
                text: "You will be permanently deleting {{$mod->name}}",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: true
            }, function(isConfirm){
                if (isConfirm) form.submit();
            });
        });
    </script>
@endsection
