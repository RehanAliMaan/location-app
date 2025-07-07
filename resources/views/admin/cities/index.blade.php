@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Cities</h2>

    <a href="{{ route('admin.cities.create') }}">Add New City</a>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Province</th>
                <th>Country</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cities as $city)
                <tr>
                    <td>{{ $city->id }}</td>
                    <td>{{ $city->name }}</td>
                    <td>{{ $city->province->name }}</td>
                    <td>{{ $city->province->country->name }}</td>
                    <td>
                        <a href="{{ route('admin.cities.edit', $city->id) }}">Edit</a>
                        <form action="{{ route('admin.cities.destroy', $city->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Delete this city?')" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
