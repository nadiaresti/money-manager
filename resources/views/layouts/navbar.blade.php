<!-- Left navbar links -->
<ul class="navbar-nav">
	<li class="nav-item">
		<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
	</li>
</ul>

<!-- Right navbar links -->
<ul class="navbar-nav ml-auto">
	<li class="nav-item">
		<a class="nav-link" href="{{ route('password.change') }}"><i class="fas fa-key"></i></a>
	</li>
	<li class="nav-item">
		<form action="{{ route('logout') }}" method="post">
				@csrf
				<button type="submit" class="btn btn-link nav-link"><i class="fas fa-sign-out-alt"></i></button>
		</form>
	</li>
</ul>