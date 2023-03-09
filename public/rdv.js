$('.arrow').click(function() {
    $(this).toggleClass('active');
	$sort = 'desc';
	if(this.class == 'arrow'){
		$sort = 'asc';
	}
	switch (this.id) {
			case 'name': $name = $sort
			break;
			case 'statut': $statut = 'asc'
			break;
			case 'duree': $duree = 'asc'
			break;
			case 'date': $date = 'asc'
			break;
			default:
    		console.log(`Error`);
	}
	$.ajax({
  	type: "GET",
  	url: "",
  	data: {name: $name,
	statut: $statut,
	duree: $duree,
	date: $date},
	success: alert('POSTED')
	});
});

$( function() {
    $( "#datepicker" ).datepicker({
		onSelect: function(date) {
		   $.ajax({
			type: "GET",
			url: window.location.href,
			data: {date: date},
		  	success: alert('POSTED')
		  });
		}
	 });
} );
