@extends('layouts.admin')

@section('title','General')

@section('script')

@endsection

@section('style')

@endsection

@section('content')

  <div class="ui basic segment content">
  	<div class="ui small breadcrumb">
	  <a class="section" href="../Settings">Settings</a>
	  <i class="right chevron icon divider"></i>
	  <div class="active section">General</div>
	</div>
    <h1 class="ui header">
      <div class="content">General</div>
    </h1>

    <div class="ui clearing divider"></div>
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
							<input type="text" name="cname" placeholder="" value="{{$gen->catering_name}}">
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
								<input type="text" name="address" value="{{$gen->address}}">
							</div>
							<div class="field">
								<label>Barangay:</label>
								<input type="text" name="brgny" value="{{$gen->barangay}}">
							</div>
							<div class="field">
								<label>City:</label>
								<input type="text" name="city" value="{{$gen->city}}">
							</div>
							<div class="field">
								<label>Province:</label>
								<input type="text" name="province" value="{{$gen->province}}">
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
									<input type="text" name="fname" placeholder="First Name" value="{{$gen->contact_fname}}">
								</div>
								<div class="field">
									<label>Last Name:</label>
									<input type="text" name="lname" placeholder="Last Name" value="{{$gen->contact_lname}}">
								</div>
							</div>
							<div class="field">
								<label>Email:</label>
								<input type="text" name="email" value="{{$gen->contact_email}}">
							</div>
						</div>
						<div class="column">
							<div class="field">
								<label>Telephone:</label>
								<input type="text" name="tnum" value="{{$gen->contact_tele}}">
							</div>
							<div class="field">
								<label>Cellphone:</label>
								<input type="text" name="cnum" value="{{$gen->contact_cell}}">
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
  </div>

@endsection