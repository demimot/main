    $('#stafftable').dataTable( { "ajax": 'config/non-staff-users-data-tables.php?pub-id=<!--[$smarty.get.pubid]-->', 
        "rowId": 'DT_RowId',
		"stateSave": true, 
		"sessionStorage": true,
		"columnDefs": [
            {
                "targets": [0],
                "visible": true,
                "searchable": true
            }] } );
		
        
    var table = $('#stafftable').DataTable();
 
    $('#stafftable tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );
 
    $('#stafftable').click( function () {
        $("#frm_pub_staff_form #frm_pub_staff_name").val(table.cell('.selected', 1).data());
        $("#frm_pub_staff_form #frm_pub_staff_user_id").val(table.cell('.selected', 0).data());
        $("#frm_pub_staff_form #btn_staff").val('Add contributor');
        $("#frm_pub_staff_form #frm_pub_staff_verb").val('add');
        $("#frm_pub_staff_form #pub_staff_select").val([]);
    } ); 
    
    $('#pub_staff_select').change( function () {
        if($("#pub_staff_select").val()!=""){
            $("#frm_pub_staff_name").val($("#pub_staff_select option:selected").text());
            $("#frm_pub_staff_user_id").val($("#pub_staff_select").val());
            $("#btn_staff").val('Delete contributor');
            $("#frm_pub_staff_verb").val('delete');
        } else {
            $("#frm_pub_staff_name").val('');
            $("#frm_pub_staff_user_id").val('');
            $("#frm_pub_staff_form #pub_staff_select").val([]);
            $("#frm_pub_staff_form #frm_pub_staff_verb").val('add');
        }
    } ); 