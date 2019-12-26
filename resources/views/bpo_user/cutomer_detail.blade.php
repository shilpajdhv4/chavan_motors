@extends('layouts.app')
@section('title', 'Add New Branch')
@section('content')
<style>
@media only screen and (max-width: 600px) {
    .mobile_date {
        width: 160px;
    }
}
</style>

<?php 
    $mobile_no_detail = DB::table('tbl_bpo_detail_master')
                ->select('tbl_bpo_detail_master.bpo_id','tbl_bpo_details.id','tbl_bpo_details.mobile_no')
                ->leftjoin('tbl_bpo_details','tbl_bpo_details.bpo_master_id','tbl_bpo_detail_master.bpo_id')
                ->where('tbl_bpo_detail_master.data_set_status','=',1)
                ->where(['tbl_bpo_details.show_branch_admin'=>0])
                ->orWhere(['tbl_bpo_details.bop_user_status'=>"Callback"])// && ['tbl_bpo_details.show_branch_admin'=>1])
//                ->orWhere('tbl_bpo_details.bop_user_status','=',"")
                ->get();
    
    
//    echo "<pre>";print_r($mobile_no_detail);exit;
?>
<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
         rel = "stylesheet">
<script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
    jq162 = jQuery.noConflict( true );
    jq162(function() {
       var availableTutorials  =  [
          "Customer was busy,callback",
          "Customer not available Call after some time",
          "Customer not intrested & call disconnected.",
          "He did just inquiry but Still not decided to purchase this vehicle.",
          "Have Financial Problem,so not intrested.",
          "Customer purchased this vehicle but out of Solapur(City Name)",
          "Customer have Exchange(Valuation) Problem So Not Intrested now.",
          "Customer purchased 2nd hand Vehicle not Intrested in New Vehicle.{____}",
          "Our Executive not responding properly So customer not Interested & unhappy with our service.",
          "Customer have Document's Problem so Customer not interested",
          "Have Price diffrence so customer purchased in other city.",
          "Loss to Competitor Already Customer Purchased other model {Model Name}",
          "Customer Intrested In this(……month…)",
          "Customer booked & going on process for delivery.",
          "Customer ready to visit in next week.",
          "Customer Intrested but in other Model {_______}….want to change model.",
          "Customer want to exchange his old vehicle to new (……Model…..)",
          "Customer Intrested but have some financial issue so postpone for next 3 month.",
          "Have Finance Problem Still Not Approved Customer loan.",
          "Customer Intrested but have CIBIL Problem.",
          "Customer booked vehicle on this…(.. branch…..)",
          "Already Delivered Product {_____________}",
          "Spoke with Mr.(______) and he said wrong number.",
          "Have Finance Problem,so cancelled this booking now.",
          "Have Price diffrence so customer purchased in other city.",
          "Customer have Exchange Valuation Problem so Cancelled.",
          "customer passed away so Cancelled",
          "Customer Purcheased 2nd hand Model so Cancelled this booking {_____}.",
          "Customer Intrested In Jan-19 ",
          "Already booked & on going process for delivery.",
          "Customer Intrested but in other Model {_______}",
          "Customer want to exchange his old vehicle & purchase new model.",
          "Customer Intrested but have some finance issue so postpone for 3 month.",
          "Have Finance Problem Still Not Approved.",
          "Customer have his old vehicle Model(….)but don't want to seal his old vehicle Model(……..)",
          "Customer have old vehicle Model(….) & ready to Exchange his old vehicle to new Model(……)",
          "Customer not interested to exchange or buy new vehicle",
          "Customer don't have any old vehicle but want to buy new vehicle"
       ];
       jq162( ".automplete-1" ).autocomplete({
          source: availableTutorials
       });
    });
</script>      
<section class="content-header">
    <h1>
        Customer Form
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ url('enq_location_list') }}"> Back</a>
        </div>
    </h1>
</section>
@if (Session::has('alert-success'))
<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
    <h4 class="alert-heading">Success!</h4>
    {{ Session::get('alert-success') }}
