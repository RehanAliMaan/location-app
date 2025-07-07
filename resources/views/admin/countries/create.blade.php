@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add New Country</h2>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.countries.store') }}" method="POST">
        @csrf
        <label for="name">Country Name:</label>
        <input type="text" name="name" id="name" required>

        <br><br>
        <button type="submit">Save</button>
        <a href="{{ route('admin.countries.index') }}">Cancel</a>
    </form>
</div>
@endsection
