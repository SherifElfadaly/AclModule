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

		<h3>Add New User</h3>
		<form class="form-horizontal" id="user_form_edit" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="hidden" name="password" value="{{ $user->password }}">
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">User Name</label>
				<div class="col-sm-10">
					<input 
					type="text" 
					class="form-control" 
					id="user_name" 
					name="name" 
					placeholder="User Name" 
					value="{{ $user->name }}"
					>
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">User Email</label>
				<div class="col-sm-10">
					<input 
					type="email" 
					class="form-control" 
					id="user_email" 
					name="email" 
					placeholder="User Email" 
					value="{{ $user->email }}"
					>
				</div>
			</div>	
			<div class="form-group">
				<label for="inputPassword3" class="col-sm-2 control-label">Groups</label>
				<div class="col-sm-10">
					<select multiple class="form-control" name="user_groups[]">
					@foreach($groups as $group)
						<option value="{{ $group->id }}">{{ $group->group_name }}</option>
					@endforeach

					@foreach($user->groups as $user_group)
					<option value="{{ $user_group->id }}" selected>
						{{ $user_group->group_name }}
					</option>
					@endforeach
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" id="user_submit" class="btn btn-default">Submit</button>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection
