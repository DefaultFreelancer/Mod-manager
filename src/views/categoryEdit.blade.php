@extends('layouts.admin')

@section('title')
    Mod Manager &rarr; Category &rarr; New
@endsection


@section('content-header')
    <h1>New Mod Category</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('mod.index') }}">Mod Manager</a></li>
        <li><a href="{{ route('category.index') }}">Categories</a></li>
        <li class="active">New</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-body table-responsive">
                    <form method="POST" action="{{ route('category.update', $category) }}">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="title" class="form-label">Name</label>
                            <input type="text" id="title" name="title" value="{{ $category->title }}" class="form-control" required/>
                            <p class="text-muted small">Name of the category.</p>
                        </div>

                        <div class="form-group">
                            <label for="desc" class="form-label">Description</label>
                            <input type="text" id="desc" name="description" value="{{ $category->description }}" class="form-control" required/>
                            <p class="text-muted small">Description of the category.</p>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-success btn-sm pull-right">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer-scripts')
    @parent
@endsection
