@extends('app')
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
						@if( ! \AclRepository::userHasGroup($user->id, 'admin') && 
								\AclRepository::can('edit', 'Users') && 
								\Auth::user()->id !== $user->id)
							<a 
							class ="btn btn-default" 
							href  ='{{ url("/Acl/users/edit/$user->id") }}' 
							role  ="button">
							Edit
							</a>
						@endif
						@if( ! \AclRepository::userHasGroup($user->id, 'admin') && 
								\AclRepository::can('delete', 'Users') && 
								\Auth::user()->id !== $user->id)
							<a 
							class ="btn btn-default" 
							href  ='{{ url("/Acl/users/delete/$user->id") }}' 
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