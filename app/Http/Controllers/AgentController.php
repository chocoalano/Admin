<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\PaginateCollection;
use App\models\Agent;

class AgentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new PaginateCollection(Agent::orderBy('id', 'DESC')->paginate(request()->perpage));
    }

    public function truncate()
    {
        Agent::query()->truncate();
        return $this->sendResponse('Truncate', 'successfully.');
    }
    public function destroy($id)
    {
        Agent::find($id)->delete();
        return $this->sendResponse($id, 'Delete successfully.');
    }
    public function infoPengunjung()
    {
        $diakses=Agent::whereYear('created_at', '=', date('Y'))
        ->whereMonth('created_at', '=', date('m'))
        ->count();
        $user=Agent::whereYear('created_at', '=', date('Y'))
        ->whereMonth('created_at', '=', date('m'))
        ->distinct()->count('ip');
        $negara=Agent::whereYear('created_at', '=', date('Y'))
        ->whereMonth('created_at', '=', date('m'))
        ->distinct()->count('country_name');
        $wilayah=Agent::whereYear('created_at', '=', date('Y'))
        ->whereMonth('created_at', '=', date('m'))
        ->distinct()->count('region');
        $array=[
            [
              'title'=> 'Diakses',
              'total'=> $diakses,
            ],
            [
              'title'=> 'User',
              'total'=> $user,
            ],
            [
              'title'=> 'Negara',
              'total'=> $negara,
            ],
            [
              'title'=> 'Wilayah',
              'total'=> $wilayah,
            ],
        ];
        return response()->json($array,200);
    }
}
