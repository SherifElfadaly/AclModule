@extends('Acl::app')

@section('content')

<div class="container">
	<div class="col-sm-9">
	<h3>{{ $user->name }}'s Profile</h3>
	<a class="btn btn-default" href='{{ url("/Acl/profile/create/$user->id") }}' role="button">Add Profile Data</a>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>Key</th>
					<th>Value</th>
					<th>Options</th>
				</tr>
			</thead>
			<tbody>
				@foreach($user->profiles as $data)
				<tr>
					<th scope="row">{{ $data->id }}</th>
					<td>{{ $data->key }}</td>
					<td>{{ $data->value }}</td>
					<td><a class="btn btn-default" href='{{ url("/Acl/profile/delete/$data->id") }}' role="button">Delete</a></td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection