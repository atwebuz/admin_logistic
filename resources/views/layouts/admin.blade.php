<!DOCTYPE html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>@lang('panel.site_title')</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- DataTables -->
	<link rel="stylesheet" type="text/css" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
	<!-- Tempusdominus Bbootstrap 4 -->
	<link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
	<!-- Select2 -->
	<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
	<!-- iCheck -->
	<link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
	<!-- overlayScrollbars -->
	<link rel="stylesheet" href="{{asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
	<!-- My styles -->
	<link rel="stylesheet" href="{{asset('plugins/bootstrap_my/my_style.css')}}">
	<!-- Responsive data tables -->
	<link rel="stylesheet" href="{{ asset('plugins/Responsive-2.2.3/css/responsive.dataTables.min.css') }}">
	<!-- Bootstrap4 Duallistbox -->
	<link rel="stylesheet" href="{{ asset('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
	<!-- SweetAlert2 -->
	<link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
	<link rel="icon" href="/consImages/logoU.png ">
</head>

<body class="{{ auth()->user()->theme()['body'] ?? '' }} hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
	<div class="wrapper" style="display: block">
		<!-- Navbar-->
		<nav class="main-header navbar navbar-expand {{ auth()->user()->theme()['navbar'] ?? 'navbar-light' }}">

			<!-- Left navbar links -->
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
				</li>
			</ul>

			<!-- Right navbar links -->
			<div class="ml-auto d-flex align-items-center">
				@if(auth()->check() && auth()->user()->roles->contains('id', 3))
				{{-- <div class="switch-online-offline ">
					<input type="checkbox" id="status-switch" data-toggle="switch" data-on-color="success"
						data-off-color="default" data-on-text="ONLINE" data-off-text="OFFLINE"
						onchange="toggleStatus({{ auth()->user()->id }})">
				</div> --}}
				<form method="POST" action="{{ route('toggle.status') }}">
					@csrf
					@method('PUT') <!-- Add this line to simulate a PUT request -->
						@if (Auth::user()->status === 'offline')
						<button class="btn btn-success d-flex align-items-center">

							Set Online

							<i class="fas fa-check ml-2"></i>

						</button>
							
						@else
						<button class="btn btn-danger d-flex align-items-center">
							Set Offline

							<i class="fas fa-times ml-2"></i>
						</button>
						@endif
				
				</form>
				@endif
				<ul class="navbar-nav">
					<li class="nav-item dropdown">
						<a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
							aria-expanded="false" class="nav-link dropdown-toggle"><i class="fas fa-user"></i>
							@if(auth()->user())
							{{ auth()->user()->name }}
							@endif
						</a>

						<ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow"
							style="left: 0px; right: inherit;">
							<li>
								@if(auth()->user())
								<a href="{{ route('userEdit',auth()->user()->id) }}" class="dropdown-item">
									<i class="fas fa-cogs"></i> @lang('global.settings')
								</a>
								@endif
							</li>
							<li>
								<form id="logout-form" action="{{ route('logout') }}" method="POST"
									style="display: none;">
									@csrf
								</form>
								<a href="#" class="nav-link" role="button" onclick="
										event.preventDefault();
										document.getElementById('logout-form').submit();">
									<i class="fas fa-sign-out-alt"></i> @lang('global.logout')
								</a>
							</li>
						</ul>
					</li>

				</ul>
			</div>


			@php
			$defaultMessage = 'The admin is calling you';
			$showDefaultMessage = false;
			
			$userMessages = auth()->user()->messages ?? collect();
			
			if ($userMessages->count() > 0 && $userMessages->contains('user_id', auth()->user()->id)) {
				$showDefaultMessage = true;
			}
			@endphp
			
			@if(auth()->user()->roles[0]->name == 'Employee')
				<div class="sl-nav d-flex align-items-center">
					<ul class="navbar-nav ml-auto">
						<li class="nav-item dropdown d-flex p-0">
							<a class="nav-link m-0" data-toggle="dropdown" href="#" aria-expanded="false">
								<i class="far fa-comments p-0 m-0" style="color: black"></i>
								<span class="badge badge-danger navbar-badge">
									{{ count(auth()->user()->messages) }}
								</span>
							</a>
							
							<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
								@if ($showDefaultMessage)
								<div class="d-flex align-items-center">
									<div class="p-2">
										<p class="p-1">{{ $defaultMessage }}</p>
										<p class="text-sm text-muted">
											<i class="far fa-clock mr-1"></i>
											{{ now()->diffForHumans(auth()->user()->messages->last()->created_at) }}
										</p>
									</div>

									<form id="delete-messages-form" method="POST" action="{{ route('messages.deleteAll') }}">
										@csrf
										<button type="button" id="delete-messages-btn" class="btn btn-success"><i class="fas fa-check"></i></button>
									</form>


									<script>
										document.addEventListener("DOMContentLoaded", function() {
											const deleteButton = document.getElementById("delete-messages-btn");
											const deleteForm = document.getElementById("delete-messages-form");
										
											deleteButton.addEventListener("click", function() {
												const confirmDelete = confirm("Are you sure you want to delete all messages?");
												if (confirmDelete) {
													deleteForm.submit();
												}
											});
										});
										</script>
								</div>

								@endif
								
								<div class="dropdown-divider"></div>
								<a href="{{ route('dashboard') }}" class="dropdown-item dropdown-footer">{{ __('See All Messages') }}</a>
							</div>
						</li>
					</ul>
				</div>
			@endif
			
			
			
		</nav>
		<!-- /.navbar -->

		<!-- Main Sidebar Container -->
		<aside class="main-sidebar elevation-1 {{ auth()->user()->theme()['sidebar'] ?? 'sidebar-dark-primary' }}">
			<!-- Brand Logo -->
			<a href="/" class="brand-link">
				<img src="{{ asset('consImages/logoU.png') }}" alt="Unired Logo"
					class="brand-image img-circle elevation-3" style="opacity: .8">
				{{-- <img src="{{asset('consImages/logo.png')}}" alt="" style="height: 50px; width:150px"> --}}
				<span class="brand-text font-weight-light">@lang('panel.site_title')</span>
			</a>

			<!-- Sidebar -->
			<div class="sidebar">
				<!-- Sidebar Menu -->
				@include('layouts.sidebar')
				<!-- /.sidebar-menu -->
			</div>
			<!-- /.sidebar -->
		</aside>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Main content -->
			@yield('content')
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->
		<footer class="main-footer">
			<strong>Copyright &copy; {{ date('Y') }} <a href="https://teamdevs.uz">Teamdevs-Group </a>.</strong>
			All rights reserved.
			<div class="float-right d-none d-sm-inline-block">
				<b>Version</b> 1.0
			</div>
		</footer>
		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark">
			<!-- Control sidebar content goes here -->
		</aside>
		<!-- /.control-sidebar -->
	</div>
	<!-- ./wrapper -->
	<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
	<!-- jQuery UI 1.11.4 -->
	<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
	<!-- Bootstrap 4 -->
	<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
	<!-- Select2 -->
	<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
	<!-- Bootstrap4 Duallistbox -->
	<script src="{{ asset('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
	<!-- overlayScrollbars -->
	<script src="{{asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
	<!-- DataTables -->
	<script src="{{asset('plugins/datatables/jquery.dataTables.js')}}"></script>
	<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
	<script src="{{ asset('plugins/Responsive-2.2.3/js/dataTables.responsive.min.js') }}"></script>
	<!-- Bootstrap Switch -->
	<script src="{{ asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
	<!-- bs-custom-file-input -->
	<script src="{{asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
	<!-- AdminLTE App -->
	<script src="{{asset('dist/js/adminlte.js')}}"></script>
	<!-- SweetAlert2 -->
	<script src="{{asset('plugins/sweetalert2-theme-bootstrap-4/sweet-alerts.min.js') }}"></script>
	<!-- MyJs -->
	<script src="{{asset('plugins/bootstrap_my/myScripts.js')}}" type="text/javascript"></script>

	
	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script>
		$.widget.bridge('uibutton', $.ui.button)
	$( document ).ready(function() {
		//Clear form filters
		$("#reset_form").on('click',function () {
			$('form :input').val('');
			$("form :input[class*='like-operator']").val('like');
			$( "div[id*='_pair']" ).hide();
		});

		$('[data-toggle="switch"]').bootstrapSwitch('state');
	});
    
    function onSelectSetValue(input_name, input_val) {
        $("form :input[name="+input_name+"]").val(input_val);
    }

	function toggleStatus(user_id) {
		console.log("User Status:", {{ auth()->user()->status }});
		const userId = user_id; // Replace with the actual user ID or get it from your frontend state
		const statusSwitch = document.getElementById('status-switch');
		const status = statusSwitch.checked ? 'online' : 'offline';

		// Send AJAX request to update user status
		$.ajax({
			type: "POST",
			url: `/user/status/${status}`,
			data: {
				user_id: userId,
				_token: "{{ csrf_token() }}",
			},
			success: function (response) {
				console.log(`${status} mode: ${response.message}`);
				Swal.fire({
					toast: true,
					position: 'top',
					icon: "success",
					title: `${response.message}`,
					showConfirmButton: false,
					timer: 2000
				});
				// Update your frontend UI or perform any other actions based on the response
			},
			error: function (error) {
				console.error(error);
				// Handle errors if necessary
			},
		});
	}
	</script>
	@if(session('_message'))
	<script>
		Swal.fire({
            position: 'top-end',
            icon: "{{ session('_type') }}",
            title: "{{ session('_message') }}",
            showConfirmButton: false,
            timer: {{session('_timer') ?? 5000}}
        });
	</script>
	@php(message_clear())
	@endif
	@yield('scripts')
</body>