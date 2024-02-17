<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product_image = ProductImage::all();

        $data = array(
            'product_image' => $product_image,
        );

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('product')
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
            $this->validate($request, [
                'product_id' => ['required'],
                'url_image' => ['required','file','mimes:png,jpg'],
            ]);

            $image = $request->file('image');

            if ($request->hasFile('image')) {
                $file_name = time() . "_" . $image->getClientOriginalName();
                $image->storeAs('public/product/image', $file_name);

                $data = array(
                    'product_id' => $request->product_id,
                    'url_image' => $file_name,
                );

                ProductImage::create($data);

                return redirect('product_image');
            }
        } catch (\Throwable $th) {
            return redirect()->back();
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
        $product_image = ProductImage::find($id);


        // return
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product_image = ProductImage::find($id);

        return view('product_image.manage', compact('product_image'));
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
        try {
            $this->validate($request, [
                'product_id' => ['required'],
                'url_image' => ['required','file','mimes:png,jpg'],
            ]);

            $input = $request->all();

            $image = $request->file('image');

            $product_image = ProductImage::find($id);
            $product_image->product_id = $input['product_id'];

            if (!empty($image)) {
                $old_path = 'public/product/image'. $product_image->url_image;
                Storage::delete($old_path);
                $file_name = time(). "_". $image->getClientOriginalName();
                $image->storeAs('public/product/image', $file_name);
                $product_image->url_image = $file_name;
            }

            $product_image->update();

            return redirect('product_image');
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product_image = ProductImage::find($id);

        $product_image->delete();

        return redirect('product_image');
    }
}
