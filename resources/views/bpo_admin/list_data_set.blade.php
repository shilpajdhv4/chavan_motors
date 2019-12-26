@extends('layouts.app')
@section('title', 'Add New Location')
@section('content')
<style>
@media only screen and (max-width: 600px) {
    .mobile_date {
        width: 160px;
    }
}
</style>
<?php $i=$j=$k = 1; ?>
<section class="content-header">
    <h1>
        Data Set Lists
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
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab"><h4><b>Waiting</b></h4></a></li>
                <li><a href="#tab_2" data-toggle="tab"><h4><b>InProcess</b></h4></a></li>
                <li><a href="#tab_3" data-toggle="tab"><h4><b>Completed</b></h4></a></li>
              <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                  <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Data Set Name</th>
                            <th>User Name</th>
                            <th>Branch Name</th>
                            <th>Upload Date</th>
                            <th>Update Status</th>
                            <th>Action</th>
                        </tr>
                        @foreach($waiting as $wt)
                        <?php $branch_name = App\Branch::select('branch_name')->where(['branch_id'=>$wt->branch_id])->first(); ?>
                        <tr id="{{$wt->bpo_id}}">
                            <td>{{$i++}}</td>
                            <td>{{$wt->calling_set_name}}</td>
                            <td>{{$wt->name}}</td>
                            <td>{{$branch_name->branch_name}}</td>
                            <td>{{$wt->uploaded_date}}</td>
                            <td><button class="btn btn-block btn-success btn-xs status_detail start_status" >Update Status</button></td>
                            <td><a href="{{url('download_set_list?id='.$wt->bpo_id)}}" class="btn btn-block btn-success btn-xs">Download</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Data Set Name</th>
                            <th>Branch Name</th>
                            <th>Upload Date</th>
                            <th>Update Status</th>
                            <th>Action</th>
                        </tr>
                        @foreach($inprocess as $ip)
                        <tr id="{{$ip->bpo_id}}">
                            <td>{{$j++}}</td>
                            <td>{{$ip->calling_set_name}}</td>
                            <td>{{$ip->name}}</td>
                            <td>{{$ip->uploaded_date}}</td>
                            <td><button class="btn btn-block btn-success btn-xs status_detail start_status" >Update Status</button></td>
                            <td><a href="{{url('download_set_list?id='.$ip->bpo_id)}}" class="btn btn-block btn-success btn-xs">Download</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">
               <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Data Set Name</th>
                            <th>Branch Name</th>
                            <th>Upload Date</th>
                            <th>Action</th>
                        </tr>
                        @foreach($completed as $cmpl)
                        <tr >
                            <td>{{$k++}}</td>
                            <td>{{$cmpl->calling_set_name}}</td>
                            <td>{{$cmpl->name}}</td>
                            <td>{{$cmpl->uploaded_date}}</td>
                            <td><a href="{{url('download_set_list?id='.$cmpl->bpo_id)}}" class="btn btn-block btn-success btn-xs">Download</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
    </div>
</section>
<div class="modal fade" id="modal-default">
    <form class="form-horizontal" id="userForm" method="post" >
                    {{ csrf_field() }}
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Download & Update Status</h4>
              </div>
              <div class="modal-body">
                <div class="form-group">
                    <label for="userName" class="col-sm-2 control-label">Status<span style="color:red"> * </span></label>
                    <div class="col-sm-8">
                        <select class="form-control select2" style="width: 100%;" name="data_set_status" id="data_set_status" required>
                            <option value="">-- Select Status --</option>
                            <option value="1">In Process</option>
                            <option value="2">Completed</option>
                        </select>
                    </div>
                    <input type="hidden" name="bpo_id" id="bpo_id" value="" />
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" id="btnsubmit" class="btn btn-primary">Update</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
    </form>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
<!--<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">-->  
<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="assets/libs/jquery/dist/jquery.min.js"></script>
<script src="js/jquery.steps.min.js"></script>
<script src="js/sweetalert.min.js"></script>
<script src="assets/libs/jquery-validation/dist/jquery.validate.min.js"></script>
<script type="text/javascript">
   
$(document).ready(function () {
    $('select').select2();
    $(".status_detail").on("click",function(){
//        alert();
        var trid = $(this).closest('tr').attr('id');
        $("#bpo_id").val(trid);
    })
    
    $("#btnsubmit").on("click",function(){
        $.ajax({
            type: "POST",
            url: 'data_set_list',
            async: false,
            cache: false,
            data: $("#userForm").serialize(),
            success: function(data){
                $("#modal-default").modal('hide');
//                location.reload();
            }
        });
    })
    
    $(".start_status").on("click",function(){
                swal({
                    title: "Please Conform",
                    text: "You want to update status ?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#e74c3c",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: true,
                    closeOnCancel: false,
                }, function(isConfirm){
                    if (isConfirm) {
                        $("#modal-default").modal('show');
                    }
                    else {
//                        $("#Modal2").modal({backdrop: 'static', keyboard: false});
                        swal("Cancelled", "", "error");
                    }
                });
            })
});
</script>
@endsection
