<?php

namespace App\Http\Controllers;

use App\Wish;
use Illuminate\Http\Request;

class WishController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('wishlist.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            'name'=>'required|string|min:5|max:100',
            'description'=>'required|string|min:5|max:200',
            'desire'=>'required|integer|min:1|max:10',
            'url'=>'nullable',
            'price'=>'nullable|numeric'
        ]);

        $data['purchased_by'] = null;
        $data['purchased_at'] = null;

        auth()->user()->wishes()->create($data);

        return redirect('/wishlist/'.auth()->id());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Wish  $wish
     * @return \Illuminate\Http\Response
     */
    public function show(Wish $wish)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Wish  $wish
     * @return \Illuminate\Http\Response
     */
    public function edit(Wish $wish)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Wish  $wish
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wish $wish)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Wish  $wish
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wish $wish)
    {
        $this->authorize('delete',$wish);
        $wish->delete();
    }

    public function purchase(Wish $wish) {
        $this->authorize('purchase',$wish);
        $wish->purchase();
    }

    public function unpurchase(Wish $wish) {
        $this->authorize('unpurchase',$wish);
        $wish->unpurchase();
    }
}
