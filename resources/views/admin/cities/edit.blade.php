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

        <button type="submit">Update</button>
    </form>
</div>
@endsection
