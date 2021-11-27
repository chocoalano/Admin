<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Content;
use App\Http\Resources\PaginateCollection;

class ContentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return $this->sendResponse(, 'allow access.');
        return new PaginateCollection(Content::paginate(request()->perpage));
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
            'content' => 'required|min:100',
            'page_display' => 'required',
            'status' => 'required',
        ]);
        $input = $request->all();
        $input['status']=($input['status']==true)?'active':'nonactive';
        Content::create($input);
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
        $q=Content::find($id);
        return $this->sendResponse([
            'content' => $q->content,
            'page_display' => $q->page_display,
            'status' => ($q->status == 'active')?true:false,
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
        $q=Content::find($id);
        return $this->sendResponse([
            'content' => $q->content,
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
            'content' => 'required|min:100',
            'page_display' => 'required',
            'status' => 'required',
        ]);
        $input = $request->all();
        $input['status']=($input['status']==true)?'active':'nonactive';
        Content::find($id)->update($input);
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
        Content::find($id)->delete();
        return $this->sendResponse($id, 'Delete successfully.');
    }
}
