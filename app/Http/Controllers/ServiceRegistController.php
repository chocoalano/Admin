<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\PaginateCollection;
use App\Models\ServiceRegist;
class ServiceRegistController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return $this->sendResponse(, 'allow access.');
        return new PaginateCollection(ServiceRegist::paginate(request()->perpage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'tanggal' => 'required',
            'alamat' => 'required',
            'keluhan' => 'required',
        ]);
        $input = $request->all();
        ServiceRegist::create($input);
        return $this->sendResponse($input, 'allow access.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $q=ServiceRegist::find($id);
        return $this->sendResponse([
            'nama' => $q->nama,
            'tanggal' => $q->tanggal,
            'alamat' => $q->alamat,
            'keluhan' => $q->keluhan,
        ], 'allow access.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $q=ServiceRegist::find($id);
        return $this->sendResponse([
            'nama' => $q->nama,
            'tanggal' => $q->tanggal,
            'alamat' => $q->alamat,
            'keluhan' => $q->keluhan,
        ], 'allow access.');
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
        $this->validate($request, [
            'nama' => 'required',
            'tanggal' => 'required',
            'alamat' => 'required',
            'keluhan' => 'required',
        ]);
        $input = $request->all();
        ServiceRegist::find($id)->update($input);
        return $this->sendResponse($input, 'Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ServiceRegist::find($id)->delete();
        return $this->sendResponse($id, 'Delete successfully.');
    }
}
