<!-- Brand Logo -->
<a href="index3.html" class="brand-link">
  <img src="{{ asset('assets/images/logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
  <span class="brand-text font-weight-light">NR-dev</span>
</a>

<div class="sidebar">
  <!-- Sidebar user panel (optional) -->
  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
      <img src="{{ asset('assets/images/user.jpg') }}" class="img-circle elevation-2" alt="User Image">
    </div>
    <div class="info">
      <a href="#" class="d-block">{{ session()->get('user')['username'] }}</a>
    </div>
  </div>

  <!-- SidebarSearch Form -->
  <div class="form-inline">
    <div class="input-group" data-widget="sidebar-search">
      <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
      <div class="input-group-append">
        <button class="btn btn-sidebar">
          <i class="fas fa-search fa-fw"></i>
        </button>
      </div>
    </div>
  </div>

  <!-- Sidebar Menu -->
  @php
    function isParentActive(array $routes) {
      foreach ($routes as $route) {
        if (request()->routeIs($route)) return true;
      }
      return false;
    }
  @endphp
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item {{ isParentActive(['category.*', 'account-group.*', 'account.*', 'user.*']) ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ isParentActive(['category.*', 'account-group.*', 'account.*', 'user.*']) ? 'active' : '' }}">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>
            Master
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('category.index') }}" class="nav-link {{ Request::routeIs('category.*') ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Category</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('account-group.index') }}" class="nav-link {{ Request::routeIs('account-group.*') ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Account Group</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('account.index') }}" class="nav-link {{ Request::routeIs('account.*') ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Account</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('account.index') }}" class="nav-link {{ Request::routeIs('user.*') ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>User</p>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <a href="{{ route('transaction.index') }}" class="nav-link {{ Request::routeIs('transaction.*') ? 'active' : '' }}">
          <i class="fas fa-money-check-alt"></i>
          <p>
            Transaction
          </p>
        </a>
      </li>
    </ul>
  </nav>
</div>