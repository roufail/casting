 <!-- Left side column. contains the logo and sidebar -->
 <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset('admin-files/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ auth()->user()->name}}</p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- search form (Optional) -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
          </span>
        </div>
      </form>
      <!-- /.search form -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
        <li class="header">HEADER</li>
        <!-- Optionally, you can add icons to the links -->


        <li class="{{ Route::is('admin.users.index') ? 'active' : '' }}">
          <a href="{{ route('admin.users.index') }}">
            <i class="fa fa-users"></i> 
            <span>البائعين</span>
          </a>
        </li>



        <li class="{{ Route::is('admin.categories.index') ? 'active' : '' }}">
          <a href="{{ route('admin.categories.index') }}">
            <i class="fa fa-list-alt" aria-hidden="true"></i>
            <span>التصنيفات</span>
          </a>
        </li>



        <li class="{{ Route::is('admin.services.index') ? 'active' : '' }}">
          <a href="{{ route('admin.services.index') }}">
            <i class="fa fa-taxi"></i> 
            <span>الخدمات</span>
          </a>
        </li>

        <li class="{{ Route::is('admin.clients.index') ? 'active' : '' }}">
          <a href="{{ route('admin.clients.index') }}">
            <i class="fa fa-users"></i> 
            <span>العملاء</span>
          </a>
        </li>


        <li class="{{ Route::is('admin.orders.index') ? 'active' : '' }}">
          <a href="{{ route('admin.orders.index') }}">
            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
            <span>الطلبات</span>
          </a>
        </li>

        <li class="{{ Route::is('admin.incomings.index') ? 'active' : '' }}">
          <a href="{{ route('admin.incomings.index') }}">
            <i class="fa fa-money" aria-hidden="true"></i>
            <span>الواردات</span>
          </a>
        </li>

        <li class="{{ Route::is('admin.outgoings.index') ? 'active' : '' }}">
          <a href="{{ route('admin.outgoings.index') }}">
            <i class="fa fa-money" aria-hidden="true"></i>
            <span>الصادرات</span>
          </a>
        </li>

        {{-- <li><a href="#"><i class="fa fa-link"></i> <span>Another Link</span></a></li>
        <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>Multilevel</span> <i class="fa fa-angle-left pull-right"></i></a>
          <ul class="treeview-menu">
            <li><a href="#">Link in level 2</a></li>
            <li><a href="#">Link in level 2</a></li>
          </ul>
        </li> --}}


      </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>