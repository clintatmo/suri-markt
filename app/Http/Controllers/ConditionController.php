<?php

namespace App\Http\Controllers;

use App\Condition;
use Illuminate\Http\Request;

class ConditionController extends Controller
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
        $conditions = Condition::all();
        return response()->json([
            'conditions'    => $conditions,
        ], 200);
    }

    /**
     * Search resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $conditions = Condition::where('name', 'LIKE', '%a%')->get();
        return response()->json([
            'conditions'    => $conditions,
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

        $condition = Condition::create([
            'name'        => request('name')
        ]);

        return response()->json([
            'condition'    => $condition,
            'message' => 'Success'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Condition  $condition
     * @return \Illuminate\Http\Response
     */
    public function show(Condition $condition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Condition  $condition
     * @return \Illuminate\Http\Response
     */
    public function edit(Condition $condition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Condition  $condition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Condition $condition)
    {
        $this->validate($request, [
            'name'        => 'required|max:255'
        ]);

        $condition->name = request('name');
        $condition->save();

        return response()->json([
            'message' => 'Condition updated successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Condition  $condition
     * @return \Illuminate\Http\Response
     */
    public function destroy(Condition $condition)
    {
        //
    }
}
