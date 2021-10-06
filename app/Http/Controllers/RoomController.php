<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         return Room::all();
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
            'capacity' => 'required',
        ]);
        
     Room::create($request->all());

      $response = [
         'message' => 'Tu sala se ha creado con éxito'
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
        return Room::find($id);
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
        $room = Room::find($id);
        $room->update($request->all());

        return $response = [
            'status' => 200,
            'message' => 'Tu petición ha sido modificada con éxito'
        ] ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Room::destroy($id);
        
        return $response = [
            'status' => 200,
            'message' =>'Tu petición ha sido borrada con éxito'
        ];
    }
      /**
     * Search room.
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        
        return Room::where('name','like','%'.$name.'%')->get();
    }
         /**
     * Search room.
     *
     * @param  int  $capacity
     * @return \Illuminate\Http\Response
     */
    public function filterCapacity ($capacity)
    {
        
        return Room::where('capacity','like','%'.$capacity.'%')->get();
    }


}
