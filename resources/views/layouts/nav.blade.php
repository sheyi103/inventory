<!-- Navbar -->
<nav class="main-header navbar navbar-expand bg-dark navbar-dark border-bottom">
	<!-- Left navbar links -->
	<ul class="navbar-nav">
		<li class="nav-item">
			<a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
		</li>
	</ul>

	<!-- Right navbar links -->
	<ul class="navbar-nav ml-auto">
		<!-- Notifications Dropdown Menu -->
		<li class="nav-item dropdown notification">
			<a class="nav-link" data-toggle="dropdown" href="#">
				<i class="fa fa-bell-o"></i>
				<span class="badge badge-warning navbar-badge">15</span>
			</a>
			<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right bg-dark">
				<span class="dropdown-item dropdown-header">15 Notifications</span>
				<div class="dropdown-divider"></div>
				<a href="#" class="dropdown-item">
					<i class="fa fa-envelope mr-2"></i> 4 new messages
					<span class="float-right text-muted text-sm">3 mins</span>
				</a>
				<div class="dropdown-divider"></div>
				<a href="#" class="dropdown-item">
					<i class="fa fa-users mr-2"></i> 8 friend requests
					<span class="float-right text-muted text-sm">12 hours</span>
				</a>
				<div class="dropdown-divider"></div>
				<a href="#" class="dropdown-item">
					<i class="fa fa-file mr-2"></i> 3 new reports
					<span class="float-right text-muted text-sm">2 days</span>
				</a>
				<div class="dropdown-divider"></div>
				<a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
			</div>
		</li>
		<img src="{{ asset('images/users/'.Auth::user()->image) }}" class="avatar">
      	<li class="nav-item dropdown notification">
	        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	          {{ Auth::user()->name }}
	        </a>
	        <div class="dropdown-menu bg-dark usl" aria-labelledby="navbarDropdown">
	          	<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a>

	          	<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
	            {{ csrf_field() }}
	          	</form>
	          	<a class="dropdown-item" href="{{ url('/changePassword') }}">
	            	Change Password
	          	</a>
	        </div>
      	</li>
	</ul>
</nav>
<!-- /.navbar -->