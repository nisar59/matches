@php
$pref=Request()->route()->getPrefix();
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
              <a href="{{url('/')}}" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
            </li>
            @can('users.view')
            <li class="dropdown @if($pref=='/users') active @endif">
              <a href="{{url('users')}}" class="nav-link"><i class="fas fa-user-friends"></i><span>Users</span></a>
            </li>
            @endcan
            @can('permissions.view')
            <li class="dropdown @if($pref=='/roles') active @endif"><a class="nav-link" href="{{url('roles')}}"><i class="fas fa-hands-helping"></i><span>Roles & Permissions</span></a></li>
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