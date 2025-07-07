@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Admin Dashboard</h1>

   <ul style="list-style-type: none; padding: 0;">
    <li style="margin-bottom: 10px;">
        <a href="{{ route('admin.countries.index') }}"
           style="display: inline-block; background-color: #007bff; color: white; padding: 12px 25px; text-decoration: none; border-radius: 6px; font-weight: bold;">
            CRUD Countries
        </a>
    </li>
    <li style="margin-bottom: 10px;">
        <a href="{{ route('admin.provinces.index') }}"
           style="display: inline-block; background-color: #28a745; color: white; padding: 12px 25px; text-decoration: none; border-radius: 6px; font-weight: bold;">
            CRUD Provinces
        </a>
    </li>
    <li style="margin-bottom: 10px;">
        <a href="{{ route('admin.cities.index') }}"
           style="display: inline-block; background-color: #ffc107; color: black; padding: 12px 25px; text-decoration: none; border-radius: 6px; font-weight: bold;">
            CRUD Cities
        </a>
    </li>
</ul>

</div>
@endsection
