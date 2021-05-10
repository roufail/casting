  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('imgs/no-user.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light"></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <div>
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="{{ asset('imgs/no-user.png') }}" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block"> {{ auth()->user()->name }}</a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            



            <li class="nav-item {{ Route::is('admin.users.index') ? 'active' : '' }}">
              <a class="nav-link {{ Route::is('admin.users.index') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                <i class="nav-icon fa fa-users"></i> 
                <span>@lang("admin/sidebar.menu.payers")</span>
              </a>
            </li>
    
    
    
            <li class="nav-item {{ Route::is('admin.categories.index') ? 'active' : '' }}">
              <a class="nav-link {{ Route::is('admin.categories.index') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                <i class="nav-icon fa fa-list-alt" aria-hidden="true"></i>
                <span>@lang("admin/sidebar.menu.categories")</span>
              </a>
            </li>
    
    
    
            <li class="nav-item {{ Route::is('admin.services.index') ? 'active' : '' }}">
              <a class="nav-link {{ Route::is('admin.services.index') ? 'active' : '' }}" href="{{ route('admin.services.index') }}">
                <i class="nav-icon fa fa-taxi"></i> 
                <span>@lang("admin/sidebar.menu.services")</span>
              </a>
            </li>
    
            <li class="nav-item {{ Route::is('admin.userservices.index') ? 'active' : '' }}">
              <a class="nav-link {{ Route::is('admin.userservices.index') ? 'active' : '' }}" href="{{ route('admin.userservices.index') }}">
                <i class="nav-icon fa fa-taxi"></i> 
                <span>@lang("admin/sidebar.menu.user_services")</span>
              </a>
            </li>
    
    
    
            <li class="nav-item {{ Route::is('admin.clients.index') ? 'active' : '' }}">
              <a class="nav-link {{ Route::is('admin.clients.index') ? 'active' : '' }}" href="{{ route('admin.clients.index') }}">
                <i class="nav-icon fa fa-users"></i> 
                <span>@lang("admin/sidebar.menu.clients")</span>
              </a>
            </li>
    
    
            <li class="nav-item {{ Route::is('admin.orders.index') ? 'active' : '' }}">
              <a class="nav-link {{ Route::is('admin.orders.index') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                <i class="nav-icon fa fa-shopping-cart" aria-hidden="true"></i>
                <span>@lang("admin/sidebar.menu.orders")</span>
              </a>
            </li>
    
            <li class="nav-item {{ Route::is('admin.incomings.index') ? 'active' : '' }}">
              <a class="nav-link {{ Route::is('admin.incomings.index') ? 'active' : '' }}" href="{{ route('admin.incomings.index') }}">
                <i class="nav-icon fa fa-money" aria-hidden="true"></i>
                <span>@lang("admin/sidebar.menu.incomings")</span>
              </a>
            </li>
    
            <li class="nav-item {{ Route::is('admin.outgoings.index') ? 'active' : '' }}">
              <a class="nav-link {{ Route::is('admin.outgoings.index') ? 'active' : '' }}" href="{{ route('admin.outgoings.index') }}">
                <i class="nav-icon fa fa-money" aria-hidden="true"></i>
                <span>@lang("admin/sidebar.menu.outgoings")</span>
              </a>
            </li>
    

            <li class="nav-item {{ Route::is('admin.wallets.index') ? 'active' : '' }}">
              <a class="nav-link {{ Route::is('admin.wallets.index') ? 'active' : '' }}" href="{{ route('admin.wallets.index') }}">
                <i class="nav-icon fa fa-wallet"></i>
                <span>@lang("admin/sidebar.menu.wallets")</span>
              </a>
            </li>


            <li class="nav-item {{ Route::is('admin.wallets.payment_requests') ? 'active' : '' }}">
              <a class="nav-link {{ Route::is('admin.wallets.payment_requests') ? 'active' : '' }}" href="{{ route('admin.wallets.payment_requests') }}">
                <i class="nav-icon fa fa-wallet"></i>
                <span>@lang("admin/sidebar.menu.payment_requests")</span>
              </a>
            </li>

            <li class="nav-item {{ Route::is('admin.wallets.pending_payment_requests') ? 'active' : '' }}">
              <a class="nav-link {{ Route::is('admin.wallets.pending_payment_requests') ? 'active' : '' }}" href="{{ route('admin.wallets.pending_payment_requests') }}">
                <i class="nav-icon fa fa-wallet"></i>
                <span>@lang("admin/sidebar.menu.pending_payment_requests")</span>
              </a>
            </li>



            <li class="nav-item {{ Route::is('admin.wallets.paid_payment_requests') ? 'active' : '' }}">
              <a class="nav-link {{ Route::is('admin.wallets.paid_payment_requests') ? 'active' : '' }}" href="{{ route('admin.wallets.paid_payment_requests') }}">
                <i class="nav-icon fa fa-wallet"></i>
                <span>@lang("admin/sidebar.menu.paid_payment_requests")</span>
              </a>
            </li>

            
            <li class="nav-item {{ Route::is('admin.ratings.index') ? 'active' : '' }}">
              <a class="nav-link {{ Route::is('admin.ratings.index') ? 'active' : '' }}" href="{{ route('admin.ratings.index') }}">
                <i class="nav-icon fa fa-star" aria-hidden="true"></i>
                <span>@lang("admin/sidebar.menu.ratings")</span>
              </a>
            </li>
    
    
            <li class="nav-item {{ Route::is('admin.settings.index') ? 'active' : '' }}">
              <a class="nav-link {{ Route::is('admin.settings.index') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
                <i class="nav-icon fa fa-cogs" aria-hidden="true"></i>
                <span>@lang("admin/sidebar.menu.settings")</span>
              </a>
            </li>
    
            <li class="nav-item {{ Route::is('admin.admins.index') ? 'active' : '' }}">
              <a class="nav-link {{ Route::is('admin.admins.index') ? 'active' : '' }}" href="{{ route('admin.admins.index') }}">
                <i class="nav-icon fas users-cog" aria-hidden="true"></i>
                <span>@lang("admin/sidebar.menu.admins")</span>
              </a>
            </li>



    

    
            <li>
              <a class="nav-link" href="nav-item {{ route('admin.logout') }}">
                <i class="nav-icon fa fa-sign-out" aria-hidden="true"></i>
                <span>@lang("admin/sidebar.menu.logout")</span>
              </a>
            </li>



          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
    </div>
    <!-- /.sidebar -->
  </aside>