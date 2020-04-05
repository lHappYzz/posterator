@extends('admin.layouts.app_admin')
@push('scripts')
    <script type="text/javascript" src="/public/js/scripts.js?v=26"></script>
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
                <input autofocus type="text" class="form-control @error('category_title') is-invalid @enderror" name="category_title" maxlength="30" value="{{ old('category_title') }}" placeholder="Some category">
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
            @php $oldSubcategories = is_null(old('subcategory_title')) ? null:old('subcategory_title') @endphp
            @if($oldSubcategories)
                @foreach($oldSubcategories as $key => $data)
                    @foreach($data as $oldValueKey => $oldValue)
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Subcategory title</span>
                                </div>
                                <input placeholder="Leave it empty if you don't need it" name="subcategory_title[{{$key}}][0]" type="text" value="{{ $oldValue }}" class="form-control @error('subcategory_title.'.$key) is-invalid @enderror">
                                <div class="input-group-append">
                                    <button name="add_new_input" class="btn btn-outline-success" onclick="addNewInput(event)" type="button"><i class="fa fa-plus"></i></button>
                                    <button name="remove_new_input" class="btn btn-outline-danger" onclick="removeNewInput(event)" type="button"><i class="fa fa-minus"></i></button>
                                </div>
                                @error('subcategory_title.'.$key.'.'.$oldValueKey)
                                    <span class="invalid-feedback" style="display: block;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    @endforeach
                @endforeach
            @else
                <div id="noCategoriesInfo" class=" text-center alert alert-info">
                    <h3>No subcategories</h3>
                    <button name="add_new_input" class="btn btn-outline-success" onclick="addNewInput(event)" type="button"><i class="fa fa-plus"></i></button>
                </div>
            @endif
        </div>
    </form>
</div>
@endsection
