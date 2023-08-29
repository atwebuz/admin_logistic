{{--Left sidebar--}}
<nav class="mt-2">

    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
        @canany([
            'permission.show',
            'roles.show',
            'user.show'
        ])
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link {{ (Request::is('permission*') || Request::is('role*') || Request::is('user*')) ? 'active':''}}">
                    <i class="fas fa-users-cog"></i>
                    <p>
                        @lang('cruds.userManagement.title')
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" style="display: {{ (Request::is('permission*') || Request::is('role*') || Request::is('user*')) ? 'block':'none'}};">
                    @can('permission.show')
                        <li class="nav-item">
                            <a href="{{ route('permissionIndex') }}" class="nav-link {{ Request::is('permission*') ? "active":'' }}">
                                <i class="fas fa-key"></i>
                                <p> @lang('cruds.permission.title_singular')</p>
                            </a>
                        </li>
                    @endcan

                    @can('roles.show')
                        <li class="nav-item">
                            <a href="{{ route('roleIndex') }}" class="nav-link {{ Request::is('role*') ? "active":'' }}">
                                <i class="fas fa-user-lock"></i>
                                <p> @lang('cruds.role.fields.roles')</p>
                            </a>
                        </li>
                    @endcan

                    @can('user.show')
                        <li class="nav-item">
                            <a href="{{ route('userIndex') }}" class="nav-link {{ Request::is('user*') ? "active":'' }}">
                                <i class="fas fa-user-friends"></i>
                                <p> @lang('cruds.user.title')</p>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcanany
        
        {{-- next --}}

        @canany([
            'category.view',
            'company.view',
            'driver.view'
        ])
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link {{ (Request::is('category*') || Request::is('company*') || Request::is('driver*')) ? 'active':''}}">
                    <i class="fas fa-magic"></i>
                    <p>
                        @lang('Manage')
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" style="display: {{ (Request::is('category*') || Request::is('company*') || Request::is('driver*')) ? 'block':'none'}};">
                    @can('category.view')
                    <li class="nav-item">
                        <a href="{{ route('categoryIndex') }}" class="nav-link {{ Request::is('category*') ? "active":'' }}">
                        <i class="fas fa-border-all"></i>
                            <p>Category</p>
                        </a>
                    </li>
                    @endcan
            
                    @can('company.view')
                    <li class="nav-item">
                        <a href="{{ route('companyIndex') }}" class="nav-link {{ Request::is('company*') ? "active":'' }}">
                        <i class="fas fa-building"></i>
                            <p>Company</p>
                        </a>
                    </li>
                    @endcan
            
            
                    @can('driver.view')
                    <li class="nav-item">
                        <a href="{{ route('driverIndex') }}" class="nav-link {{ Request::is('driver*') ? "active":'' }}">
                        <i class="fas fa-id-card"></i>
                            <p>Driver</p>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
        @endcanany

        
        @canany([
            'task.view',
         
        ])
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link {{ (Request::is('task*') || Request::is('extra*')) ? 'active':''}}">
                    <i class="fas fa-tasks"></i>
                    <p>
                        @lang('Tasks')
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" style="display: {{ (Request::is('task') || Request::is('tasks/extra')) ? 'block':'none'}};">
                   
                    @can('task.view')
                    <li class="nav-item">
                        <a href="{{ route('taskIndex') }}" class="nav-link {{ Request::is('task') ? "active":'' }}">
                            <i class="fas fa-tasks"></i>
                            <p>Left Request</p>
                        </a>
                    </li>
                    @endcan
            
                    @can('task.view')
                    <li class="nav-item">
                        <a href="{{ route('extraTaskView') }}" class="nav-link {{ Request::is('tasks/extra') ? "active":'' }}">
                            <i class="fas fa-tasks"></i>
                            <p>Current Request </p>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
        @endcanany

        @can('task.view')
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ Request::is('dashboard') ? "active":'' }}">
                <i class="fas fa-pen"></i>
                <p>Dashboard</p>
            </a>
        </li>
        @endcan

        @can('rating.view')
        <li class="nav-item">
            <a href="{{ route('ratings.index') }}" class="nav-link {{ Request::is('ratings*') ? "active":'' }}">
                <i class="fas fa-star"></i>
                <p>Ratings</p>
            </a>
        </li>
        @endcan

        @can('monitoring.view')
        <li class="nav-item">
            <a href="{{ route('monitoringIndex') }}" class="nav-link {{ Request::is('monitoring*') ? "active":'' }}">
                <i class="fas fa-home"></i>
                <p>Monitoring</p>
            </a>
        </li>
        @endcan

        @can('monitoring.view')
        <li class="nav-item">
            <a href="{{ route('reportIndex') }}" class="nav-link {{ Request::is('report*') ? "active":'' }}">
                <i class="fas fa-file"></i>
                <p>Reports</p>
            </a>
        </li>
        @endcan


        @if(auth()->user()->roles[0]->name == 'Employee')

        @can('order.view')
        <li class="nav-item">
            <a href="{{ route('orderIndex') }}" class="nav-link {{ Request::is('order*') ? "active":'' }}">
                <i class="fas fa-chart-line"></i>
                <p>Order</p>
            </a>
        </li>
        @endcan
        
        @can('daily.view')
        <li class="nav-item">
            <a href="{{ route('ratings.daily') }}" class="nav-link {{ Request::is('rating/daily*') ? "active":'' }}">
                <i class="fas fa-calendar-day"></i>
                <p>Daily</p>
            </a>
        </li>
        @endcan

        @endif

        @can('stuff.view')
        <li class="nav-item">
            <a href="{{ route('stuffIndex') }}" class="nav-link {{ Request::is('stuffs*') ? "active":'' }}">
                <i class="fas fa-user-friends"></i>
                <p>Employees</p>
            </a>
        </li>
        @endcan 


     

    <li class="nav-item">
        <a href="{{ route('folderIndex') }}" class="nav-link {{ Request::is('folders*') ? "active":'' }}">
            <i class="fas fa-folder-open"></i>
            <p>Документы</p>
        </a>
    </li> 

    </ul>

    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item has-treeview">
            <a href="" class="nav-link">
            <i class="fas fa-palette"></i>
            <p>
                @lang('global.theme')
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
            <ul class="nav nav-treeview" style="display: none">
                <li class="nav-item">
                    <a href="{{ route('userSetTheme',[auth()->id(),'theme' => 'default']) }}" class="nav-link">
                        <i class="nav-icon fas fa-circle text-info"></i>
                        <p class="text">Default {{ auth()->user()->theme == 'default' ? '✅':'' }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('userSetTheme',[auth()->id(),'theme' => 'light']) }}" class="nav-link">
                        <i class="nav-icon fas fa-circle text-white"></i>
                        <p>Light {{ auth()->user()->theme == 'light' ? '✅':'' }}</p>
                    </a>
                </li>
                <li class="nav-item">
                <a href="{{ route('userSetTheme',[auth()->id(),'theme' => 'dark']) }}" class="nav-link">
                        <i class="nav-icon fas fa-circle text-gray"></i>
                        <p>Dark {{ auth()->user()->theme == 'dark' ? '✅':'' }}</p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
{{--    @can('card.main')--}}

{{--    @endcan--}}
</nav>
