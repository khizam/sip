<header class="main-header">
      <!-- Logo -->
      <a href="index2.html" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">JGR</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">{{ config ('app.name') }}</span>
      </a>
      <!-- Header Navbar: style can be found in header.less -->

    <nav class="navbar navbar-static-top">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>

          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav"> <!-- Notifications: style can be found in dropdown.less -->
                <li class="dropdown notifications-menu">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bell-o"id="notification_user"></i>
                  </a>
                  <ul class="dropdown-menu">
                    <li class="header header_notification">You have 0 notifications</li>
                    <li style="background: rgba(0,166,90,0.2)">
                      <!-- inner menu: contains the actual data -->
                      <ul class="menu menu_notification">
                          {{-- // Menu Notification --}}
                      </ul>
                    </li>
                    <li class="footer"><a href="{{ route('notifications.show',['read_at'=>'unread']) }}">View all</a></li>
                  </ul>
                </li>

              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="{{asset('template/dist/img/user2-160x160.jpg')}}" class="user-image" alt="User Image">
                  <span class="hidden-xs">{{ auth()->user()->name }}</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="{{asset('template/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">

                    <p>
                      {{ auth()->user()->name }} - {{ auth()->user()->email }}
                    </p>
                  </li>
                  <!-- Menu Body -->

                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="#" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="#" class="btn btn-default btn-flat"
                      onclick="document.getElementById('logout-form').submit()">Keluar</a>
                    </div>
                  </li>
                </ul>
              </li>
              <li>
              </li>
            </ul>
          </div>
        </nav>
    </header>

<form action="{{ route('logout') }}" method="post" id="logout-form" style="display: none;">
    @csrf
</form>
