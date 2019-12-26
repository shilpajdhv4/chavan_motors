
  <aside class="main-sidebar">
    <section class="sidebar">
      <div class="user-panel">
        <div class="image" style="text-align: center;">
          <img src="{{ asset ('dist/img/logo.png') }}" class="" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>iPing Data Labs</p>
        </div>
      </div>
      <ul class="sidebar-menu" data-widget="tree">
        <li class="active">
            <a href="{{url('home')}}">
            <i class="fa fa-dashboard"></i> <span>Home
          </a>
        </li>
       <li class="treeview <?php if(Request::is('users.index') || Request::is('oles.index')){ ?> menu-open <?php } ?>">
          <a href="#">
            <i class="fa fa-list"></i> <span>MasterData</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" <?php if(Request::is('users') || Request::is('users/create') || Request::is('users/{id}/edit') || Request::is('roles') ||  Request::is('roles/create') || Request::is('roles/{id}/edit') ||
                  Request::is('enq_location_list') || Request::is('enq_location_add') || Request::is('enq-location-edit') || Request::is('branch_list') || Request::is('branch_add') || Request::is('branch_edit')){ ?> style="display:block" <?php } ?>>
           
            @can('role-list')
            <!--<li <?php // if(Request::is('roles') ||  Request::is('roles/create') || Request::is('roles/{id}/edit')) { ?>class="active" <?php // } ?>><a href="{{route('roles.index')}}"><i class="fa fa-circle-o"></i>Manage Role</a></li>-->
            @endcan
            @can('enq_location_list')
            <li <?php if(Request::is('enq_location_list') || Request::is('enq_location_add') || Request::is('enq-location-edit')) { ?>class="active" <?php } ?>><a href="{{url('enq_location_list')}}"><i class="fa fa-circle-o"></i> <span>Location</span></a></li>
            @endcan
            @can('branch_list')
            <li <?php if(Request::is('branch_list') || Request::is('branch_add') || Request::is('branch_edit')) { ?>class="active" <?php } ?>><a href="{{url('branch_list')}}"><i class="fa fa-circle-o"></i><span>Branch</span></a></li>
            @endcan
             @can('users-index')
            <li <?php if(Request::is('users') || Request::is('users/create') || Request::is('users/{id}/edit')) { ?>class="active" <?php } ?>><a href="{{route('users.index')}}"><i class="fa fa-circle-o"></i>Manage Users</a></li>
            @endcan
            <!--<li <?php // if(Request::is('products.index')) { ?>class="active" <?php // } ?>><a href="{{route('products.index')}}"><i class="fa fa-circle-o"></i>Manage Product</a></li>-->
          </ul>
        </li>
        @can('upload_csv')
        <li>
            <a href="{{url('upload_csv')}}">
                <i class="fa fa-circle-o"></i> <span>Upload CSV</span>
          </a>
        </li>
        @endcan
        <li>
            <a href="{{url('download_uploaded_csv')}}">
                <i class="fa fa-circle-o"></i> <span>Download Uploaded CSV</span>
          </a>
        </li>
        @can('data_set_list')
        <li>
            <a href="{{url('data_set_list')}}">
                <i class="fa fa-circle-o"></i><span>Data Set Lists</span>
            </a>
        </li>
        @endcan
         @can('customer_detail')
        <li>
            <a href="{{url('customer_detail')}}">
                <i class="fa fa-circle-o"></i><span>Customer Detail</span>
            </a>
        </li>
        @endcan
        @can('call_detail_updated_status')
        <li>
            <a href="{{url('call_detail_updated_status')}}">
                <i class="fa fa-circle-o"></i><span>Call Details Updated Status</span>
            </a>
        </li>
         @endcan
        @can('assign_data_sales_executive')
        <li>
            <a href="{{url('assign_data_sales_executive')}}">
                <i class="fa fa-circle-o"></i><span>Assign Data To TL</span>
            </a>
        </li>
         @endcan
        @can('get_tl_data')
         <li>
            <a href="{{url('get_tl_data')}}">
                <i class="fa fa-circle-o"></i><span>Team Leader Assigned Data</span>
            </a>
        </li>
        @endcan
        @can('get_dse_data')
         <li>
            <a href="{{url('get_dse_data')}}">
                <i class="fa fa-circle-o"></i><span>DSE Assigned Customer Data</span>
            </a>
        </li>
        @endcan
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>