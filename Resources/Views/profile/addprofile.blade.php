@extends('Acl::app')

@section('content')

<div class="container">
	<div class="col-sm-9">
		@if (count($errors) > 0)
		<div class="alert alert-danger">
			<strong>Whoops!</strong> There were some problems with your input.<br><br>
			<ul>
				@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
		@endif

		@if (Session::has('message'))
		<div class="alert alert-success">
			<ul>
				<li>{{ Session::get('message') }}</li>
			</ul>
		</div>
		@endif

		<h3>Add New Profile</h3>
		<form class="form-inline" id="profile_form_edit" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			
			<div class="row">
				<div class="col-sm-3 col-sm-offset-10">
					<button type="submit" id="profile_submit" class="btn btn-block btn-default">Submit</button>
				</div>
				<div class="col-sm-3 col-sm-offset-1">
					<a id="profile_add" class="btn btn-default">Add</a>
					<a id="profile_remove" class="btn btn-default">Remove</a>
				</div>	
			</div>

			<div class="row"><br></div>

			<div class="row">
				<div class="col-sm-8 profile_data">
					<div class="form-group">
						<label for="inputEmail3">Key</label>
						<input 
						type="text" 
						class="form-control" 
						id="key" 
						name="key[]" 
						placeholder="Key" 
						value="{{ old('name') }}"
						>
					</div>
					<div class="form-group">
						<label for="inputEmail3">Value</label>
						<input 
						type="text" 
						class="form-control" 
						id="value" 
						name="value[]" 
						placeholder="Valeu" 
						value="{{ old('value') }}"
						>
					</div>

					<div class="row"><br></div>

				</div>
			</div>
		</form>
	</div>
</div>
@endsection
