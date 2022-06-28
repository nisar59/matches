@php
$pref=Request()->route()->getPrefix();
$type=Request()->type;
@endphp

      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="{{url('/')}}"> <img alt="image" src="{{url('public/img/settings/'.Settings()->portal_logo)}}" class="header-logo" /> <span
                class="logo-name">{{Settings()->portal_name}}</span>
            </a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="dropdown @if($pref=='') active @endif">
              <a href="{{url('/')}}" class="nav-link"><i class="fas fa-desktop"></i><span>Dashboard</span></a>
            </li>
            @can('users.view')
            <li class="dropdown @if($pref=='/users') active @endif">
              <a href="{{url('users')}}" class="nav-link"><i class="fas fa-user-friends"></i><span>Users</span></a>
            </li>
            @endcan
            @can('permissions.view')
            <li class="dropdown @if($pref=='/roles') active @endif"><a class="nav-link" href="{{url('roles')}}"><i class="fas fa-hands-helping"></i><span>Roles & Permissions</span></a></li>
            @endcan
            @can('contacts.view')
            <li class="dropdown @if($pref=='/contacts') active @endif">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  class="fas fa-address-book"></i><span>Contacts</span></a>
              <ul class="dropdown-menu">
                <li class="@if($type=='vendor') active @endif"><a class="nav-link" href="{{url('contacts?type=vendor')}}">Vendors</a></li>
                <li class="@if($type=='customer') active @endif"><a class="nav-link" href="{{url('contacts?type=customer')}}">Customers</a></li>
              </ul>
            </li>
            @endcan
            @can('category.view')
            <li class="dropdown @if($pref=='/category') active @endif">
              <a href="{{url('category')}}" class="nav-link"><i class="fas fa-boxes"></i><span>Category</span></a>
            </li>
            @endcan
            @can('units.view')
            <li class="dropdown @if($pref=='/units') active @endif">
              <a href="{{url('units')}}" class="nav-link"><i class="fas fa-coins"></i><span>Units</span></a>
            </li>
            @endcan
            @can('warehousesandshops.view')
            <li class="dropdown @if($pref=='/warehousesandshops') active @endif">
              <a href="{{url('warehousesandshops')}}" class="nav-link"><i class="fas fa-store-alt"></i><span>Warehouses & Shops</span></a>
            </li>
            @endcan

            @can('products.view')
            <li class="menu-header">Products</li>
            <li class="dropdown @if($pref=='/products') active @endif">
              <a href="{{url('products')}}" class="nav-link"><i class="fas fa-cubes"></i><span>Products</span></a>
            </li>
            @endcan

            @can('purchases.view')
            <li class="menu-header">Purchases</li>
            <li class="dropdown @if($pref=='/purchases') active @endif">
              <a href="{{url('purchases')}}" class="nav-link"><i class="fas fa-dolly-flatbed"></i><span>Purchases</span></a>
            </li>
            @endcan
            @can('stocktransfer.view')
            <li class="menu-header">Stock Transfer</li>
            <li class="dropdown @if($pref=='/stocktransfer') active @endif">
              <a href="{{url('stocktransfer')}}" class="nav-link"><i class="fas fa-dolly-flatbed"></i><span>Stock Transfer</span></a>
            </li>
            @endcan
            @can('expense.view')
            <li class="menu-header">Stock Transfer</li>
            <li class="dropdown @if($pref=='/expense') active @endif">
              <a href="{{url('expense')}}" class="nav-link"><i class="fas fa-clipboard-list"></i><span>Expenses</span></a>
            </li>
            @endcan
            @can('reports.view')
            <li class="menu-header">Reports</li>
            <li class="dropdown @if($pref=='/reports') active @endif">
              <a href="{{url('reports')}}" class="nav-link"><i class="fas fa-file-alt"></i><span>Purchase Reports</span></a>
            </li>
            <li class="dropdown @if($pref=='/reports') active @endif">
              <a href="{{url('reports')}}" class="nav-link"><i class="fas fa-file-alt"></i><span>Sale Reports</span></a>
            </li>
            <li class="dropdown @if($pref=='/reports') active @endif">
              <a href="{{url('reports')}}" class="nav-link"><i class="fas fa-file-alt"></i><span>Stock Reports</span></a>
            </li>
            <li class="dropdown @if($pref=='/reports') active @endif">
              <a href="{{url('reports')}}" class="nav-link"><i class="fas fa-file-alt"></i><span>Expense Reports</span></a>
            </li>
            @endcan

            @can('settings.view')
            <li class="menu-header">Panel Settings</li>
            <li class="dropdown @if($pref=='/settings') active @endif">
              <a href="{{url('settings')}}" class="nav-link"><i class="fas fa-cogs"></i><span>Panel Settings</span></a>
            </li>
            @endcan
          </ul>
        </aside>
      </div>