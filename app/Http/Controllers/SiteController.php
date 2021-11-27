<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\Agent;
use App\Models\ConfigPage;
use App\Models\ConfigService;
use App\Models\Medsos;
use App\Models\ConfigSlider;
use App\Models\ServiceRegist;
use App\Models\SeoMeta;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $param=request()->page;
        $content=Content::where(['page_display'=>$param,'status'=>'active'])->first();
        return response()->json(['content'=>$content->content],200);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function galeri()
    {
        $content=DB::table('galleries as ga')
        ->join('galleries_img as gi','gi.gallery_id','=','ga.id')
        ->where(['ga.status'=>'active'])->paginate(10);
        return response()->json($content->items(),200);
    }
    public function agentPost(Request $request)
    {
        Agent::create($request->all());
        return response()->json(['req'=>$request->all(),'msg'=>'successfully.'],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function template()
    {
        $sitename=ConfigPage::where(['state'=>'true','option'=>'sitename'])->first();
        $footer=ConfigPage::where(['state'=>'true','option'=>'footer'])->first();
        $zargon=ConfigPage::where(['state'=>'true','option'=>'zargon'])->first();
        return response()->json([
            'sitename'=>($sitename !== null)?$sitename->text:'',
            'footer'=>($footer !== null)?$footer->text:'',
            'zargon'=>($zargon !== null)?$zargon->text:''
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function medsos()
    {
        $q=Medsos::where(['status'=>'true'])->get();
        $data=[];
        foreach ($q as $key) {
            array_push($data,['icon'=>$key['icon'],'link'=>$key['link']]);
        }
        return response()->json($data,200);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function carousel()
    {
        $q=ConfigSlider::where(['status'=>'true'])->get();
        $data=[];
        foreach ($q as $key) {
            array_push($data,['src'=>$key['img']]);
        }
        return response()->json($data,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function service()
    {
        $q=ConfigService::where(['status'=>'true'])->get();
        $data=[];
        foreach ($q as $key) {
            array_push($data,['icon'=>$key['icon'],'title'=>$key['title']]);
        }
        return response()->json($data,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userposted(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'tanggal' => 'required',
            'alamat' => 'required',
            'keluhan' => 'required',
        ]);
        $input = $request->all();
        ServiceRegist::create($input);
        return response()->json($input,200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function seo($page)
    {
        $q=SeoMeta::where('page',$page)->first();
        return response()->json($q,200);
    }
}
