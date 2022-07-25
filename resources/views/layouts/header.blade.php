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
                    <li>
                      <!-- inner menu: contains the actual data -->
                      <ul class="menu menu_notification">
                          {{-- // Menu Notification --}}
                      </ul>
                    </li>
                    <li class="footer"><a href="#">View all</a></li>
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
@push('scripts')
<script>
    let url_notification = "{{ route('notifications.index') }}";
    $(function () {
       $.get(url_notification)
        .done(function (data) {
            let element = `<span class="label label-warning" >${data.totalUnread}</span>`;
            let menu_element = ''
            data.unread.forEach(result => {
                let object_key = Object.keys(result.data.attributes)
                let object_val = Object.values(result.data.attributes)
                menu_element += `
                    <li>
                        <a href="${result.data.links}">
                            <i class="fa fa-warning text-yellow"></i>${object_key[0]} - ${object_val[0]},${object_key[1]} - ${object_val[1]},${object_key[2]} - ${object_val[2]}
                        </a>
                    </li>`
            });
            $('#notification_user').after(element);
            $('.header_notification').text(`Kamu punya ${data.totalUnread} notification`);
            $('.menu_notification').append(menu_element);
        });
    });
</script>
@endpush
