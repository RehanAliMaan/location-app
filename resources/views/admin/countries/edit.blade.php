@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Country</h2>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.countries.update', $country->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="name">Country Name:</label>
        <input type="text" name="name" id="name" value="{{ $country->name }}" required>

        <br><br>
        <button type="submit">Update</button>
        <a href="{{ route('admin.countries.index') }}">Cancel</a>
    </form>
</div>
@endsection
