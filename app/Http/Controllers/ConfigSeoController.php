<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\PaginateCollection;
use App\Models\SeoMeta;
class ConfigSeoController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return $this->sendResponse(, 'allow access.');
        return new PaginateCollection(SeoMeta::paginate(request()->perpage));
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
            'hid' => 'required',
            'name' => 'required',
            'content' => 'required',
            'title' => 'required',
            'page' => 'required',
        ]);
        $input = $request->all();
        SeoMeta::create($input);
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
        $q=SeoMeta::find($id);
        return $this->sendResponse([
            'hid' => $q->hid,
            'name' => $q->name,
            'content' => $q->content,
            'title' => $q->title,
            'page' => $q->page,
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
        $q=SeoMeta::find($id);
        return $this->sendResponse([
            'hid' => $q->hid,
            'name' => $q->name,
            'content' => $q->content,
            'title' => $q->title,
            'page' => $q->page,
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
            'hid' => 'required',
            'name' => 'required',
            'content' => 'required',
            'title' => 'required',
            'page' => 'required',
        ]);
        $input = $request->all();
        SeoMeta::find($id)->update($input);
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
        SeoMeta::find($id)->delete();
        return $this->sendResponse($id, 'Delete successfully.');
    }
}
