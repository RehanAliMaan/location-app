@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add Province</h2>

    <form action="{{ route('admin.provinces.store') }}" method="POST">
        @csrf
        <label>Name:</label>
        <input type="text" name="name" required>

        <label>Country:</label>
        <select name="country_id" required>
            <option value="">--Select--</option>
            @foreach($countries as $country)
                <option value="{{ $country->id }}">{{ $country->name }}</option>
            @endforeach
        </select>

        <button type="submit">Create</button>
    </form>
</div>
@endsection
