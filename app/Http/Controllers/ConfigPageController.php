<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\ConfigPage;
use App\Http\Resources\PaginateCollection;
class ConfigPageController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return $this->sendResponse(, 'allow access.');
        return new PaginateCollection(ConfigPage::paginate(request()->perpage));
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
            'text' => 'required',
            'option' => 'required',
            'state' => 'required',
        ]);
        $input = $request->all();
        $input['state']=($input['state']==true)?'true':'false';
        ConfigPage::create($input);
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
        $q=ConfigPage::find($id);
        return $this->sendResponse([
            'text' => $q->text,
            'option' => $q->option,
            'state' => ($q->state == 'true')?true:false,
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
        $q=ConfigPage::find($id);
        return $this->sendResponse([
            'text' => $q->text,
            'option' => $q->option,
            'state' => ($q->state == 'active')?true:false,
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
            'text' => 'required',
            'option' => 'required',
            'state' => 'required',
        ]);
        $input = $request->all();
        $input['state']=($input['state']==true)?'true':'false';
        ConfigPage::find($id)->update($input);
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
        ConfigPage::find($id)->delete();
        return $this->sendResponse($id, 'Delete successfully.');
    }
}
