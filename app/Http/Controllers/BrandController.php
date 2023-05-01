<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\BrandTranslation;
use App\Models\Product;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search = null;
        $brands = Brand::orderBy('name', 'asc');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $brands = $brands->where('name', 'like', '%' . $sort_search . '%');
        }
        $brands = $brands->paginate(15);
        return view('backend.product.brands.index', compact('brands', 'sort_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $brand = new Brand;
        $brand->name = $request->name;
        $brand->meta_title = $request->meta_title;
        $brand->meta_description = $request->meta_description;
        if ($request->slug != null) {
            $brand->slug = str_replace(' ', '-', $request->slug);
        } else {
            $brand->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . Str::random(5);
        }

        $brand->logo = $request->logo;
        $brand->save();

        $brand_translation = BrandTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'brand_id' => $brand->id]);
        $brand_translation->name = $request->name;
        $brand_translation->save();

        flash(translate('Brand has been inserted successfully'))->success();
        return redirect()->route('brands.index');
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
    public function edit(Request $request, $id)
    {
        $lang   = $request->lang;
        $brand  = Brand::findOrFail($id);
        return view('backend.product.brands.edit', compact('brand', 'lang'));
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
            'slug' => 'required'
        ], [
            'slug.required' => "Please enter a slug"
        ]);

        $brand = Brand::findOrFail($id);
        if ($request->lang == env("DEFAULT_LANGUAGE")) {
            // $brand->name = $request->name;
            $brand->meta_title = $request->meta_title ?? $brand->name;
            $brand->meta_description = $request->meta_description;
            $brand->meta_keywords = $request->meta_keywords;

            $brand->og_title = $request->og_title ?? $request->meta_title;
            $brand->og_description = $request->og_description ?? $request->meta_description;

            $brand->twitter_title = $request->twitter_title ?? $request->meta_title;
            $brand->twitter_description = $request->twitter_description ?? $request->meta_description;
        }


        if ($request->slug != null) {
            $slug = strtolower(Str::slug($request->slug, '-'));
            $same_slug_count = Brand::where('slug', 'LIKE', $slug . '%')->count();
            $slug_suffix = $same_slug_count > 1 ? '-' . $same_slug_count + 1 : '';
            $slug .= $slug_suffix;
            $brand->slug = $slug;
        }

        $brand->logo = $request->logo;
        $brand->save();

        $brand_translation = BrandTranslation::firstOrNew(['lang' => $request->lang, 'brand_id' => $brand->id]);
        $brand_translation->name = $brand->name;

        $brand_translation->meta_title = $request->meta_title ?? $brand->meta_title;
        $brand_translation->meta_description = $request->meta_description ?? $brand->meta_description;
        $brand_translation->meta_keywords = $request->meta_keywords ?? $brand->meta_keywords;

        $brand_translation->og_title = $request->og_title ?? $brand_translation->og_title;
        $brand_translation->og_description = $request->og_description ?? $brand_translation->og_description;

        $brand_translation->twitter_title = $request->twitter_title ?? $brand_translation->og_title;
        $brand_translation->twitter_description = $request->twitter_description ?? $brand_translation->twitter_description;

        $brand_translation->save();

        flash(translate('Brand has been updated successfully'))->success();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        Product::where('brand_id', $brand->id)->delete();
        foreach ($brand->brand_translations as $key => $brand_translation) {
            $brand_translation->delete();
        }
        Brand::destroy($id);

        flash(translate('Brand has been deleted successfully'))->success();
        return redirect()->route('brands.index');
    }
}
