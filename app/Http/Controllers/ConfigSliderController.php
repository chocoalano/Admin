<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\PaginateCollection;
use Illuminate\Support\Facades\Storage;
use App\Models\ConfigSlider;
class ConfigSliderController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new PaginateCollection(ConfigSlider::paginate(request()->perpage));
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
            'img' => 'required',
            'status' => 'required',
        ]);
        $input = $request->all();
        $fileNameWithExt=$input['img']->getClientOriginalName();
        $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
        $extension=$input['img']->getClientOriginalExtension();
        $fileNameToStore = $fileName.'_'.time().'.'.$extension;
        $input['img']->storeAs('/public/img/slider', $fileNameToStore);
        $save=[
            'img' => $fileNameToStore,
            'status' => $input['status'],
        ];
        ConfigSlider::create($save);
        return $this->sendResponse($save, 'allow access.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $q=ConfigSlider::find($id);
        return $this->sendResponse([
            'img' => $q->img,
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
        $q=ConfigSlider::find($id);
        return $this->sendResponse([
            'img' => $q->img,
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
        $this->validate($request, [
            'img' => 'required',
            'status' => 'required',
        ]);
        $input = $request->all();
        $v=ConfigSlider::find($id);
        $file = 'public/img/slider/'.$v->img;
        if (Storage::exists($file)) {
            Storage::delete($file);
        }
        $fileNameWithExt=$input['img']->getClientOriginalName();
        $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
        $extension=$input['img']->getClientOriginalExtension();
        $fileNameToStore = $fileName.'_'.time().'.'.$extension;
        $input['img']->storeAs('/public/img/slider', $fileNameToStore);
        $save=[
            'img' => $fileNameToStore,
            'status' => $input['status'],
        ];
        ConfigSlider::find($id)->update($save);
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
        $v=ConfigSlider::find($id);
        $file = 'public/img/slider/'.$v->img;
        if (Storage::exists($file)) {
            Storage::delete($file);
        }
        $v->delete();
        return $this->sendResponse($id, 'Delete successfully.');
    }
}
