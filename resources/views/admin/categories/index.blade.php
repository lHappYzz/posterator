@extends('admin.layouts.app_admin')
@section('content')
    <div class="container">
        @component('admin.components.breadcrumb')
            @slot('title') Categories list @endslot
            @slot('parent') Main @endslot
            @slot('active') Categories @endslot
        @endcomponent
        <hr>
        <a href="{{ route('admin.category.create') }}" class="btn btn-block btn-outline-primary"><i class="fa fa-file"></i> Create category</a>
            <table class="table table table-hover">
                <thead>
                    <tr class="text-center">
                        <th>Name</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="text-center" >
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $category->title ?? 'none'}}</td>
                            <td>{{ $category->created_at ?? 'none'}}</td>
                            <td>{{ $category->updated_at ?? 'none' }}</td>
                            <td>
                                <a href="{{ route('admin.category.edit', ['category' => $category->id]) }}"><i class="fa fa-edit"></i></a>
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
