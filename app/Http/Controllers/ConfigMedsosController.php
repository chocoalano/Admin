<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Medsos;
use App\Http\Resources\PaginateCollection;

class ConfigMedsosController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new PaginateCollection(Medsos::paginate(request()->perpage));
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
            'icon' => 'required',
            'link' => 'required',
            'status' => 'required',
        ]);
        $input = $request->all();
        $input['status'] = ($input['status']==true)?'true':'false';
        Medsos::create($input);
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
        $q=Medsos::find($id);
        return $this->sendResponse([
            'icon' => $q->icon,
            'link' => $q->link,
            'status' => ($q->status=='false')?false:true,
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
        $q=Medsos::find($id);
        return $this->sendResponse([
            'Medsos' => $q->Medsos,
            'page_display' => $q->page_display,
            'status' => ($q->status == 'active')?true:false,
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
            'icon' => 'required',
            'link' => 'required',
            'status' => 'required',
        ]);
        $input = $request->all();
        $input['status'] = ($input['status']==true)?'true':'false';
        Medsos::find($id)->update($input);
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
        Medsos::find($id)->delete();
        return $this->sendResponse($id, 'Delete successfully.');
    }
}
