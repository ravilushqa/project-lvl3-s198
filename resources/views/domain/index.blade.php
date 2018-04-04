@extends('layouts.app')

@section('content')
    <table class="table table-bordered table-dark">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Created at</th>
        </tr>
        </thead>
        <tbody>
        @foreach($domains as $domain)
            <tr>
                <th scope="row">{{ $domain->getKey() }}</th>
                <td><a href="{{ $domain->name }}">{{ $domain->name }}</a></td>
                <td>{{ $domain->created_at }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $domains->links() }}
@endsection