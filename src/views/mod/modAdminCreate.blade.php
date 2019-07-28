@extends('layouts.admin')

@section('title')
    Mod Manager &rarr; New
@endsection


@section('content-header')
    <h1>New Mod Category</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('mod.index') }}">Mod Manager</a></li>
        <li class="active">New</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-body table-responsive">
                    <form method="POST" action="{{ route('mod.store') }}">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control" />
                            <p class="text-muted small">Name of Mod.</p>
                        </div>

                        <div class="form-group">
                            <label for="desc" class="form-label">Description</label>
                            <input type="text" id="desc" name="description" value="{{ old('description') }}" class="form-control" />
                            <p class="text-muted small">Description of the mod on the user's side.</p>
                        </div>

                        <div class="form-group">
                            <label for="vers" class="form-label">Version</label>
                            <input type="text" id="vers" name="version" value="{{ old('version') }}" class="form-control" />
                            <p class="text-muted small">Version of the mod on the user's side. Recommended to put "latest".</p>
                        </div>

                        <div class="form-group">
                            <label for="category">Select Category:</label>
                            <select class="form-control" id="category" name="category_id">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                @endforeach
                            </select>
                            <p class="text-muted small">The category the mod will appear under for users.</p>
                        </div>

                        <div class="form-group">
                            <label for="path" class="form-label">Path</label>
                            <input type="text" id="path" name="path" value="{{ old('path') }}" class="form-control" />
                            <p class="text-muted small">Path for the mod to extract to on the users server. Do not include /home/conatiner.</p>
                        </div>

                        <div class="form-group">
                            <label for="link" class="form-label">Link</label>
                            <input type="text" id="link" name="link" value="{{ old('link') }}" class="form-control" />
                            <p class="text-muted small">Url of the mod, can be .zip or .git</p>
                        </div>

                        <div class="form-group">
                            <label for="multyGames" class="control-label">Game`s</label>
                            <select id="multyGames" name="games[]" multiple class="form-control">
                                @foreach($eggs as $key => $egg)
                                    <option value="{{ $egg->id }}">{{ $egg->name }}</option>
                                @endforeach
                            </select>
                            <p class="text-muted small">The eggID of the egg the mod should appear under.</p>
                        </div>

                        <div class="form-group">
                            <label for="author" class="form-label">Author</label>
                            <input type="text" id="author" name="author" value="{{ old('author') }}" class="form-control" />
                            <p class="text-muted small">The author of the mod.</p>
                        </div>

                        <div class="form-group">
                            <label for="folder" class="form-label">Folder name</label>
                            <input type="text" id="folder" name="foldername" value="{{ old('foldername') }}" class="form-control" />
                            <p class="text-muted small">The folder name for the addon. Used in the case of git downloads being renamed e.g. DarkRP-master can be saved as darkrp</p>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-success btn-sm pull-right">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer-scripts')
    @parent
    <script>
        $('#multyGames').select2();
    </script>
@endsection
