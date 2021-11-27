<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Gallery;
use App\Models\GalleryImg;
use App\Http\Resources\PaginateCollection;
use Illuminate\Support\Facades\Storage;

class GalleryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new PaginateCollection(Gallery::with('Img')->paginate(request()->perpage));
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
        if(isset($input['index'])){
            $validator = Validator::make($request->all(), [
                'group_name' => 'required',
                'page_display' => 'required',
                'status' => 'required'
            ]);
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());       
            }
            Gallery::create([
                "group_name" => $input['group_name'],
                "page_display" => $input['page_display'],
                "status" => $input['status'],
            ]);
        }elseif (isset($input['child'])) {
            $valids=['gallery_id' => 'required|numeric'];
            $f['foto']=[];
            for ($i=1; $i <= count($input)-2; $i++) { 
                $valids['foto_'.$i] = 'required|mimes:png,jpg,jpeg,gif|max:2048';
                array_push($f['foto'],$input['foto_'.$i]);
            }
            $validator = Validator::make($request->all(), $valids);
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());       
            }
            if($f['foto']){
                foreach ($f['foto'] as $file) {
                    $fileNameWithExt = $file->getClientOriginalName();
                    $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                    $extension = $file->getClientOriginalExtension();
                    $fileNameToStore = $fileName.'_'.time().'.'.$extension;
                    $path = $file->storeAs('/public/img', $fileNameToStore);
                    $foto = new GalleryImg(['photo' => $fileNameToStore]);
                    $gallery=Gallery::find($input['gallery_id']);
                    $gallery->Img()->save($foto);
                }       
            }
        }
        return $this->sendResponse($input, 'Created Successfuly');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->sendResponse(Gallery::with('Img')->find($id), 'allow access.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->sendResponse(Gallery::with('Img')->find($id), 'allow access.');
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
        if(isset($input['index'])){
            $validator = Validator::make($request->all(), [
                'group_name' => 'required',
                'page_display' => 'required',
                'status' => 'required'
            ]);
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());       
            }
            Gallery::find($id)->update([
                "group_name" => $input['group_name'],
                "page_display" => $input['page_display'],
                "status" => ($input['status']==true)?'active':'nonactive',
            ]);
        }elseif (isset($input['child'])) {
            $valids=[];
            $f['foto']=[];
            for ($i=1; $i <= count($input)-2; $i++) { 
                $valids['foto_'.$i] = 'required|mimes:png,jpg,jpeg,gif|max:2048';
                array_push($f['foto'],$input['foto_'.$i]);
            }
            $validator = Validator::make($request->all(), $valids);
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());       
            }
            if (count($f['foto'])>0) {
                $find=Gallery::find($id);
                $photos=$find->Img()->get();
                foreach ($photos as $k => $v) {
                    $file = 'public/img/'.$v->photo;
                    if (Storage::exists($file)) {
                        Storage::delete($file);
                    }
                }
                $find->Img()->delete();
                foreach ($f['foto'] as $file) {
                    $fileNameWithExt = $file->getClientOriginalName();
                    $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                    $extension = $file->getClientOriginalExtension();
                    $fileNameToStore = $fileName.'_'.time().'.'.$extension;
                    $path = $file->storeAs('/public/img', $fileNameToStore);
                    $foto = new GalleryImg(['photo' => $fileNameToStore]);
                    $find->Img()->save($foto);
                }
            }
        }
        return $this->sendResponse($input, 'Update Successfuly');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $find=Gallery::find($id);
        $photos=$find->Img()->get();
        foreach ($photos as $k => $v) {
            $file = 'public/img/'.$v->photo;
            if (Storage::exists($file)) {
                Storage::delete($file);
            }
        }
        $find->delete();
        return $this->sendResponse($id, 'Delete successfully.');
    }
}
