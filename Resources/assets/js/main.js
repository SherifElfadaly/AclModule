$(document).ready(function () {
	$('#profile_add').on('click', function(e){
		$('.profile_data').last().after($('<div>').append($('.profile_data').last().clone()).html());
	});

	$('#profile_remove').on('click', function(e){
		if($('.profile_data').length > 1)
		{
			$('.profile_data').last().remove();
		}
	});
});