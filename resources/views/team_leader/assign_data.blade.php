@extends('layouts.app')
@section('title', 'Branch-List')
@section('content')
@if (Session::has('alert-success'))
<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
    <h4 class="alert-heading">Success!</h4>
    {{ Session::get('alert-success') }}
</div>
@endif
<section class="content">
      <?php $x = 1; ?>
    <form class="form-horizontal" id="design-form" action="{{url('update_dse_data1')}}" method="post" >
        {{ csrf_field() }}
    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                    <label for="userName" class="col-sm-2 control-label">Select DSE </label>
                    <div class="col-sm-3">
                        <select id="assign_dse_id" name="assign_dse_id" class="form-control select2"  required>
                            <option value="">-- Select Status --</option>
                            @foreach($team_leader as $team)
                            <option value="{{$team->id}}">{{$team->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group-btn col-sm-1"> 
                        <button type="submit" class="btn btn-success " type="button">Assign</button>
                    </div>
            </div>
        </div>
    </div>
    <br/>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Assign Data to Sales Executive</h3>
              <input type="button" class="check" value="check all" />
              <div class="box-tools">
                <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                    
                    <!--Select Multiple-->
                  <!--<input type="text" name="table_search" class="form-control pull-right" placeholder="Search">-->
                    <input type="text" class="form-control" name="no_of_check" id="no_of_check" value="" />
                  
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                    <th>Sr.No</th>
                    <th>Calling Set</th>
                    <th>Customer Name</th>
                    <th>Mobile Number</th>
                    <th>Call Status</th>
                    <th>Call Note's</th>
                    <th>BPO Executive Name</th>
                    <th>Action</th>
                </tr>
                @foreach($call_detail_dept_wise as $row)
                    <tr>
                        <td>{{$x++}}</td>
                        <td>{{$row->calling_set_name}}</td>
                        <td>{{$row->prospect_name}}</td>
                        <td>{{$row->mobile_no}}</td>
                        <td><span class="label label-success">{{$row->bop_user_status}}</span></td>
                        <td>{{$row->bop_user_remark}}</td>
                        <td>{{$row->name}}</td>
                        <td>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                  <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="single-checkbox" name="assign_tl[]" id="assign" value="{{$row->id}}">
                                    </label>
                                  </div>
                                </div>
                              </div>
                        </td>
                    </tr>
                @endforeach
                
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
    </form>
    </section>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">  
<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="assets/libs/jquery/dist/jquery.min.js"></script>
<script src="js/jquery.steps.min.js"></script>
<script src="js/sweetalert.min.js"></script>
<script src="assets/libs/jquery-validation/dist/jquery.validate.min.js"></script>
<script type="text/javascript">
   
$(document).ready(function () {
//    $('.check:button').toggle(function(){
////        alert();
//        $('input:checkbox').attr('checked','checked');
//        $(this).val('uncheck all')
//    },function(){
//        $('input:checkbox').removeAttr('checked');
//        $(this).val('check all');        
//    })
    
     $('.check').click(function(){
//         alert();
        $('input:checkbox').attr('checked','checked');
//        $(this).val('uncheck all');
//        $(this).removeClass("check");
//        $(this).addClass('uncheck_all');
     });
     
//     $('.uncheck_all',function(){
//         alert("un");
//        $('input:checkbox').removeAttr('checked');
//        $(this).val('check all')
//        $(this).removeClass("uncheck_all");
//        $(this).addClass('.check')
//     });
    $("#no_of_check").on("focusout",function(){
        var limit = $(this).val();
        alert(limit);
        var check = $('input.single-checkbox').find('input[type=checkbox]:checked').length;
        alert(check);
        if(check >= limit) {
            $('input.single-checkbox').prop("checked",true);
            this.checked = false;
        }
    })
});
</script>
@endsection