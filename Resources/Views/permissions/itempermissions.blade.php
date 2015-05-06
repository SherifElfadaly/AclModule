@extends('app')

@section('content')

<div class="container">
	<div class="col-sm-9">
		@if (Session::has('message'))
		<div class="alert alert-success">
			<ul>
				<li>{{ Session::get('message') }}</li>
			</ul>
		</div>
		@endif

		<form id="item_permission_form" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Group Name</th>
						@foreach($permissions as $permission)
							<th>{{ $permission->key }}</th>
						@endforeach
					</tr>
				</thead>
				<tbody>
					@foreach($groups as $group)
					<tr>
						<td>{{ $group->group_name }}</td>
						@foreach($permissions as $permission)
										<td>
										<input 
										type ="checkbox" 
										id   ="allowed" 
										name ="{{ $group->id }}_{{ $permission->id }}" 
										@if($group->group_name === 'admin')
											onclick="return false"
										@endif
										@foreach($itemPermissions as $itemPermission)
											@if($permission->id == $itemPermission->permission_id && 
												$group->id == $itemPermission->group_id)
												checked
											@endif
										@endforeach
										> 
										Allowed
									</td>
						@endforeach
					</tr>
					@endforeach
				</tbody>
			</table>
			<input type="submit" class="btn btn-default" role="button" value="Save">
		</form>
	</div>
</div>
@endsection