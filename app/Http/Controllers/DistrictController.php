<?php

namespace App\Http\Controllers;

use App\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $districts = District::all();
        return response()->json([
            'districts'    => $districts,
        ], 200);
    }

    /**
     * Search resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $qry = request('qry');
        $districts = District::where('name', 'LIKE', "%{$qry}%")->get();
        return response()->json([
            'districts'    => $districts,
            'message' => 'Success'
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'        => 'required|max:255'
        ]);

        $district = District::create([
            'name'        => request('name')
        ]);

        return response()->json([
            'district'    => $district,
            'message' => 'Success'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\District  $district
     * @return \Illuminate\Http\Response
     */
    public function show(District $district)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\District  $district
     * @return \Illuminate\Http\Response
     */
    public function edit(District $district)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\District  $district
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, District $district)
    {
        $this->validate($request, [
            'name'        => 'required|max:255'
        ]);

        $district->name = request('name');
        $district->save();

        return response()->json([
            'message' => 'District updated successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\District  $district
     * @return \Illuminate\Http\Response
     */
    public function destroy(District $district)
    {
        //
    }
}
