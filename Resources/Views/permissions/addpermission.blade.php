@extends('app')

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

		<h3>Add New Permission</h3>
		<form class="form-horizontal" id="permission_form" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Permission Name</label>
				<div class="col-sm-10">
					<input 
					type="text" 
					class="form-control" 
					id="permission_name" 
					name="key" 
					placeholder="Permission Name" 
					value="{{ old('key') }}"
					>
				</div>
			</div>
			<div class="form-group">
				<label for="inputPassword3" class="col-sm-2 control-label">Permission Value</label>
				<div class="col-sm-10">
					<select class="form-control" name="value" id="permission_value" >
						<option @if(old('value') === '1') selected @endif value="1">True</option>
						<option @if(old('value') === '0') selected @endif value="0">False</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" id="permission_submit" class="btn btn-default">Submit</button>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection
