<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\Name;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::where('user_id', Auth::user()->id)->get();

        return view('product.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = ProductCategory::all();
        $name = Name::all();

        $data = [
            'category' => $category,
            'name' => $name,
        ];

        return view('product.manage', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // $this->validate($request, [
            //     'category_id' => ['required'],
            //     'name_id' => ['required','string'],
            //     'description' => ['required','string'],
            //     'price' => ['required','numeric'],
            //     'weight' => ['required','numeric'],
            //     'stock' => ['required','numeric'],
            //     'url_image' => ['required','file','mimes:png,jpg']
            // ]);

            $image = $request->file('url_image');
            $data = [
                'category_id' => $request->category_id,
                'name_id' => $request->name_id,
                'description' => $request->description,
                'harvest_season' => $request->harvest_season,
                'expired_information' => $request->expired_information,
                'purchase_detail' => $request->purchase_detail,
                'price' => $request->price,
                'weight' => $request->weight,
                'stock' => $request->stock,
                'user_id' => Auth::user()->id,
            ];

            if ($request->hasFile('url_image')) {
                $product = Product::create($data);
                $file_name = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('public/product/image', $file_name);

                $data = [
                    'product_id' => $product->id,
                    'url_image' => $file_name,
                ];

                ProductImage::create($data);
            }

            // return response()->json(['message' => 'Product has been added']);
            return redirect('product');
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        $product_image = ProductImage::where('product_id', '=', $id)->get();

        $data = [
            'product' => $product,
            'image' => $product_image,
        ];

        return view('product.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $category = ProductCategory::all();
        $name = Name::all();

        $data = [
            'product' => $product,
            'category' => $category,
            'name' => $name,
        ];

        return view('product.manage', $data);
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
        $input = $request->all();
        $image = $request->file('url_image');

        $product = Product::find($id);
        $product->category_id = $input['category_id'];
        $product->name_id = $input['name_id'];
        $product->description = $input['description'];
        $product->harvest_season = $input['harvest_season'];
        $product->expired_information = $input['expired_information'];
        $product->purchase_detail = $input['purchase_detail'];
        $product->weight = $input['weight'];
        $product->price = $input['price'];
        $product->stock = $input['stock'];

        if (!empty($image)) {
            $product_image = ProductImage::where('product_id', '=', $id)->first();
            $product_image->product_id = $id;

            $old_path = 'public/product/image/' . $product_image->url_image;
            // dd($old_path);
            Storage::delete($old_path);
            $file_name = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/product/image/', $file_name);
            $product_image->url_image = $file_name;

            $product_image->update();
        }

        $product->update();

        return redirect('product');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        $product->delete();

        return redirect('product')->with('success', 'hoo');
    }
}
