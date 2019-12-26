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
$id = Auth::user()->id;
    $mobile_no_detail = DB::table('tbl_bpo_detail_master')
                ->select('tbl_bpo_detail_master.bpo_id','tbl_bpo_details.id','tbl_bpo_details.mobile_no')
                ->leftjoin('tbl_bpo_details','tbl_bpo_details.bpo_master_id','tbl_bpo_detail_master.bpo_id')
                ->where('tbl_bpo_details.assign_dse_id','=',$id)
                ->where(['tbl_bpo_details.assign_dse_status'=>1])
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
               <form class="form-horizontal" id="userForm" method="get" action="{{ url('get_dse_data') }}">
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
                <form class="form-horizontal" id="userForm" method="post" action="{{ url('update_dse_data') }}">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <input type="hidden" name="id" value="{{$cust_detail->id}}" />
                        <div class="form-group">
                            <label for="userName" class="col-sm-2 control-label" >Dealer Location</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  placeholder="Dealer Location" value="{{$cust_detail->dealer_location}}" id="dealer_location" name="dealer_location"   >
                            </div>
                            <label for="userName" class="col-sm-2 control-label">Enquiry No.</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  placeholder="Enquiry No" value="{{$cust_detail->enquiry_no}}" id="enquiry_no" name="enquiry_no"   >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="userName" class="col-sm-2 control-label">Enquiry Date</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  placeholder="Enquiry Date" value="{{$cust_detail->enquiry_date}}" id="enquiry_date" name="enquiry_date"   >
                            </div>
                            <label for="userName" class="col-sm-2 control-label">Team Lead Name</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  placeholder="Team Lead Name" value="{{$cust_detail->team_lead_name}}" id="team_lead_name" name="team_lead_name"   >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="userName" class="col-sm-2 control-label">DSE Name</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  placeholder="DSE Name" value="{{$cust_detail->dse_name}}" id="dse_name" name="dse_name"   >
                            </div>
                            <label for="userName" class="col-sm-2 control-label">Prospect Name</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  placeholder="Prospect Name" value="{{$cust_detail->prospect_name}}" id="prospect_name" name="prospect_name"  >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="userName" class="col-sm-2 control-label">Address</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  placeholder="Address" value="{{$cust_detail->add_1}}" id="add_1" name="add_1"  >
                            </div>
                            <label for="userName" class="col-sm-2 control-label">Mobile Number</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  placeholder="Mobile Number" value="{{$cust_detail->mobile_no}}" id="mobile_no" name="mobile_no"  >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="userName" class="col-sm-2 control-label">Email Id</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  placeholder="Email Id" value="{{$cust_detail->email_id}}" id="email_id" name="email_id"  >
                            </div>
                            <label for="userName" class="col-sm-2 control-label">Model Name</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  placeholder="Model Name" value="{{$cust_detail->model_name}}" id="model_name" name="model_name"  >
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="userName" class="col-sm-2 control-label">Variant Name</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  placeholder="Variant Name" value="{{$cust_detail->variant_name}}" id="variant_name" name="variant_name"  >
                            </div>
                            <label for="userName" class="col-sm-2 control-label">Financier Name</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  placeholder="Financier Name" value="{{$cust_detail->financer_name}}" id="financer_name" name="financer_name"   >
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label for="userName" class="col-sm-2 control-label">Enquiry Status</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  placeholder="Enquiry Status" value="{{$cust_detail->enquiry_status}}" id="enquiry_status" name="enquiry_status"  >
                            </div>
                            <label for="userName" class="col-sm-2 control-label">Source</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  placeholder="Source" value="{{$cust_detail->source}}" id="source" name="source"   >
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label for="userName" class="col-sm-2 control-label">Buyer Type</label>
                            <div class="col-sm-4">
                                <select id="buyer_type" name="buyer_type" class="form-control select2"  required>
                                    <option value="">-- Select Buyer Type --</option>
                                    <option value="First Time Buyer" <?php if($cust_detail->buyer_type == "First Time Buyer") echo "selected"; ?>>First Time Buyer</option>
                                    <option value="Additional Buyer" <?php if($cust_detail->buyer_type == "Additional Buyer") echo "selected"; ?>>Additional Buyer</option>
                                    <option value="Replacement Buyer" <?php if($cust_detail->buyer_type == "Replacement Buyer") echo "selected"; ?>>Replacement Buyer</option>
                                </select>
                                <!--<input type="text" class="form-control"  placeholder="City" value="{{$cust_detail->buyer_type}}" id="buyer_type" name="buyer_type"  >-->
                            </div>
                            <label for="userName" class="col-sm-2 control-label">Test Drive Given</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  placeholder="Test Drive Given" value="{{$cust_detail->test_drive_given}}" id="test_drive_given" name="test_drive_given"   >
                            </div>
                        </div>
                        <div id="by_type">
                            <div class="form-group">
                                <label for="userName" class="col-sm-2 control-label">Make</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control"  placeholder="Make" value="{{$cust_detail->make}}" id="make" name="make"   >
                                </div>
                                <label for="userName" class="col-sm-2 control-label">Model</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control"  placeholder="Model" value="{{$cust_detail->model}}" id="model" name="model"   >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="userName" class="col-sm-2 control-label">Color</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control"  placeholder="Color" value="{{$cust_detail->color}}" id="color" name="color"   >
                                </div>
                                <label for="userName" class="col-sm-2 control-label">Region No</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control"  placeholder="Region No" value="{{$cust_detail->region_no}}" id="region_no" name="region_no"   >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="userName" class="col-sm-2 control-label">Valuation Done</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control"  placeholder="Valuation Done" value="{{$cust_detail->valuation_done}}" id="valuation_done" name="valuation_done"   >
                                </div>
                                <label for="userName" class="col-sm-2 control-label">Valuator</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control"  placeholder="Valuator" value="{{$cust_detail->valuator}}" id="valuator" name="valuator"   >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="userName" class="col-sm-2 control-label">Expected Price</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control"  placeholder="Expected Price" value="{{$cust_detail->expected_price}}" id="expected_price" name="expected_price"   >
                                </div>
                                <label for="userName" class="col-sm-2 control-label">Offered Price</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control"  placeholder="Offered Price" value="{{$cust_detail->offered_price}}" id="offered_price" name="offered_price"   >
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="userName" class="col-sm-2 control-label">First Date</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  placeholder="City" value="{{$cust_detail->f_visit_date}}" id="f_visit_date" name="f_visit_date"  >
                            </div>
                             <label for="userName" class="col-sm-2 control-label">Activity</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  placeholder="Activity" value="{{$cust_detail->activity}}" id="activity" name="activity"  >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="userName" class="col-sm-2 control-label">Follow Up Date</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"  placeholder="Follow Up Date" value="{{$cust_detail->f_visit_date}}" id="follow_up_date" name="follow_up_date"  >
                            </div>
                            <label for="userName" class="col-sm-2 control-label">Order Status</label>
                            <div class="col-sm-3">
                                <select id="order_status" name="order_status" class="form-control select2"  >
                                    <option value="">-- Select Status --</option>
                                    <option value="Loss">Loss</option>
                                    <option value="Close">Close</option>
                                </select>
                            </div>
                        </div>
                        <div class="row col-sm-12 input-group control-group after-add-more">
                        <div class="form-group">
                            <label for="userName" class="col-sm-2 control-label">Status</label>
                            <div class="col-sm-3">
                                <select id="telle_caller_status" name="telle_caller_status" class="form-control select2"  required>
                                    <option value="">-- Select Status --</option>
                                    <option value="Hot">Hot</option>
                                    <option value="Cold">Cold</option>
                                    <option value="Warm">Warm</option>
                                </select>
                            </div>
                            <label for="userName" class="col-sm-1 control-label">Remark</label>
                            <div class="col-sm-5">
                                <!--<input type="text" class="form-control"  placeholder="Search Mobile No" value="" id="automplete-1"    >-->
                                <textarea class="form-control " placeholder="Remark" id="telle_caller_remark" name="telle_caller_remark"  ></textarea>
                            </div>
                            <div class="input-group-btn col-sm-1"> 
                              <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i> </button>
                            </div>
                        </div>
                    </div>
                        
                        <table class="table table-bordered table-striped dataTable no-footer">
                            <tr>
                                <th>Sr No</th>
                                <th>Status</th>
                                <th>Remark</th>
                                <th>User</th>
                            </tr>
                        <?php
                        $json_detail = json_decode($cust_detail->prev_bpo_user_detail,true);
                        $x =1;
                        if(!empty($json_detail)){ ?>
                            <?php foreach($json_detail as $json){  
                                if(isset($json['assign_bpo_user_id'] )){
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
                            $user_name = App\User::select('name')->where(['id'=>$cust_detail->assign_bpo_user_id])->first();
                            ?>
                            <tr>
                                <td>{{$x++}}</td>
                                <td>{{$cust_detail->bop_user_status}}</td>
                                <td>{{$cust_detail->bop_user_remark}}</td>
                                <td>{{$user_name->name}}</td>
                            </tr>
                        <?php } ?>
                        <!--DSE Status-->    
                        <?php
                        $json_detail = json_decode($cust_detail->prev_telle_caller_user_detail,true);
                      //  $x =1;
                        if(!empty($json_detail)){ ?>
                            <?php foreach($json_detail as $json){  
                                if(isset($json['assign_bpo_user_id'] )){
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
                        if($cust_detail->telle_caller_status != "") { 
                            $user_name = App\User::select('name')->where(['id'=>$cust_detail->assign_telle_caller_id])->first();
                            ?>
                            <tr>
                                <td>{{$x++}}</td>
                                <td>{{$cust_detail->telle_caller_status}}</td>
                                <td>{{$cust_detail->telle_caller_remark}}</td>
                                <td>{{$user_name->name}}</td>
                            </tr>
                        <?php } ?>
                            
                    </table>
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

$('#buyer_type').on('change', function() {
    var type = $("#buyer_type").val();
//    alert(type);
      if ( type == 'First Time Buyer')
      //.....................^.......
      {
          $("#by_type").hide();
        
      }
      else
      {
         $("#by_type").show();
      }
    });
$("#buyer_type").trigger("change");

      $(".add-more").click(function(){ 
//          var html = $(".copy").html();
          $(".after-add-more").append('<div class="form-group "><label for="userName" class="col-sm-2 control-label">Status</label><div class="col-sm-3"><select name="bop_user_status" class="form-control "  required><option value="">-- Select Status --</option><option value="Callback">Callback</option><option value="Not Intrested">Not Intrested</option><option value="Loss To Competitor">Loss To Competitor</option><option value="Interested">Interested</option><option value="Finance-not-Approved">Finance-not-Approved</option><option value="Product-Not-Delivered">Product-Not-Delivered</option><option value="Product-delivered">Product-delivered</option><option value="Wrong Number">Wrong Number</option><option value="Customer-Cancelled">Customer-Cancelled</option><option value="Future Interested">Future Interested</option></select></div><label for="userName" class="col-sm-1 control-label">Remark</label><div class="col-sm-5"><textarea class="form-control automplete-1" placeholder="Remark" id="activity" name="activity"  ></textarea></div><div class="input-group-btn col-sm-1"><button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i></button></div></div>');
          $('select').select2();
          $( ".automplete-1" ).autocomplete( "option", "source", availableTutorials );
      });


      $("body").on("click",".remove",function(){ 
          $(this).parents(".form-group").remove();
      });

});
</script>
@endsection
