<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexSeller()
    {
        $users = User::where('role','=','seller')->get();
        $data = array(
            'user' => $users
        );

        return view('user.index', $data);
    }

    public function indexDriver()
    {
        $users = User::where('role','driver')->get();

        $data = array(
            'user' => $users
        );

        return view('user.index', $data);
    }

    public function indexMonitoring()
    {
        $users = User::where('role','=','seller')->with('product')->get();

        $data = array(
            'user' => $users
        );

        return view('monitoring.index', $data);
    }

    public function showMonitoring($id) {
        $users = User::where('id',$id)->with('product')->first();
        $data = array(
            'user' => $users
        );

        return view('monitoring.show', $data);
    }

    public function indexCustomer()
    {
        $users = User::where('role','=','customer')->get();

        $data = array(
            'user' => $users
        );

        return view('user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.manage');
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
            $this->validate($request,[
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required','string','max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8'],
            ]);

            $input = $request->all();

            $segments = explode('/', request()->path());
            $segment = $segments[0];

            User::create([
                'name' => $input['name'],
                'username' => $input['username'],
                'email' => $input['email'],
                'password' => bcrypt($input['password']),
                'role' => $segment == 'user-driver' ? 'driver' : 'seller',
                'status' => 'inactive'
            ]);

            return redirect($segment);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        $data = array(
            'user' => $user,
        );

        return view('user.manage', $data);
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
            $request->validate([
                'name' => 'required',
                'email' => 'required',
            ]);
            $input = $request->all();

            $segments = explode('/', request()->path());
            $segment = $segments[0];

            $user = User::find($id);
            $user->name = $input['name'];
            $user->username = $input['username'];
            $user->role = $input['role'];
            $user->email = $input['email'];
            if($input['password'] != ''){
                $user->password = bcrypt($input['password']);
            }
            $user->update();

            $segments = explode('/', request()->path());
            $segment = $segments[0];

            return redirect($segment);
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
        $user = User::find($id);

        $user->delete();

        $segments = explode('/', request()->path());
        $segment = $segments[0];

        return redirect($segment);
    }

    public function updateStatus(Request $request){
        try {
            $users = User::findorFail($request->id);
            $data['status'] = 'active';
            $users->update($data);

            return response('success');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
