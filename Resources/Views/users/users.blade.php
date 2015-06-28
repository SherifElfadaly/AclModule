@extends('core::app')
@section('content')

<div class="container">
	<div class="col-sm-9">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>User Name</th>
					<th>User Email</th>
					<th>User Groups</th>
					<th>Options</th>
				</tr>
			</thead>
			<tbody>
				@foreach($users as $user)
				<tr>
					<th>{{ $user->id }}</th>
					<td>{{ $user->name }}</td>
					<td>{{ $user->email }}</td>
					<td>{{ $user->user_groups }}</td>
					<td>
						@if( ! \CMS::users()->userHasGroup($user->id, 'admin') && 
							   \CMS::permissions()->can('edit', 'Users') && 
							   \Auth::user()->id !== $user->id)
							<a 
							class ="btn btn-default" 
							href  ='{{ url("admin/Acl/users/edit/$user->id") }}' 
							role  ="button">
							Edit
							</a>
						@endif
						@if( ! \CMS::users()->userHasGroup($user->id, 'admin') && 
							   \CMS::permissions()->can('delete', 'Users') && 
							   \Auth::user()->id !== $user->id)
							<a 
							class ="btn btn-default" 
							href  ='{{ url("admin/Acl/users/delete/$user->id") }}' 
							role  ="button">
							Delete
							</a>
						@endif
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection