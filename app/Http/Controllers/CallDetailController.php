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
use Phpmailer;

class CallDetailController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:upload_csv');
//        $this->middleware('permission:role-create', ['only' => ['create','store']]);
//        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
//        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
  
    
    public function index(){
        return view('branch_maneger.upload_csv');
    }
    
    
    public function saveDesign(Request $request){
        $requestData = $request->all();
//        echo "<pre>";print_r($requestData);exit;
        $ftd_arr = $hap_no_arr = array();
        $this->validate($request, array(
            'sample_file'      => 'required'
        ));
 
        if($request->hasFile('sample_file')){
            $bpoMaster = $mobile_arr = array();
            $extension = File::extension($request->sample_file->getClientOriginalName());
            $inputFileName = $request->file('sample_file');//'excel_files/CDR.xlsx';
                if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
                    $array = Excel::toArray(new ImportUsers, $inputFileName);
                }
//                echo "<pre>";print_r($array);exit;
                $banch_code = Auth::user()->branch_id;
//                exit;
                $branch_detail = \App\Branch::select('branch_name')->where(['branch_id'=>$banch_code])->first();
                $last_code = \App\BPODetailMaster::select('calling_set_name')->orderBy('bpo_id','DESC')->first();
                
                if(!empty($branch_detail)){
                    $branc_code_three = substr($branch_detail->branch_name, 0, 3); 
                }
//                echo $branc_code_three;exit;
//                echo "<pre>";print_r($last_code);exit;
                if(!empty($last_code)){
                    $res = preg_replace("/[^0-9]/", "", $last_code->calling_set_name);
//                 
                        $calling_set_name = $branc_code_three."".$res;
                        $calling_set_name++;
                }else{
                    $calling_set_name = $branc_code_three.'001';
                }
//                echo $calling_set_name;exit;
                date_default_timezone_set('Asia/Kolkata');
                $bpoMaster['calling_set_name'] = $calling_set_name;
                $bpoMaster['uploaded_branch_id'] = Auth::user()->id;
                $bpoMaster['uploaded_date'] = date('Y-m-d');
                $bpoMaster['uploaded_time'] = date('H:i:s');
                
                if(!empty($requestData['sample_file'])) {
                    $design = $requestData['sample_file'];
                    $filename = $calling_set_name.".".$design->getClientOriginalExtension();
//                        echo $filename;exit;
                    $destination= "branch_upload_csv";
                    $design->move($destination,$filename);
                    $bpoMaster['file_name'] = $filename;
//                        exit;
                }
//                 echo "<pre>";print_r($bpoMaster);exit;
                $bpo_master = \App\BPODetailMaster::create($bpoMaster);
//                echo "<pre>";print_r($bpoMaster);exit;
                $i = 0;
                date_default_timezone_set('Asia/Kolkata');
                $arr= array();
//                echo "<pre>";print_r($array);exit;
                if(count($array)>0){
//                    In Built Format
                    foreach ($array[0] as $key => $value) {
                        if($i > 0 && !empty($value[0])){
                            if(!in_array(@$value[7], $mobile_arr)){
                            $mobile_arr[] = @$value[7];
                                $insert[] = [
                                'date'=>date('Y-m-d'),
                                'dealer_location' => @$value[0],
                                'enquiry_no' => @$value[1],
                                'enquiry_date' => $this->dateConvert(@$value[2]),
                                'team_lead_name' => @$value[3],
                                'dse_name' => @$value[4],
                                'prospect_name' => @$value[5],
                                'add_1'=> @$value[6],
                                'add_2'=> '',
                                'mobile_no'=> @$value[7],
                                'almobile_no'=> '',
                                'email_id'=> @$value[8],
                                'model_name'=> @$value[9],
                                'variant_name'=> @$value[10],
                                'financer_name'=> @$value[11],
                                'enquiry_status'=> @$value[12],
                                'source'=> @$value[13],
                                'buyer_type'=> @$value[14],
                                'test_drive_given'=> @$value[15],
                                'f_visit_date'=> $this->dateConvert(@$value[16]),
                                'state'=> 'Maharashtra',
                                'activity'=> @$value[20],
                                'landmark'=> '',
                                'followup1'=> @$value[17],
                                'followup2'=>@$value[18],
                                'followup3'=>@$value[19],
                                'followup4'=> '',
                                'final_sr_remark'=> '',
                                'bpo_master_id'=> $bpo_master->bpo_id
                                ];
                        }
                        }
                        $i++;
                    }
                    
                    
//                    echo "<pre>";print_r($insert);exit;
                    if(!empty($insert)){
                        $insertData = DB::table('tbl_bpo_details')->insert($insert);
                        if ($insertData) {
                            Session::flash('alert-success','Created Successfully.');
                        }else {                        
                            Session::flash('error', 'Error inserting the data..');
                            return back();
                        }
                    }
                }
                
                require_once('phpmailer/PHPMailerAutoload.php');
                $mail = new PHPMailer(true);
                $mail->IsSMTP();
                $mail->Host = "smtp.gmail.com"; // SMTP server
                $mail->Port = 465;
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = "ssl";
                $mail->Username = 'asrindustry2019@gmail.com';
                $mail->Password = 'ASR@1234'; // Set mailer to use SMTP
                $mail->From = "asrindustry2019@gmail.com";
                $mail->FromName = "ASR INDUSTRIES";

        //        $mail->addAddress('shilpa.jadhav@iping.in');
        //        $mail->addAddress('shnavghare@asrindustries.com');
        //        $mail->addAddress('shilpa.jadhav@iping.in');
                $mail->isHTML(true);
                $body = 'Hello All,<br/><br/>'
                    . 'Please find attachment of Daily Analysis Report for till';
               // $path = 'excel/daily_analysis_report/DPAR - Hind WRD - abc.xlsx';
               // $mail->addAttachment($path);
                $mail->Subject = "DPAR - Hind WRD";
                $mail->Body = $body;
                $mail->AltBody = "This is the plain text version of the email content";
                
//                $email_arr = 
//                
//                foreach($email_arr as $e)
//                {
//                    $mail->addAddress($e);
//                }
                $mail->addAddress('shilpa.jadhav@iping.in');
        //        echo "<pre>"; print_r($mail);exit;
                $mail->Subject = "New Data";
                $mail->Body = $body;
                $mail->AltBody = "This is the plain text version of the email content";

                if (!$mail->send()) {
                    echo 'Mailer Error: ' . $mail->ErrorInfo;
                }
//                else{
//                    return 1;
//                }
        }
        Session::flash('alert-success', 'Uploaded Successfully.');
//        \App\Order::where('order_id','=',$order_id)->update(['design_status'=>'1']);
//        \App\DesignManager::where('order_id','=',$order_id)->update(['release_status'=>'1']);
        return redirect('upload_csv');
    }
    
    public function dateConvert($date){
        $timestamp = strtotime($date);
        $newDate = date('Y-m-d', $timestamp); 
//        echo $newDate;   
        return $newDate;
    }

    public function showCallDetailUpdatedstatus(){
        $call_detail_dept_wise = DB::table('tbl_bpo_detail_master')
                        //->select('*')
                        ->select('tbl_bpo_detail_master.bpo_id','tbl_bpo_details.id','tbl_bpo_details.mobile_no','tbl_bpo_details.prospect_name',
                                'bop_user_status','bop_user_remark','users.name','tbl_bpo_detail_master.calling_set_name')
                        ->leftjoin('tbl_bpo_details','tbl_bpo_details.bpo_master_id','tbl_bpo_detail_master.bpo_id')
                        ->leftjoin('users','users.id','tbl_bpo_details.assign_bpo_user_id')
                        ->where('tbl_bpo_details.bop_user_status','!=',"Callback")
                        ->where('tbl_bpo_detail_master.data_set_status','=',1)
                        ->orWhere('tbl_bpo_detail_master.data_set_status','=',2)
                        ->where(['tbl_bpo_details.show_branch_admin'=>1])
                        ->get();
//        echo "<pre>";print_r($call_detail_dept_wise);exit;
        return view('branch_maneger.call_detail_updated_status',['call_detail_dept_wise'=>$call_detail_dept_wise]);
    }

    public function assignData(){
        $arr = ["Interested","Finance-not-Approved","Product-Not-Delivered","Future Interested"];
        $call_detail_dept_wise = DB::table('tbl_bpo_detail_master')
                        ->select('tbl_bpo_detail_master.bpo_id','tbl_bpo_details.id','tbl_bpo_details.mobile_no','tbl_bpo_details.prospect_name',
                                'bop_user_status','bop_user_remark','users.name','tbl_bpo_detail_master.calling_set_name')
                        ->leftjoin('tbl_bpo_details','tbl_bpo_details.bpo_master_id','tbl_bpo_detail_master.bpo_id')
                        ->leftjoin('users','users.id','tbl_bpo_details.assign_bpo_user_id')
                        ->where(['tbl_bpo_details.show_branch_admin'=>1])
                        ->where(['tbl_bpo_details.tl_assign_status'=>0])
                        ->whereIn('tbl_bpo_detail_master.data_set_status',array(1,2))
//                        ->where(['tbl_bpo_detail_master.data_set_status'=>2])
                        ->whereIn('tbl_bpo_details.bop_user_status',array("Interested","Finance-not-Approved","Product-Not-Delivered","Future Interested"))
                        ->get();
        $team_leader =  $users = \App\User::select('id','name')->where(['branch_id'=>Auth::user()->branch_id])->whereHas('roles', function($q){
                            $q->where('role_id', '9');
                         })->get();
//         echo "<pre>";print_r($call_detail_dept_wise);exit;
        return view('branch_maneger.assign_data',['call_detail_dept_wise'=>$call_detail_dept_wise,'team_leader'=>$team_leader]);
    }
    
    public function updateAssign(Request $request){
        $requestData = $request->all();
        if(count($requestData['assign_tl'])>0){
            foreach($requestData['assign_tl'] as $tl){
                \App\BPODetail::where(['id'=>$tl])->update(['assign_tl_id'=>$requestData['assign_tl_id'],'tl_assign_status'=>1]);
            }
        }
        Session::flash('alert-success', 'Assign Successfully.');
        return redirect('assign_data_sales_executive');
       // echo "<pre>";print_r($requestData);exit;
    }
    
    public function getUploadecsv(){
        $branch_id = Auth::user()->id;
        $uploade_file = \App\BPODetailMaster::select('bpo_id','file_name','calling_set_name','uploaded_date')->where(['uploaded_branch_id'=>$branch_id])->orderBy('uploaded_date')->get();
//        echo "<pre>";print_r($uploade_file);exit;
        return view('branch_maneger.uploaded_file',['uploade_file'=>$uploade_file]);
    }
    
    
}
