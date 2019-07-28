@extends('layouts.admin')

@section('title')
    Mod Manager
@endsection


@section('content-header')
    <h1>View Mods<small>All mods for your server owners to install via one simple click.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li class="active">Mod Manager</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Available Mods</h3>
                    <div class="box-tools">
                        <a class="btn btn-sm btn-primary" href="{{ route('mod.create') }}">Create New</a>
                    </div>
                </div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>ID</th>
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
                        @foreach ($mods as $mod)
                            <tr>
                                <td><code>{{ $mod->id }}</code></td>
                                <td><a href="{{ route('mod.show', $mod) }}">{{ $mod->name }}</a></td>
                                <td>{{ $mod->description }}</td>
                                <td>{{ $mod->version }}</td>
                                <td>{{ $mod->category->title }}</td>
                                <td>{{ $mod->foldername }}</td>
                                <td>
                                    @foreach($mod->games() as $game)
                                        {{ $game->name }}<br>
                                    @endforeach
                                </td>
                                <td>{{ $mod->author }}</td>
                                <td><a href="{{ route('mod.edit', $mod) }}" class="btn btn-success btn-sm">Edit</a> </td>
                                <td>
                                    <form action="{{ route('mod.destroy', $mod) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" id="function-delete-{{$mod->id}}" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

