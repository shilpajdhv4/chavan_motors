@extends('layouts.app')
@section('title', 'Create New User')
@section('content')
<style>
@media only screen and (max-width: 600px) {
    .mobile_date {
        width: 160px;
    }
}
</style>

<section class="content-header">
    <h1>Create New User
    <div class="pull-right">
        <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
    </div></h1>
</section>
@if (Session::has('alert-success'))
<div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
    <h4 class="alert-heading">Success!</h4>
    {{ Session::get('alert-success') }}
</div>
@endif


@if (count($errors) > 0)
  <div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
       @foreach ($errors->all() as $error)
         <li>{{ $error }}</li>
       @endforeach
    </ul>
  </div>
@endif

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box" style="border-top: 3px solid #ffffff;">
                <div class="box-header">
                    <h3 class="box-title"></h3>
                </div>

{!! Form::open(array('route' => 'users.store','method'=>'POST','class'=>'form-horizontal')) !!}
<div class="box-body">
    <div class="form-group">
        <label for="userName" class="col-sm-2 control-label">Name<span style="color:red"> * </span></label>
        <div class="col-sm-4">
            <input type="text" class="form-control"  placeholder="Name" value="" id="name" name="name"  required >
        </div>
        <label for="userName" class="col-sm-2 control-label">Email<span style="color:red"> * </span></label>
        <div class="col-sm-4">
            <input type="email" class="form-control"  placeholder="Email" value="" id="email" name="email"  required >
        </div>
    </div>
    <div class="form-group">
        <label for="userName" class="col-sm-2 control-label">Password<span style="color:red"> * </span></label>
        <div class="col-sm-4">
            <input type="password" class="form-control"  placeholder="Password" value="" id="password" name="password"  required >
        </div>
        <label for="userName" class="col-sm-2 control-label">Confirm Password<span style="color:red"> * </span></label>
        <div class="col-sm-4">
            <input type="password" class="form-control"  placeholder="Confirm Password" value="" id="confirm-password" name="confirm-password"  required >
        </div>
    </div>
    <div class="form-group">
        <label for="userName" class="col-sm-2 control-label">Role<span style="color:red"> * </span></label>
        <div class="col-sm-4">
            {!! Form::select('roles[]', $roles,[], array('class' => 'form-control select2','multiple')) !!}
        </div>
        <label for="userName" class="col-sm-2 control-label">Mobile No.<span style="color:red"> * </span></label>
        <div class="col-sm-4">
            <input type="text" class="form-control"  placeholder="Mobile No" value="" id="mobile_no" name="mobile_no"  >
        </div>
    </div>
    <div class="form-group">
        <label for="userName" class="col-sm-2 control-label">Branch<span style="color:red"> * </span></label>
        <div class="col-sm-4">
            <select name="branch_id" id="branch_id" class="form-control select2" required >
                <option value="">-- Select Branch --</option>
                @foreach($branch as $b)
                <option value="{{$b->branch_id}}">{{$b->branch_name}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="box-footer">
    <button type="submit"  id="btnsubmit" class="btn btn-success">Submit</button>
    <a href="{{route('users.index')}}" class="btn btn-danger" >Cancel</a>
</div>
{!! Form::close() !!}
            </div>
        </div>
    </div>
</section>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>
$(document).ready(function () {
    $('.select2').select2();
    })
    </script>
@endsection