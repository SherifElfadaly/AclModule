@extends('app')

@section('content')

<div class="container">
	<div class="col-sm-9">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>GroupName</th>
					<th>Active</th>
					<th>Options</th>
				</tr>
			</thead>
			<tbody>
				@foreach($groups as $group)
				<tr>
					<th scope="row">{{ $group->id }}</th>
					<td>{{ $group->group_name }}</td>
					<td>{{ $group->is_active }}</td>
					<td>
						<a class="btn btn-default" href='{{ url("/Acl/groups/edit/$group->id") }}' role="button">Edit</a>
						<a class="btn btn-default" href='{{ url("/Acl/groups/delete/$group->id") }}' role="button">Delete</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection