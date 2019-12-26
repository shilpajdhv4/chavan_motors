<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use DateTime;
use File;
use Session;
use Excel;
use Samples;
use App\Imports\ImportUsers;
use Illuminate\Support\Facades\Auth;

class TeamLeaderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:get_tl_data');
//        $this->middleware('permission:role-create', ['only' => ['create','store']]);
//        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
//        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    public function getTeamLeaderData(){
        $tl_id = Auth::user()->id; 
        $call_detail_dept_wise = DB::table('tbl_bpo_detail_master')
                        ->select('tbl_bpo_detail_master.bpo_id','tbl_bpo_details.id','tbl_bpo_details.mobile_no','tbl_bpo_details.prospect_name',
                                'bop_user_status','bop_user_remark','users.name','tbl_bpo_detail_master.calling_set_name')
                        ->leftjoin('tbl_bpo_details','tbl_bpo_details.bpo_master_id','tbl_bpo_detail_master.bpo_id')
                        ->leftjoin('users','users.id','tbl_bpo_details.assign_bpo_user_id')
                        ->where(['tbl_bpo_details.assign_tl_id'=>$tl_id])
                        ->where(['tbl_bpo_details.assign_dse_status'=>0])
                        ->get();
        $team_leader =  $users = \App\User::select('id','name')->whereHas('roles', function($q){
                            $q->where('role_id', '10');
                         })->get();
        return view('team_leader.assign_data',['call_detail_dept_wise'=>$call_detail_dept_wise,'team_leader'=>$team_leader]);
    }
     
    public function updateAssign(Request $request){
        $requestData = $request->all();
//        echo "<pre>";print_r($requestData);exit;
        if(count($requestData['assign_tl'])>0){
            foreach($requestData['assign_tl'] as $tl){
                \App\BPODetail::where(['id'=>$tl])->update(['assign_dse_id'=>$requestData['assign_dse_id'],'assign_dse_status'=>1]);
            }
        }
        Session::flash('alert-success', 'Assign Successfully.');
        return redirect('get_tl_data');
       // echo "<pre>";print_r($requestData);exit;
    }
    
}
