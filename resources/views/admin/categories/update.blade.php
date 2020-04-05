@extends('admin.layouts.app_admin')
@push('scripts')
    <script type="text/javascript" src="/public/js/scripts.js?v=30"></script>
@endpush
@section('content')
    <div class="container">
        @component('admin.components.breadcrumb')
            @slot('title') Update category @endslot
            @slot('parent') Main @endslot
            @slot('middle_pages', ['admin.category.index' => 'Categories'])
            @slot('active') Update category @endslot
        @endcomponent
        <hr>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        <form class="form" method="post" action="{{ route('admin.category.update', ['category' => $category]) }}">
            @method('put')
            @csrf
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Category title</span>
                    </div>
                    <input autofocus type="text" class="form-control @error('category_title') is-invalid @enderror" name="category_title" maxlength="30" value="{{ $category->title ?? old('category_title') }}" placeholder="Some category">
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary" type="submit">Update</button>
                    </div>
                    @error('category_title')
                        <span class="invalid-feedback" style="display: block">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div id="subcategories" class="form-group">
                @forelse($category->child_categories as $key => $subcategory)
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Subcategory title</span>
                            </div>
{{--                            <input placeholder="Leave it empty if you don't need it" name="subcategory_title[{{ $subcategory->title }}]" type="text" maxlength="30" value="{{ $subcategory->title ?? old('subcategory_title') }}" class="form-control @error('subcategory_title.'.$key) is-invalid @enderror">--}}
                            <input placeholder="Leave it empty if you don't need it" name="subcategory_title[{{ $subcategory->title }}][{{ $subcategory->id }}]" type="text" maxlength="30" value="{{ $subcategory->title ?? old('subcategory_title') }}" class="form-control @error('subcategory_title.'.$key) is-invalid @enderror">
                            <div class="input-group-append">
                                <button name="add_new_input" class="btn btn-outline-success" onclick="addNewInput(event)" type="button"><i class="fa fa-plus"></i></button>
                                <button name="remove_new_input" class="btn btn-outline-danger" onclick="removeNewInput(event)" type="button"><i class="fa fa-minus"></i></button>
                            </div>
                            @error('subcategory_title.'.$subcategory->title.'.'.$subcategory->id)
                                <span class="invalid-feedback" style="display: block">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                @empty
                    <div id="noCategoriesInfo" class=" text-center alert alert-info">
                        <h3>No subcategories</h3>
                        <button name="add_new_input" class="btn btn-outline-success" onclick="addNewInput(event)" type="button"><i class="fa fa-plus"></i></button>
                    </div>
                @endforelse
            </div>
        </form>
    </div>
@endsection
