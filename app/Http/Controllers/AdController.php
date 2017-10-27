<?php

namespace App\Http\Controllers;

use App\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdController extends Controller
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
        $ads = Ad::where(['user_id' => Auth::user()->id])->get();
        return response()->json([
            'ads'    => $ads,
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
        $ads = Ad::where('title', 'LIKE', "%{$qry}%")->get();
        return response()->json([
            'ads'    => $ads,
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
            'title'        => 'required|max:255',
            'description' => 'required',
            'currency' => 'required',
            'price' => 'required',
            'condition' => 'required',
            'category' => 'required',
            'district' => 'required',
        ]);

        $ad = Ad::create([
            'title'        => request('title'),
            'description' => request('description'),
            'currency_id' => request('currency'),
            'price' => request('price'),
            'condition_id' => request('condition'),
            'category_id' => request('category'),
            'district_id' => request('district'),
            'user_id'     => Auth::user()->id,
            'deleted'     => false
        ]);

        return response()->json([
            'ad'    => $ad,
            'message' => 'Success'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function show(Ad $ad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function edit(Ad $ad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ad $ad)
    {
        $this->validate($request, [
            'title'        => 'required|max:255',
            'description' => 'required',
            'currency_id' => 'required',
            'price' => 'required',
            'condition_id' => 'required',
            'category_id' => 'required',
            'district_id' => 'required',
        ]);

        $ad->title = request('title');
        $ad->description = request('description');
        $ad->currency_id = request('currency_id');
        $ad->price = request('price');
        $ad->condition_id = request('condition_id');
        $ad->category_id = request('category_id');
        $ad->district_id = request('district_id');
        $ad->currency_id = request('currency_id');
        $ad->save();

        return response()->json([
            'message' => 'Ad updated successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ad $ad)
    {
        //
    }
}
