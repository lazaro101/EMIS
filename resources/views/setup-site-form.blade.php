<!DOCTYPE html>
<html>
<head>
	<title>Site Setup</title>

	  <link rel="stylesheet" type="text/css" href="{{ asset('Semantic/dist/semantic.min.css') }}">
	  <script
	  src="https://code.jquery.com/jquery-3.1.1.min.js"
	  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
	  crossorigin="anonymous"></script>
	  <script src="{{ asset('Semantic/dist/semantic.min.js') }}"></script>
</head>
<body>

	<form class="ui form" method="post" action="/editGeneral">
	    {{csrf_field()}}
	    <div class="ui grid">
	    	<div class="row">
	    		<div class="column">
		    		<div class="ui top attached segment">
					  <div class="ui header">Store Details</div>
					</div>
					<div class="ui attached segment grid">
						<div class="row">
							<div class="four wide middle aligned right aligned column">
								<h5 class="ui header">Catering Name:</h5>
							</div>
							<div class="ten wide column">
								<input type="text" name="cname" placeholder="">
							</div>
						</div>
					</div>
				</div>
	    	</div>
	    	<div class="row">
	    		<div class="column">
		    		<div class="ui top attached segment">
					  <div class="ui header">Address</div>
					</div>
					<div class="ui attached segment grid">
						<div class="row">
							<div class="eight wide column">
								<div class="field">
									<label>Address:</label>
									<input type="text" name="address">
								</div>
								<div class="field">
									<label>Barangay:</label>
									<input type="text" name="brgny">
								</div>
								<div class="field">
									<label>City:</label>
									<input type="text" name="city">
								</div>
								<div class="field">
									<label>Province:</label>
									<input type="text" name="province">
								</div>
							</div>
						</div>
					</div>
				</div>
	    	</div>
	    	<div class="row">
	    		<div class="column">
		    		<div class="ui top attached segment">
					  <div class="ui header">Contact Information</div>
					</div>
					<div class="ui attached segment internally celled grid">
						<div class="two column row">
							<div class="column">
								<div class="two fields">
									<div class="field">
										<label>First Name:</label>
										<input type="text" name="fname" placeholder="First Name">
									</div>
									<div class="field">
										<label>Last Name:</label>
										<input type="text" name="lname" placeholder="Last Name">
									</div>
								</div>
								<div class="field">
									<label>Email:</label>
									<input type="text" name="email">
								</div>
							</div>
							<div class="column">
								<div class="field">
									<label>Telephone:</label>
									<input type="text" name="tnum">
								</div>
								<div class="field">
									<label>Cellphone:</label>
									<input type="text" name="cnum">
								</div>
							</div>
						</div>
					</div>
				</div>
	    	</div>
	    	<div class="row">
		    	<div class="right aligned column">
		    		<button class="ui positive button" type="submit">Save</button>
		    	</div>
	    	</div>
	    </div>
	    </form>
</body>
</html>