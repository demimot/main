    $(document).ready(function() {
        $('#stafftable').dataTable( { "ajax": 'config/data-tables.php', 
		"stateSave": true, 
		"sessionStorage": true,
		"columnDefs": [
            {
                "targets": [0],
                "visible": true,
                "searchable": true
            }] } );
		$('#stafftable tbody').on( 'click', 'tr', function () {
            $(this).toggleClass('selected');
        } );
    } );