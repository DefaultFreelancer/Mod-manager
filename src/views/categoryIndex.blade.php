@extends('layouts.admin')
@section('title')
    Mod Manager
@endsection

@section('content-header')
    <h1>View Categories<small>All mods for your server owners to install via one simple click.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('mod.index') }}">Mod Manager</a></li>
        <li class="active">Categories</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Categories</h3>
                    <div class="box-tools">
                        <a class="btn btn-sm btn-primary" href="{{ route('category.create') }}">Create New</a>
                    </div>
                </div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                        @foreach ($categories as $category)
                            <tr>
                                <td><code>{{ $category->id }}</code></td>
                                <td>{{ $category->title }}</td>
                                <td>{{ $category->description }}</td>
                                <td><a href="{{ route('category.edit', $category) }}" class="btn btn-success btn-sm">Edit</a> </td>
                                <td>
                                    <form action="{{ route('category.destroy', $category) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" id="function-delete-{{$category->id}}" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('footer-scripts')
    @parent

@endsection
