@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Province</h2>

    <form action="{{ route('admin.provinces.update', $province->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Name:</label>
        <input type="text" name="name" value="{{ $province->name }}" required>

        <label>Country:</label>
        <select name="country_id" required>
            @foreach($countries as $country)
                <option value="{{ $country->id }}" {{ $province->country_id == $country->id ? 'selected' : '' }}>
                    {{ $country->name }}
                </option>
            @endforeach
        </select>

        <button type="submit">Update</button>
    </form>
</div>
@endsection
