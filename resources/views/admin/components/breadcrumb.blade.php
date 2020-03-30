<h2>{{$title}}</h2>
<nav class="breadcrumb">
    <a class="breadcrumb-item" href="{{ route('admin.index') }}">{{$parent}}</a>
    @isset($middle_pages)
        @foreach($middle_pages as $page_route => $page_name)
            <a class="breadcrumb-item" href="{{ route($page_route) }}">{{$page_name}}</a>
            @endforeach
        @endisset
    <a class="breadcrumb-item active">{{$active}}</a>
</nav>
