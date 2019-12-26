@extends('layouts.app')
@section('title', 'Branch-List')
@section('content')
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<section class="content-header">
    <h1>
        Download Uploaded CSV
    </h1>
    
</section>
@if (Session::has('alert-success'))
<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
    <h4 class="alert-heading">Success!</h4>
    {{ Session::get('alert-success') }}
</div>
@endif
<section class="content">
    <div class="box">
        
        <!-- /.box-header -->
        <?php $x = 1; ?>
        <div class="box-body" >
            <table id="example1" class="table table-bordered table-striped" border="1">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Calling Set Name</th>
                        <th>Uploaded Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($uploade_file as $row)
                   
                    <tr>
                        <td>{{$x++}}</td>
                        <td>{{$row->calling_set_name}}</td>
                        <td>{{$row->uploaded_date}}</td>
                        <td><a href="branch_upload_csv/{{$row->file_name}}" >Download</a></td>
                    </tr>
                    @endforeach


                </tbody>

            </table>
        </div>
        <!-- /.box-body -->
    </div>   
</section>

<!-- END PAGE CONTENT WRAPPER -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
$(document).ready(function () {
//    alert();
    $(".delete").on("click", function () {
        return confirm('Are you sure to delete user');
    });
});
$(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
        'paging': true,
        'lengthChange': false,
        'searching': false,
        'ordering': true,
        'info': true,
        'autoWidth': false
    })
})
</script>
@endsection