</div>
@endif
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary" >
               <form class="form-horizontal" id="userForm" method="get" action="{{ url('customer_detail') }}">
                <div class="box-body">                        
                    <div class="form-group">
                        <label for="userName" class="col-sm-2 control-label">Search Mobile No</label>
                        <div class="col-sm-4">
                            <?php if(isset($_GET['mobile_no'])) { $selct_val = $_GET['mobile_no']; } else { $selct_val = ""; } ?>
                            <select  name="mobile_no" class="form-control select2"  required>
                                <option value="">-- Select Mobile No --</option>
                                @foreach($mobile_no_detail as $mobile)
                                <option value="{{$mobile->id}}" <?php if($mobile->id == $selct_val) echo "selected"; ?>>{{$mobile->mobile_no}}</option>
                                @endforeach
                            </select>
                            <!--<input type="text" id="automplete-1" class="form-control"  placeholder="Search Mobile No" value="" id="automplete-1" name="mobile_no"  required >-->
                        </div>
                        <div class="col-sm-2">
                            <button class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </div>
               </form>
            </div>
            
<?php if(isset($_GET['mobile_no'])){ 
    $cust_detail = App\BPODetail::where(['id'=>$_GET['mobile_no']])->first();
    ?>
            <div class="box box-primary" >
                <div class="box-header">
                    <h3 class="box-title"></h3>
                </div>
                <form class="form-horizontal" id="userForm" method="post" action="{{ url('update_customer_detail') }}">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <input type="hidden" name="id" value="{{$cust_detail->id}}" />
                        <div class="form-group">
                            <label for="userName" class="col-sm-2 control-label" >Name</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control"  placeholder="Name" value="{{$cust_detail->prospect_name}}" id="name" name="name"   >
                            </div>
                            <label for="userName" class="col-sm-2 control-label">Middle Name</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control"  placeholder="Middle Name" value="{{$cust_detail->middle_name}}" id="middle_name" name="middle_name"   >
                            </div>
                            <label for="userName" class="col-sm-2 control-label">Last Name</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control"  placeholder="Last Name" value="{{$cust_detail->last_name}}" id="last_name" name="last_name"   >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="userName" class="col-sm-2 control-label">Address 1</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  placeholder="Address 1" value="{{$cust_detail->add_1}}" id="add_1" name="add_1"   >
                            </div>
                            <label for="userName" class="col-sm-2 control-label">Address 2</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  placeholder="Address 2" value="{{$cust_detail->add_2}}" id="add_2" name="add_2"   >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="userName" class="col-sm-2 control-label">Mobile No</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control"  placeholder="Mobile No" value="{{$cust_detail->mobile_no}}" id="mobile_no" name="mobile_no"  >
                            </div>
                            <label for="userName" class="col-sm-2 control-label">ALT Mobile No</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control"  placeholder="ALT Mobile No" value="{{$cust_detail->almobile_no}}" id="almobile_no" name="almobile_no"  >
                            </div>
                            <label for="userName" class="col-sm-2 control-label">Email ID</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control"  placeholder="Email ID" value="{{$cust_detail->email_id}}" id="email_id" name="email_id"  >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="userName" class="col-sm-2 control-label">Model</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  placeholder="Model" value="{{$cust_detail->model_name}}" id="model" name="model"  >
                            </div>
                            <label for="userName" class="col-sm-2 control-label">Variant Name</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  placeholder="Variant Name" value="{{$cust_detail->variant_name}}" id="color" name="color"  >
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="userName" class="col-sm-2 control-label">City</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  placeholder="City" value="{{$cust_detail->dealer_location}}" id="city" name="city"  >
                            </div>
                            <label for="userName" class="col-sm-2 control-label">State</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  placeholder="State" value="{{$cust_detail->state}}" id="state" name="state"   >
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label for="userName" class="col-sm-2 control-label">Activity</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  placeholder="Activity" value="{{$cust_detail->activity}}" id="activity" name="activity"  >
                            </div>
                        </div>
                        <div class="row col-sm-12 input-group control-group after-add-more">
                        <div class="form-group">
                            <label for="userName" class="col-sm-2 control-label">Status</label>
                            <div class="col-sm-3">
                                <select id="bop_user_status" name="bop_user_status" class="form-control select2"  required>
                                    <option value="">-- Select Status --</option>
                                    <option value="Callback">Callback</option>
                                    <option value="Not Intrested">Not Intrested</option>
                                    <option value="Loss To Competitor">Loss To Competitor</option>
                                    <option value="Interested">Interested</option>
                                    <option value="Finance-not-Approved">Finance-not-Approved</option>
                                    <option value="Product-Not-Delivered">Product-Not-Delivered</option>
                                    <option value="Product-delivered">Product-delivered</option>
                                    <option value="Wrong Number">Wrong Number</option>
                                    <option value="Customer-Cancelled">Customer-Cancelled</option>
                                    <option value="Future Interested">Future Interested</option>
                                </select>
                            </div>
                            <label for="userName" class="col-sm-1 control-label">Remark</label>
                            <div class="col-sm-5">
                                <!--<input type="text" class="form-control"  placeholder="Search Mobile No" value="" id="automplete-1"    >-->
                                <textarea class="form-control automplete-1" placeholder="Remark" id="bop_user_remark" name="bop_user_remark"  ></textarea>
                            </div>
                            <div class="input-group-btn col-sm-1"> 
                              <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i> </button>
                            </div>
                        </div>
                    </div>
                        
                        <?php
                        $json_detail = json_decode($cust_detail->prev_bpo_user_detail,true);
//                        echo "<pre>";print_r($json_detail);exit;
                        ?>
                        
                        <?php
//                        echo "hii";exit;
                        $x =1;
                        if(!empty($json_detail)){ ?>
                        <table class="table table-bordered table-striped dataTable no-footer">
                            <tr>
                                <th>Sr No</th>
                                <th>Status</th>
                                <th>Remark</th>
                                <th>User</th>
                            </tr>
                            <?php foreach($json_detail as $json){  
                                if(isset($json->assign_bpo_user_id )){
//                                 echo "hii";exit;
                            $user_name = App\User::select('name')->where(['id'=>$json['assign_bpo_user_id']])->first();
                            ?>
                            <tr>
                                <td>{{$x++}}</td>
                                <td>{{$json['status']}}</td>
                                <td>{{$json['bop_user_remark']}}</td>
                                <td>{{$user_name->name}}</td>
                            </tr>
                            <?php  } }
                        }
                        
                        if($cust_detail->bop_user_status != "") { 
//                            echo "hiiiii";exit;
                            $user_name = App\User::select('name')->where(['id'=>$cust_detail->assign_bpo_user_id])->first();
                            ?>
                            <tr>
                                <td>{{$x++}}</td>
                                <td>{{$cust_detail->bop_user_status}}</td>
                                <td>{{$cust_detail->bop_user_remark}}</td>
                                <td>{{$user_name->name}}</td>
                            </tr>
                        </table>
                        <?php } //echo "hii";exit;//else { ?>
                    
                        <?php // } ?>
                    <div class="box-footer">
                        <button type="submit"  id="btnsubmit" class="btn btn-success">Save</button>
                        <a href="{{url('branch_list')}}" class="btn btn-danger" >Cancel</a>
                    </div>
                </form>
            </div>
<?php } ?>
        </div>   
    </div>
        
