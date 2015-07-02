@extends('core::app')
@section('content')

<div class="container">
	<div class="col-sm-9">

		<h3>All Groups</h3>
		@if(\CMS::permissions()->can('add', 'Groups'))
			<a href='{{ url("admin/Acl/groups/create") }}' class="btn btn-default">Add Groups</a>
		@endif
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
					<th>{{ $group->id }}</th>
					<td>{{ $group->group_name }}</td>
					<td>{{ $group->is_active }}</td>
					<td>
						@if(\CMS::permissions()->can('edit', 'Groups'))
							<a 
							class ="btn btn-default" 
							href  ='{{ url("admin/Acl/groups/edit/$group->id") }}' 
							role  ="button">
							Edit
							</a>
						@endif
						@if(\CMS::permissions()->can('delete', 'Groups'))
							<a 
							class ="btn btn-default" 
							href  ='{{ url("admin/Acl/groups/delete/$group->id") }}' 
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