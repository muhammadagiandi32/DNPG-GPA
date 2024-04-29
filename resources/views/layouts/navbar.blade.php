<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="../../index3.html" class="brand-link">
        <img src="{{ asset('assets/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: 0.8" />
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                    alt="User Image" />
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div>
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search" />
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>
        @php
            // dd(Auth::user()->role->permissions);
        @endphp
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item {{ request()->is('dnpg*') ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('dnpg') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Module <i class="right fas fa-angle-left"></i></p>
                    </a>
                    @php
                        $userPermissions = Auth::user()->role->permissions->pluck('name')->toArray();
                        $routePermissions = Auth::user()->role->permissions->pluck('route')->toArray();
                        // dd($route);
                    @endphp

                    <ul class="nav nav-treeview">
                        @if (in_array('DNPG Create', $userPermissions))
                            <li class="nav-item">
                                <a href="{{ in_array('dnpg.index', $routePermissions) ? route('dnpg.index') : '#' }}"
                                    class="nav-link {{ request()->is('dnpg') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>DNPG</p>
                                </a>
                            </li>
                        @endif
                        @if (in_array('DNPG Create', $userPermissions))
                            <li class="nav-item">
                                <a href="{{ in_array('dnpg.index', $routePermissions) ? route('dnpg.create') : '#' }}"
                                    class="nav-link {{ request()->is('dnpg') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Create DNPG</p>
                                </a>
                            </li>
                        @endif
                        @if (Auth::check())
                            <li class="nav-item">
                                <a href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Logout</p>
                                </a>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        @endif
                    </ul>
                </li>

                {{-- <li class="nav-item">
                    <a href="#" class="nav-link {{ request()->is('users') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Create <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @foreach (Auth::user()->role->permissions as $permission)
                            @php
                                // Menggunakan substr untuk mengambil bagian belakang string route
                                $routeStart = Str::before($permission->route, '.');

                            @endphp
                            @if ($routeStart === 'users')
                                <li class="nav-item">
                                    <a href="{{ route($permission->route) }}"
                                        class="nav-link {{ request()->is($permission->route) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ $permission->name }}</p>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li> --}}
            </ul>


        </nav>
    </div>
</aside>
