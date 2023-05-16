<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;

class ShopsController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search = null;

        $query = Shop::latest();

        if ($request->has('search')) {
            $sort_search = $request->search;
        }

        $shops = $query->paginate(15);;
        return view('backend.shop.index', compact('shops', 'sort_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sellers = User::where('user_type', 'seller')->get();
        return view('backend.shop.create', compact('sellers'));
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
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'lat' => 'required',
            'long' => 'required',
        ]);

        $shop = Shop::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'email' => $request->email,
            'delivery_pickup_latitude' => $request->lat,
            'delivery_pickup_longitude' => $request->long,
            'status' => 1,
        ]);

        flash(translate('Shop has been created successfully'))->success();
        return redirect()->route('admin.shops.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function show(Shop $shop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function edit(Shop $shop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shop $shop)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shop $shop)
    {
        dd($shop);
        $shop->delete();
        flash(translate('Shop has been successfully deleted'))->success();
        return redirect()->route('admin.shops.index');
    }

    public function bulk_shop_delete(Request $request)
    {
        if ($request->id) {
            foreach ($request->id as $shop_id) {
                Shop::destroy($shop_id);
            }
        }

        return 1;
    }
}
