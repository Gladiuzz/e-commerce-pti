<?php

namespace App\Http\Controllers;

use App\Models\Name;
use Illuminate\Http\Request;

class NameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $name = Name::all();

        $data = array(
            'name' => $name,
        );

        return view('name.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('name.manage');
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
            //     'name' => ['required'],
            // ]);

            $data = array(
                'name' => $request->name,
                'batasan_harga' => $request->batasan_harga,
            );

            Name::create($data);

            return redirect('product-name');
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
            // return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Name  $name
     * @return \Illuminate\Http\Response
     */
    public function show(Name $name)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Name  $name
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $name = Name::find($id);

        return view('name.manage', compact('name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Name  $name
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        try {
            $input = $request->all();

            $value = Name::find($id);
            $value->name = $request->name;
            $value->batasan_harga = $request->batasan_harga;
            $value->update();
            
            return redirect('product-name');

        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Name  $name
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $name = Name::find($id);
        // $product = Name::where('category_id',$id)->get();

        // foreach ($product as $key => $value) {
        //     $productDelete = Product::find($value->id);
        //     $productDelete->delete();
        // }

        $name->delete();

        return redirect('name');
    }
}
