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

		<h3>Add New Group</h3>
		<form class="form-horizontal" id="group_form" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Group Name</label>
				<div class="col-sm-10">
					<input 
					type="text" 
					class="form-control" 
					id="group_name" 
					name="group_name" 
					placeholder="Group Name" 
					value="{{ old('group_name') }}"
					>
				</div>
			</div>
			<div class="form-group">
				<label for="inputPassword3" class="col-sm-2 control-label">Is Active</label>
				<div class="col-sm-10">
					<input 
					type="checkbox" 
					id="is_acitve" 
					name="is_active"
					>
					Is Active
				</div>
			</div>
			<div class="form-group">
				<label for="inputPassword3" class="col-sm-2 control-label">Permissions</label>
				<div class="col-sm-10">
					<select multiple class="form-control" name="group_permissions[]">
						@foreach($permissions as $permission)
						<option value="{{ $permission->id }}">{{ $permission->key }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" id="group_submit" class="btn btn-default">Submit</button>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection