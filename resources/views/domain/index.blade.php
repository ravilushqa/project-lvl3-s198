@extends('layouts.app')

@section('content')
    <table class="table table-bordered table-dark">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Created at</th>
            <th scope="col">Code</th>
            <th scope="col">Content-Length</th>
            <th scope="col">h1</th>
            <th scope="col">Keywords</th>
            <th scope="col">Description</th>
        </tr>
        </thead>
        <tbody>
        @foreach($domains as $domain)
            <tr>
                <th scope="row">{{ $domain->getKey() }}</th>
                <td>{{ $domain->name }}</td>
                <td>{{ $domain->created_at }}</td>
                <td>{{ $domain->code }}</td>
                <td>{{ $domain->content_length }}</td>
                <td>{{ $domain->h1 }}</td>
                <td>{{ $domain->meta_keywords }}</td>
                <td>{{ $domain->meta_description }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $domains->links() }}
@endsection