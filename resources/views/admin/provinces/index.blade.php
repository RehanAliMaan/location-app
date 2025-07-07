@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Provinces</h2>

    <a href="{{ route('admin.provinces.create') }}">Add New Province</a>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Country</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($provinces as $province)
                <tr>
                    <td>{{ $province->id }}</td>
                    <td>{{ $province->name }}</td>
                    <td>{{ $province->country->name }}</td>
                    <td>
                        <a href="{{ route('admin.provinces.edit', $province->id) }}">Edit</a>
                        <form action="{{ route('admin.provinces.destroy', $province->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Delete this province?')" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
