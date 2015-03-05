@extends('app')

@section('content')
<div class="container">
	<div class="col-sm-9">
		<h3>{{ $user->name }}'s Profile</h3>
		<a class="btn btn-default" href='{{ url("/Acl/profile/create", [$user->id]) }}' role="button">Add Profile Data</a>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>Title</th>
					<th>Value</th>
					<th>Options</th>
				</tr>
			</thead>
			<tbody>
				@foreach($user->languageContents as $languageContent)
				<tr>
					<th scope="row">{{ $languageContent->id }}</th>
					<td>{{ $languageContent->title }}</td>
					<td>{{ $languageContent->languageContentData->first()->value }}</td>
					<td>
						<a class="btn btn-default" href='{{ url("/Acl/profile/delete/$languageContent->id") }}' role="button">Delete</a>
							@foreach($languageContent->languages as $langugage)
							<a 
							class="btn btn-default" 
							href='{{ url("/Acl/profile/create", [$user->id, $langugage['lang']->id, $languageContent->id]) }}' 
							role="button"
							>
							{{ $langugage['lang']->key }}
							<small>@if( ! $langugage['translated']) || Not Translated @endif</small>
							</a>
							@endforeach
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection