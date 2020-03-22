@extends('admin.layouts.app_admin')
@section('content')
    <div class="container">
        @component('admin.components.breadcumb')
            @slot('title') Categories list @endslot
            @slot('parent') Main @endslot
            @slot('active') Categories @endslot
        @endcomponent
        <hr>
        <a href="{{ route('admin.category.create') }}" class="btn btn-block btn-outline-primary"><i class="fa fa-plus-square"></i> Create category</a>
            <table class="table table table-hover">
                <thead>
                    <tr class="text-center">
                        <th>Name</th>
                        <th>Publication</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $category->title }}</td>
                            <td>{{ $category->published }}</td>
                            <td>
                                <a href="{{ route('admin.category.edit', ['id'=>$category->id]) }}"><i class="far fa-edit"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Missing data</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="3">
                        <ul class="pagination">
                            {{$categories->links()}}
                        </ul>
                    </td>
                </tr>
                </tfoot>
            </table>
    </div>
@endsection
