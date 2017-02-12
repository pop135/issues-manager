<?php
require('include/header.php');
?>

<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<a href="#!" class="navbar-brand"><img src="img/logo.png"></a>
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			
		</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="about.php">About</a></li>
				<li><a href="mailto:info@nextec-pro.com">Contact</a></li>		
			</ul>
		</div>
	</div>
</nav>


<!-- Login Form -->
<div class="container">
<!-- HTML Form -->
      <form action="submit.php" method="post" name="login_form" id="login_form" autocomplete="off">
        <h2 class="form-signin-heading">Login</h2>

        <label for="Email" class="sr-only">Email address</label>
        <input type="email" name="Email" id="Email" class="form-control" placeholder="Email address" required autofocus>

        <label for="Password" class="sr-only">Password</label>
        <input type="password" name="Password" id="Password" class="form-control" placeholder="Password" required pattern=".{6,12}" title="6 to 12 characters.">

        <div id="display_error" class="alert alert-danger fade in"></div><!-- Display Error Container -->

        <button type="submit" class="btn btn-lg btn-primary btn-block">Login</button>
        <button type="button" class="btn btn-lg btn-info btn-block" data-toggle="modal" data-target="#registration_modal">Create an account</button>
      </form>
<!-- /HTML Form -->




<!-- Registration Form -->
  <div class="modal fade" role="dialog" id="registration_modal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- HTML Form -->
        <form action="submit.php" method="post" name="registration_form" id="registration_form" autocomplete="off">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Registration form</h4>
        </div>
        <!-- Modal Body -->
        <div class="modal-body">
            <div class="form-group">
                <label for="Name">Full name</label>
                <input type="text" name="Name" id="Name" class="form-control" required pattern=".{2,100}" title="min 2 characters." autofocus>
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" name="Email" id="Email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="Password">New password</label>
                <input type="password" name="Password" id="Password" class="form-control" required pattern=".{6,12}" title="6 to 12 characters.">
            </div>
                <div id="display_error" class="alert alert-danger fade in"></div><!-- Display Error Container -->
        </div>

        <!-- Modal Footer -->
        <div class="modal-footer">
        <input type="submit" class="btn btn-lg btn-primary" value="Submit" id="submit">
          <button type="button" class="btn  btn-lg  btn-default" data-dismiss="modal">Cancel</button>
        </div>
        </form>

      </div>
    </div>
  </div>

<?php require('include/footer.php');?>