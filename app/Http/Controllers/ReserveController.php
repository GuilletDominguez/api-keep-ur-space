<?php

namespace App\Http\Controllers;

use App\Models\Reserve;
use Illuminate\Http\Request;

class ReserveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       $reserve = Reserve::with('user', 'room')->orderBy('status','DESC')->paginate(10);

       return [
        'paginate' => [
           'total' => $reserve->total(),
           'current' => $reserve->currentPage(), 
           'per_page' => $reserve->perPage(),
           'last_page' => $reserve->lastPage(),
           'from' => $reserve->firstItem(),
           'to' => $reserve->lastPage(),
        ],

        'reserves'=> $reserve


    ];
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
            'dateStart' => 'required',
            'dateEnd' => 'required',
            'hourStart'=> 'required',
            'hourEnd'=> 'required'
        ]);

        Reserve::create($request->all());

        $response = [
            'message' => 'Tu petición se ha registrado con éxito'
        ];

        return response($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Reserve::with('user','room')->find($id);
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
        $reserve = Reserve::find($id);
        $reserve->update($request->all());

        $response = [

            'message' => 'Tu petición ha sido modificada con éxito'
        ];

        return response($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Reserve::destroy($id);

        $response = [

            'message' => 'Tu petición ha sido borrada con éxito'
        ];
        return response($response, 200);
    }
    /**
     * Search reserves by user.
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function search($id)
    {

        return ;
    }

    public function getStats(){

        return [
            'total' => count(Reserve::all()),
            'pending' => count(Reserve::where('status', '=', "Pending")->get()),
            'accepted' => count(Reserve::where('status', '=', "Accepted")->get()),
            'cancelled'=> count(Reserve::where('status','=', 'Cancelled')->get())


        ];
    }

    public function getStatsByUser($id){

        $user = Reserve::where('user_id', 'like', '%' . $id . '%')->get();

        return [
            'total' => count($user),
            'pending' => count($user->where('status', '=', "Pending")),
            'accepted' => count($user->where('status', '=', 'Accepted')),
            'cancelled'=> count($user->where('status','=', 'Cancelled'))
        ];

    }
}
