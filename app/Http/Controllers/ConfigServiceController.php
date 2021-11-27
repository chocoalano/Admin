<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConfigService;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\PaginateCollection;
class ConfigServiceController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return $this->sendResponse(, 'allow access.');
        return new PaginateCollection(ConfigService::paginate(request()->perpage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $this->validate($request, [
            'icon' => 'required|mimes:png,jpg,jpeg,svg|max:2048',
            'title' => 'required',
            'status' => 'required',
        ]);
        $fileNameWithExt=$input['icon']->getClientOriginalName();
        $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
        $extension=$input['icon']->getClientOriginalExtension();
        $fileNameToStore = $fileName.'_'.time().'.'.$extension;
        $input['icon']->storeAs('/public/img/service', $fileNameToStore);
        $save=[
            'icon' => $fileNameToStore,
            'title' => $input['title'],
            'status' => $input['status'],
        ];
        ConfigService::create($save);
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
        $q=ConfigService::find($id);
        return $this->sendResponse([
            'title' => $q->title,
            'status' => $q->status,
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
        $q=ConfigService::find($id);
        return $this->sendResponse([
            'title' => $q->title,
            'status' => $q->status,
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
        $input = $request->all();
        $this->validate($request, [
            'icon' => 'required|mimes:png,jpg,jpeg,svg|max:2048',
            'title' => 'required',
            'status' => 'required',
        ]);
        $v=ConfigService::find($id);
        $file = 'public/img/service/'.$v->icon;
        if (Storage::exists($file)) {
            Storage::delete($file);
        }
        $fileNameWithExt=$input['icon']->getClientOriginalName();
        $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
        $extension=$input['icon']->getClientOriginalExtension();
        $fileNameToStore = $fileName.'_'.time().'.'.$extension;
        $input['icon']->storeAs('/public/img/service', $fileNameToStore);
        $save=[
            'icon' => $fileNameToStore,
            'title' => $input['title'],
            'status' => $input['status'],
        ];
        ConfigService::find($id)->update($save);
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
        $v=ConfigService::find($id);
        $file = 'public/img/service/'.$v->icon;
        if (Storage::exists($file)) {
            Storage::delete($file);
        }
        $v->delete();
        return $this->sendResponse($id, 'Delete successfully.');
    }
}
