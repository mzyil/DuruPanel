@if (Auth::check())
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="https://placehold.it/160x160/00a65a/ffffff/&text={{ mb_substr(Auth::user()->name, 0, 1) }}"
                         class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="header">İşlemler</li>

                @can('customerResource')
                    <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/customer') }}"><i
                                    class="fa fa-user"></i> <span>Müşteriler</span></a></li>
                @endcan
                @can('interviewResource')
                    <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/interview') }}"><i
                                    class="fa fa-pencil"></i> <span>Görüşmeler</span></a></li>
                @endcan
                @can('addressResource')
                    <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/address') }}"><i
                                    class="fa fa-pencil"></i> <span>Adresler</span></a></li>
                @endcan

                <li class="header">{{ trans('backpack::base.administration') }}</li>
                <!-- ================================================ -->
                <!-- ==== Recommended place for admin menu items ==== -->
                <!-- ================================================ -->
                <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/dashboard') }}"><i
                                class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a>
                </li>
                @role('admin')
                <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/elfinder') }}"><i
                                class="fa fa-files-o"></i> <span>File manager</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/setting') }}"><i
                                class="fa fa-cog"></i> <span>Settings</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/page') }}"><i
                                class="fa fa-file-o"></i> <span>Pages</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/language') }}"><i
                                class="fa fa-flag-o"></i> <span>Languages</span></a></li>
                <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/language/texts') }}"><i
                                class="fa fa-language"></i> <span>Language Files</span></a></li>
                <li class="treeview">
                    <a href="#"><i class="fa fa-group"></i> <span>Users, Roles, Permissions</span> <i
                                class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/user') }}"><i
                                        class="fa fa-user"></i> <span>Users</span></a></li>
                        <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/role') }}"><i
                                        class="fa fa-group"></i> <span>Roles</span></a></li>
                        <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/permission') }}"><i
                                        class="fa fa-key"></i> <span>Permissions</span></a></li>
                    </ul>
                </li>
            @endrole

            <!-- ======================================= -->
                <li class="header">{{ trans('backpack::base.user') }}</li>
                <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/logout') }}"><i
                                class="fa fa-sign-out"></i> <span>{{ trans('backpack::base.logout') }}</span></a></li>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>
@endif
