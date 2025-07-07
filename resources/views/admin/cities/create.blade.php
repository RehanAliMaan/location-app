@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add City</h2>

    <form action="{{ route('admin.cities.store') }}" method="POST">
        @csrf
        <label>Name:</label>
        <input type="text" name="name" required>

        <label>Province:</label>
        <select name="province_id" required>
            <option value="">--Select--</option>
            @foreach($provinces as $province)
                <option value="{{ $province->id }}">
                    {{ $province->name }} ({{ $province->country->name }})
                </option>
            @endforeach
        </select>

        <button type="submit">Create</button>
    </form>
</div>
@endsection