</section>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">  
<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="assets/libs/jquery/dist/jquery.min.js"></script>
<script src="js/jquery.steps.min.js"></script>
<script src="js/sweetalert.min.js"></script>
<script src="assets/libs/jquery-validation/dist/jquery.validate.min.js"></script>
<script type="text/javascript">
   
$(document).ready(function () {
    $('select').select2();
//    $("#brand_head_id").on("change",function(){
//        alert();
//    })

      $(".add-more").click(function(){ 
//          var html = $(".copy").html();
          $(".after-add-more").append('<div class="form-group "><label for="userName" class="col-sm-2 control-label">Status</label><div class="col-sm-3"><select name="bop_user_status" class="form-control "  required><option value="">-- Select Status --</option><option value="Callback">Callback</option><option value="Not Intrested">Not Intrested</option><option value="Loss To Competitor">Loss To Competitor</option><option value="Interested">Interested</option><option value="Finance-not-Approved">Finance-not-Approved</option><option value="Product-Not-Delivered">Product-Not-Delivered</option><option value="Product-delivered">Product-delivered</option><option value="Wrong Number">Wrong Number</option><option value="Customer-Cancelled">Customer-Cancelled</option><option value="Future Interested">Future Interested</option></select></div><label for="userName" class="col-sm-1 control-label">Remark</label><div class="col-sm-5"><textarea class="form-control automplete-1" placeholder="Remark" id="activity" name="activity"  ></textarea></div><div class="input-group-btn col-sm-1"><button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i></button></div></div>');
          $('select').select2();
          $( ".automplete-1" ).autocomplete( "option", "source", availableTutorials );
      });

       $("body").on("click",".remove",function(){ 
          $(this).parents(".form-group").remove();
      });
//      $("body").on("click",".remove",function(){ 
//          $(this).parents(".control-group").remove();
//      });

});
</script>
@endsection
