<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;

class CountryAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
    {
        $countries = Country::all(); // fetch data from DB

        return view('admin.countries.index', compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
{
    return view('admin.countries.create');
}



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function store(Request $request)
{
    $request->validate([
        'name' => 'required|unique:countries,name',
    ]);

    \App\Models\Country::create([
        'name' => $request->name
    ]);

    return redirect()->route('admin.countries.index')
        ->with('success', 'Country added successfully!');
}


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
{
    $country = \App\Models\Country::findOrFail($id);
    return view('admin.countries.edit', compact('country'));
}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|unique:countries,name,' . $id,
    ]);

    $country = \App\Models\Country::findOrFail($id);
    $country->update(['name' => $request->name]);

    return redirect()->route('admin.countries.index')
        ->with('success', 'Country updated successfully!');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
{
    $country = \App\Models\Country::findOrFail($id);
    $country->delete();

    return redirect()->route('admin.countries.index')
        ->with('success', 'Country deleted successfully!');
}
}
