@extends('Acl::app')

@section('content')

<div class="container">
	<div class="col-sm-9">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>User Name</th>
					<th>User Email</th>
					<th>Options</th>
				</tr>
			</thead>
			<tbody>
				@foreach($users as $user)
				<tr>
					<th scope="row">{{ $user->id }}</th>
					<td>{{ $user->name }}</td>
					<td>{{ $user->email }}</td>
					<td>
						<a class="btn btn-default" href='{{ url("/Acl/users/edit/$user->id") }}' role="button">Edit</a>
						<a class="btn btn-default" href='{{ url("/Acl/users/delete/$user->id") }}' role="button">Delete</a>
						<a class="btn btn-default" href='{{ url("/Acl/profile/show/$user->id") }}' role="button">Profile</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection