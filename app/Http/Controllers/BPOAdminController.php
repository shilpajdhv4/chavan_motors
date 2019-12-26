<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;

class BPOAdminController extends Controller
{
//    0 = waiting;
//    1 = Inprocess;
//    2 = completed;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
         $this->middleware('permission:data_set_list');
    }
    
    public function getList(){
//        $waiting = \App\BPODetailMaster::get();
        $waiting = DB::table('tbl_bpo_detail_master')
                 ->select('tbl_bpo_detail_master.*','users.id','users.name','users.branch_id')
                 ->leftjoin('users','users.id','tbl_bpo_detail_master.uploaded_branch_id')
                 ->whereNull('data_set_status')
                 ->orderBy('bpo_id','DESC')
                 ->get();
//        echo "<pre>";print_r($waiting);exit;
        $inprocess = DB::table('tbl_bpo_detail_master')
                 ->select('tbl_bpo_detail_master.*','users.id','users.name','users.branch_id')
                 ->leftjoin('users','users.id','tbl_bpo_detail_master.uploaded_branch_id')
                 ->where(['data_set_status'=>1])
                 ->orderBy('bpo_id','DESC')
                 ->get();
        $completed = DB::table('tbl_bpo_detail_master')
                 ->select('tbl_bpo_detail_master.*','users.id','users.name','users.branch_id')
                 ->leftjoin('users','users.id','tbl_bpo_detail_master.uploaded_branch_id')
                 ->where(['data_set_status'=>2])
                 ->orderBy('bpo_id','DESC')
                 ->get();
        return view('bpo_admin.list_data_set',['waiting'=>$waiting,'inprocess'=>$inprocess,'completed'=>$completed]);
    }
    
    public function saveStatus(Request $request){
        $requestData = $request->all();
        \App\BPODetailMaster::where(['bpo_id'=>$requestData['bpo_id']])->update(['data_set_status'=>$requestData['data_set_status']]);
        return redirect('data_set_list');
      //  $download_data = \App\BPODetail::where(['bpo_master_id'=>$requestData['bpo_id']])->get();
      //  return view('bpo_admin.download_data_set',['download_data'=>$download_data]);
    }
    
    public function downloadDataset(){
        $bpo_id = $_GET['id'];
        $download_data = \App\BPODetail::where(['bpo_master_id'=>$bpo_id])->get();
//        echo "<pre>";print_r($download_data);exit;
        return view('bpo_admin.download_data_set',['download_data'=>$download_data]);
    }
    
}