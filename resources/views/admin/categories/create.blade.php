@extends('admin.layouts.app_admin')
@push('scripts')
    <script type="text/javascript" src="/public/js/scripts.js?v=22"></script>
    @endpush
@section('content')
<div class="container">
    @component('admin.components.breadcrumb')
        @slot('title') Create category @endslot
        @slot('parent') Main @endslot
        @slot('middle_pages', ['admin.category.index' => 'Categories'])
        @slot('active') Create category @endslot
    @endcomponent
    <hr>
    <form class="form" method="post" action="{{ route('admin.category.store') }}">
        @csrf
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Category title</span>
                </div>
                <input autofocus type="text" class="form-control @error('category_title') is-invalid @enderror" name="category_title" maxlength="30" value="{{ old('category_title') }}" placeholder="Forest">
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="submit">Create</button>
                </div>
                @error('category_title')
                    <span class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div id="subcategories" class="form-group">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Subcategory title</span>
                    </div>
                    <input placeholder="Leave it empty if you don't need it" name="subcategory_title[0]" type="text" maxlength="30" value="{{ old('subcategory_title.0') }}" class="form-control @error('subcategory_title.0') is-invalid @enderror">
                    <div class="input-group-append">
                        <button name="add_new_input" class="btn btn-outline-success" onclick="addNewInput(event)" type="button"><i class="fa fa-plus"></i></button>
                    </div>
                    @error('subcategory_title.0')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            @php $old = is_null(old('subcategory_title')) ? null:old('subcategory_title') @endphp
            @isset($old)
                @foreach($old as $key => $oldValue)
                    @if($key == 0) @continue @endif
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Subcategory title</span>
                            </div>
                            <input placeholder="Leave it empty if you don't need it" name="subcategory_title[{{ $key }}]" type="text" value="{{ $oldValue }}" class="form-control @error('subcategory_title.'.$key) is-invalid @enderror">
                            <div class="input-group-append">
                                <button name="add_new_input" class="btn btn-outline-success" onclick="addNewInput(event)" type="button"><i class="fa fa-plus"></i></button>
                                <button name="remove_new_input" class="btn btn-outline-danger" onclick="removeNewInput(event)" type="button"><i class="fa fa-minus"></i></button>
                            </div>
                            @error('subcategory_title.'.$key)
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                @endforeach
            @endisset
        </div>
    </form>
</div>
@endsection
