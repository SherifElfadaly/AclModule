@extends('app')

@section('content')

<div class="container">
	<div class="col-sm-9">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>Permission Name</th>
					<th>Options</th>
				</tr>
			</thead>
			<tbody>
				@foreach($permissions as $permission)
				<tr>
					<th scope="row">{{ $permission->id }}</th>
					<td>{{ $permission->key }}</td>
					<td>
						<a class="btn btn-default" href='{{ url("/Acl/permissions/edit/$permission->id") }}' role="button">Edit</a>
						<a class="btn btn-default" href='{{ url("/Acl/permissions/delete/$permission->id") }}' role="button">Delete</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection