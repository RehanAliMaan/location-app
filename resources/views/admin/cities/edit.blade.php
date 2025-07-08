@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit City</h2>

    <form action="{{ route('admin.cities.update', $city->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Name:</label>
        <input type="text" name="name" value="{{ $city->name }}" required>

        <label>Province:</label>
        <select name="province_id" required>
            @foreach($provinces as $province)
                <option value="{{ $province->id }}" {{ $city->province_id == $province->id ? 'selected' : '' }}>
                    {{ $province->name }} ({{ $province->country->name }})
                </option>
            @endforeach
        </select>

        <label>Latitude:</label>
        <input type="number" step="0.0000001" name="latitude" value="{{ $city->latitude }}" placeholder="e.g. 31.5497">

        <label>Longitude:</label>
        <input type="number" step="0.0000001" name="longitude" value="{{ $city->longitude }}" placeholder="e.g. 74.3436">

        <button type="submit">Update</button>
    </form>
</div>
@endsection
