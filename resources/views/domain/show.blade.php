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
        </tr>
        </thead>
        <tbody>
        <tr>
            <th scope="row">{{ $domain->getKey() }}</th>
            <td>{{ $domain->name }}</td>
            <td>{{ $domain->created_at }}</td>
            <td>{{ $domain->code }}</td>
            <td>{{ $domain->content_length }}</td>
        </tr>
        </tbody>
    </table>
@endsection