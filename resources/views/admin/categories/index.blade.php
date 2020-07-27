@extends('admin.layouts.app_admin')
@push('styles')
    <link href="{{asset('public/css/adminTableStyles.css') . "?v=" . filemtime(public_path() . "/css/adminTableStyles.css") }}" rel="stylesheet">
@endpush
@section('content')
    <div class="container">
        @component('admin.components.breadcrumb')
            @slot('title') Categories list @endslot
            @slot('parent') Main @endslot
            @slot('active') Categories @endslot
        @endcomponent
        <hr>
        <a href="{{ route('admin.category.create') }}" class="btn btn-block btn-outline-primary my-3"><i class="fa fa-plus"></i> Create category</a>
        <table class="table table-hover text-center">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Subcategories count</th>
                    <th>Created at</th>
                    <th>Updated at</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->title ?? 'none'}}</td>
                        <td>{{ $category->child_categories->count() }}</td>
                        <td>{{ $category->created_at ?? 'none'}}</td>
                        <td>{{ $category->updated_at ?? 'none' }}</td>
                        <td>
                            @include('admin.components.confirmModalWindow', [
                                'model' => $category,
                                'modalTitle'=>'Delete the category',
                                'message' => 'Are you sure you want to delete the category: "' . $category->title . '" with all subcategories?',
                                'action' => route('admin.category.destroy', ['category' => $category->id])
                            ])
                            <a class="btn btn-outline-primary" href="{{ route('admin.category.edit', ['category' => $category->id]) }}"><i class="fa fa-edit"></i></a>
                            <button data-toggle="modal" data-target="#ModalCenter{{$category->id}}" type="button" value="delete" class="btn btn-outline-primary"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center"><h3>Missing data</h3></td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5">
                        <ul class="pagination">
                            {{$categories->links()}}
                        </ul>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection
