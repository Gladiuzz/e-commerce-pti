<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Customer;
use DB;

class CustomerController extends Controller
{
    public function showProfile()
    {
        $customer = Auth::user(); // Ambil data pelanggan dari user yang sedang login

        return view('customer.profile', compact('customer'));
    }

    public function editProfile()
    {
        $customer = Auth::user(); // Ambil data pelanggan dari user yang sedang login

        return view('customer.edit-profile', compact('customer'));
    }

    public function updateProfile(Request $request)
    {
        //$customer = Auth::user(); // Ambil data pelanggan dari user yang sedang login

        //$customer->name = $request->input('name');
        //$customer->address = $request->input('address');
        //$customer->phone = $request->input('phone');
        //$customer->save();
        // Update atribut lain sesuai kebutuhan

        $id = Auth::user()->id;

        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
        ];

        $save = DB::table('users')
            ->where('id', $id)
            ->update($data);

        return redirect()
            ->route('ubah.profil.pelanggan')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
