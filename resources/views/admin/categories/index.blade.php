@extends('admin.layouts.app_admin')
@section('content')
    <div class="container">
        @component('admin.components.breadcrumb')
            @slot('title') Categories list @endslot
            @slot('parent') Main @endslot
            @slot('active') Categories @endslot
        @endcomponent
        <hr>
        <a href="{{ route('admin.category.create') }}" class="btn btn-block btn-outline-primary my-3"><i class="fa fa-file"></i> Create category</a>
        <table class="table table-hover text-center">
            <thead>
                <tr>
                    <th>Name</th>
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
                        <td>{{ $category->created_at ?? 'none'}}</td>
                        <td>{{ $category->updated_at ?? 'none' }}</td>
                        <td>
                            @include('admin.categories.confirmModalWindow', ['category' => $category, 'modalTitle'=>'Delete the category'])
                            <a class="btn btn-outline-primary" href="{{ route('admin.category.edit', ['category' => $category->id]) }}"><i class="fa fa-edit"></i></a>
                            <button data-toggle="modal" data-target="#ModalCenter{{$category->id}}" type="button" value="delete" class="btn btn-outline-primary"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center"><h3>Missing data</h3></td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4">
                        <ul class="pagination">
                            {{$categories->links()}}
                        </ul>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection
