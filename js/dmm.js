// Julio 15-08-2015
function get_article_preview(article_id, section_id) {
    if(article_id){
        var element='#frm_article_content'.concat(section_id);
            $(element).load("/config/preview_issue_article.php?artid=".concat(article_id));
    } 
}

function get_article_pictures_list(article_id) {
    if(article_id){
        var element='#frm_pub_manage_articles_images #frm_pub_articles_images';
            $(element).load("/config/list_article_images.php?artid=".concat(article_id));
    } 
}

function get_issue_article_pictures_list(article_id) {
    if(article_id){
        var element='#frm_pub_manage_issue_articles_images #frm_pub_issue_articles_images';
            $(element).load("/config/list_issue_article_images.php?artid=".concat(article_id));
    } 
}

function get_article_image_details(article_image_id){
    if(article_image_id){
        var element='#article-details';
        $(element).load("/config/get_image_details_by_image_id.php?imgid=".concat(article_image_id));
		$('#frm_issue_article_image_form #frm_article_image_id').val($('#frm_pub_issue_articles_images option:selected').val());
		$('#frm_issue_article_image_form #frm_image_verb').val('delete');
		$('#frm_issue_article_image_form #btn_submit').val($('#frm_issue_article_image_form #delete-label').val());
        $('#frm_issue_article_image_form #frm_image_upload').prop('disabled', true);	
    } 	
}

function get_article_images_preview(article_id, section_id, issue_id) {
    if(article_id){
		var urltoget = "/config/preview_issue_article_images.php?artid=".concat(article_id);
        if(issue_id){ 
	        urltoget = urltoget.concat("&piid=");
		    urltoget = urltoget.concat(issue_id);		
		} 
        var element='#frm_article_images'.concat(section_id);
        $(element).load(urltoget);
    } 
}


function checkTerms() {
     if(document.user_registration.frm_terms.checked)
     {
         document.user_registration.userreg_submit.disabled=false;
     }
     else
     {
         document.user_registration.userreg_submit.disabled=true;
     }
}

function confirm_publishing() {
	var resp = 0;
    if (confirm("Do you really want to publish this issue?\r\nThis action cannot be undone.")) {
	    resp = true;
    } else {
        document.frm_publish_issue_form.publish.disabled=true;
        document.frm_publish_issue_form.frm_check_publish_issue.checked=false;
	    resp= false;
    }
	return resp;
}

function confirm_add_remove_article() {
	var resp = false;
	if ($('#frm_manage_content_verb').val()=='delete'){
        if (confirm('Do you really want to remove the article from this issue?\r\nThis action cannot be undone.')) {
	        resp = true;
        } else {		
            $('#frm_pub_issue_article').readonly=false;
            $('#frm_pub_issue_article').val('');
            $('#frm_pub_issue_article_author').val('');
            $('#frm_pub_issue_article_section').val('');
            $('#frm_pub_issue_article_section').prop('disabled', false);
            $('#frm_pub_issue_deadline').val('');
            $('#frm_pub_issue_deadline').prop('disabled', false);
            $('#frm_pub_issue_article_id').val('');
            $('#frm_manage_content_verb').val('add');
            $('#btn_manage_content').val('Request Article');
            $('#frm_articles').val('');
	        resp= false;
        }
	} else if ($('#frm_manage_content_verb').val()=='update'){
	    resp = true;	
	} else if ($('#frm_manage_content_verb').val()=='add'){
	    resp = true;	
	}
	return resp;
}

function confirm_new_issue(){
    var resp = false;	
    resp = confirm('Do you really want to create a new issue of this publication?.')
    return resp;
}

function set_article_image_update(){
	$('#frm_issue_article_image_form #frm_image_verb').val('update');
	if ($('#frm_issue_article_image_form #save-label').val())	$('#frm_issue_article_image_form #btn_submit').val($('#frm_issue_article_image_form #save-label').val());	
}

function set_frm_issue_article_image_form(){
    $('#frm_issue_article_image_form #frm_image_upload').prop('disabled', false);
    $('#frm_issue_article_image_form #frm_image_caption').prop('disabled', false);
    $('#frm_issue_article_image_form #frm_image_copyright').prop('disabled', false);
    $('#frm_issue_article_image_form #frm_image_weight').prop('disabled', false);
    $('#frm_issue_article_image_form #btn_submit').prop('disabled', false);
    $('#frm_issue_article_image_form #btn_cancel').prop('disabled', false);
    $('#frm_issue_article_image_form #frm_article_id').val($('#frm_articles  option:selected').val());
    $('#frm_issue_article_image_form #frm_image_caption').val('');
    $('#frm_issue_article_image_form #frm_image_copyright').val('');
    $('#frm_issue_article_image_form #frm_article_image_id').val('');
    $('#frm_issue_article_image_form #frm_image_weight').val(1);
	
	$('#frm_pub_manage_issue_articles_images #frm_pub_issue_articles_images').prop('disabled', false);
	$('#frm_pub_manage_issue_articles_images #frm_pub_issue_articles_images').empty();
	/* go get pivtures list AJAX*/
	
}

function reset_frm_issue_article_image_form(){
    $('#frm_issue_article_image_form #frm_image_upload').prop('disabled', true);
    $('#frm_issue_article_image_form #frm_image_caption').prop('disabled', true);
    $('#frm_issue_article_image_form #frm_image_copyright').prop('disabled', true);
    $('#frm_issue_article_image_form #frm_image_weight').prop('disabled', true);
	$('#frm_issue_article_image_form #frm_image_caption').removeAttr('onchange');
    $('#frm_issue_article_image_form #frm_image_copyright').removeAttr('onchange');
    $('#frm_issue_article_image_form #frm_image_weight').removeAttr('onchange');
	/* begin IE 6, 7, 8 */
	$('#frm_issue_article_image_form #frm_image_caption').prop('onchange', null);
    $('#frm_issue_article_image_form #frm_image_copyright').prop('onchange', null);
    $('#frm_issue_article_image_form #frm_image_weight').prop('onchange', null);
	/* end IE 6, 7, 8 */

    $('#frm_issue_article_image_form #btn_submit').prop('disabled', true);
    $('#frm_issue_article_image_form #btn_cancel').prop('disabled', true);
    $('#frm_issue_article_image_form #frm_image_caption').val('');
    $('#frm_issue_article_image_form #frm_image_copyright').val('');
    $('#frm_issue_article_image_form #frm_article_id').val('');
    $('#frm_issue_article_image_form #frm_article_image_id').val('');
	$('#frm_issue_article_image_form #frm_image_upload').val('');
    $('#frm_issue_article_image_form #frm_image_weight').val(1);
	$('#frm_issue_article_image_form #frm_image_verb').val('add');

	if ($('#frm_issue_article_image_form #save-label').val())	$('#frm_issue_article_image_form #btn_submit').val($('#frm_issue_article_image_form #save-label').val());
	
	$('#frm_pub_manage_issue_articles_images #frm_pub_issue_articles_images').prop('disabled', true);
	$('#frm_pub_manage_issue_articles_images #frm_pub_issue_articles_images').empty();
}


function set_frm_pub_issue_section_articles_form(){
    $('#frm_pub_issue_section_articles_form #frm_pub_issue_article').val($('#frm_articles option:selected').text());
    $('#frm_pub_issue_section_articles_form #frm_pub_issue_article').prop('readonly', true);
    $('#frm_pub_issue_section_articles_form #frm_pub_issue_article_author').val($('#frm_articles option:selected').attr('data-author'));
    $('#frm_pub_issue_section_articles_form #frm_pub_issue_article_author').prop('disabled', true);
    $('#frm_pub_issue_section_articles_form #frm_pub_issue_article_section').val($('#frm_articles option:selected').attr('data-section'));
    $('#frm_pub_issue_section_articles_form #frm_pub_issue_deadline').val($('#frm_articles option:selected').attr('data-deadline'));
    $('#frm_pub_issue_section_articles_form #frm_pub_issue_deadline').prop('disabled', true);
    $('#frm_pub_issue_section_articles_form #frm_pub_issue_article_weight').val($('#frm_articles option:selected').attr('data-weight'));
    $('#frm_pub_issue_section_articles_form #frm_pub_issue_article_id').val($('#frm_articles  option:selected').val());
    $('#frm_pub_issue_section_articles_form #frm_manage_content_verb').val('delete');
    $('#frm_pub_issue_section_articles_form #btn_manage_content').prop('value', 'Remove Article');
	$('#frm_pub_manage_articles_images #frm_pub_issue_article_id').val($('#frm_articles option:selected').val());
    $('#frm_pub_manage_articles_images #frm_use_article_images').prop('checked', $('#frm_articles option:selected').attr('data-use-images')==1);
	$('#frm_pub_manage_articles_images #frm_pub_articles_images').empty();
    $('#frm_pub_manage_articles_images #frm_pub_articles_images').prop('disabled', false);
    $('#frm_pub_manage_articles_images #frm_use_article_images').prop('disabled', false);
    $('#frm_pub_manage_articles_images #btn_confirm_article_images').prop('disabled', true);
    $('#frm_pub_manage_articles_images #btn_cancel_article_images').prop('disabled', true);
	
	$('#frm_issue_article_image_form #frm_image_caption').removeAttr('onchange');
    $('#frm_issue_article_image_form #frm_image_copyright').removeAttr('onchange');
    $('#frm_issue_article_image_form #frm_image_weight').removeAttr('onchange');
	/* begin IE 6, 7, 8 */
	$('#frm_issue_article_image_form #frm_image_caption').prop('onchange', null);
    $('#frm_issue_article_image_form #frm_image_copyright').prop('onchange', null);
    $('#frm_issue_article_image_form #frm_image_weight').prop('onchange', null);	
	
	$('#frm_issue_article_image_form #frm_image_upload').val('');
	
	get_article_pictures_list($('#frm_articles option:selected').val());
	get_issue_article_pictures_list($('#frm_articles option:selected').val());
}

function reset_frm_pub_issue_section_articles_form(){
	$('#frm_pub_issue_article').prop('readonly', false);
    $('#frm_pub_issue_article').val('');
    $('#frm_pub_issue_article_author').val('');
    $('#frm_pub_issue_article_author').prop('disabled', false);
    $('#frm_pub_issue_article_section').val('');
    $('#frm_pub_issue_article_section').prop('disabled', false);
    $('#frm_pub_issue_section_articles #frm_articles').val('');
    $('#frm_pub_issue_deadline').val('');
    $('#frm_pub_issue_deadline').prop('disabled', false);
    $('#frm_pub_issue_article_weight').val(3);
    $('#frm_pub_issue_article_id').val('');
    $('#frm_manage_content_verb').val('add');
    $('#frm_use_article_images').prop('checked', 0);
    $('#frm_pub_manage_articles_images #frm_pub_issue_article_id').val('');
	$('#frm_pub_manage_articles_images #frm_pub_articles_images').empty();
    $('#frm_pub_manage_articles_images #frm_pub_articles_images').prop('disabled', true);
    $('#frm_pub_manage_articles_images #frm_use_article_images').prop('disabled', true);
    $('#frm_pub_manage_articles_images #btn_confirm_article_images').prop('disabled', true);
    $('#frm_pub_manage_articles_images #btn_cancel_article_images').prop('disabled', true);
	
    $('#btn_manage_content').prop('value', 'Request article');
}

function enable_use_image_button(){
    $('#frm_pub_manage_articles_images #btn_confirm_article_images').prop('disabled', false);
    $('#frm_pub_manage_articles_images #btn_cancel_article_images').prop('disabled', false);
}

function reset_frm_pub_manage_articles_images(){
	$('#frm_pub_manage_articles_images #frm_pub_articles_images').val('');
}

function prep_update_frm_pub_issue_section_articles_form(){
	if ($('#frm_manage_content_verb').val()=='delete'){
        $('#frm_manage_content_verb').val('update');
        $('#frm_pub_issue_article_id').val($('#frm_articles  option:selected').val());
        $('#btn_manage_content').prop('value', 'Update article');
	}
}

function set_frm_pub_sections_form(){
    $('#frm_section_name').val($('#frm_sections option:selected').text());
    $('#frm_section_name').prop('readonly', true);
    $('#frm_section_order').val($('#frm_sections option:selected').attr('data-order'));
    $('#frm_section_verb').val('delete');
    $('#btn_section').prop('value', 'Delete Section');
}

function reset_frm_pub_sections_form(){
    $('#frm_sections').val('');
    $('#frm_section_name').prop('readonly', false);
    $('#frm_section_name').val('');
    $('#frm_section_order').val('');
    $('#frm_section_verb').val('add');
    $('#btn_section').prop('value', 'Add Column');
}

function set_frm_pub_columns_form(){
    $('#frm_column_name').val($('#frm_columns option:selected').text());
    $('#frm_column_name').prop('readonly', true);
    $('#frm_column_section').val($('#frm_columns option:selected').attr('data-column-id'));
    $('#column_staff_select').val($('#frm_columns option:selected').attr('data-column-user-id'));
    $('#frm_column_verb').val('delete');
    $('#btn_column').prop('value', 'Delete column');
}

function reset_frm_pub_columns_form(){
    $('#frm_columns').val('');
    $('#frm_column_name').prop('readonly', false);
    $('#frm_column_name').val('');
    $('#frm_column_section').val('');
    $('#column_staff_select').val('');
    $('#frm_column_verb').val('add');
    $('#btn_column').prop('value', 'Add Column');
}

function reset_frm_pub_staff_form(){
    $('#pub_staff_select').val('');
    $('#frm_pub_staff_user_id').val('');
    $('#frm_pub_staff_name').val('');
    $('#frm_pub_staff_verb').val('add');
	$('#stafftable .selected').removeClass('selected');
    $('#btn_staff').prop('value', 'Add contributor');
}

function set_frm_issue_sections_form(){
    $('#frm_section_name').val($('#frm_sections option:selected').text());
    $('#frm_section_name').prop('readonly', true);
    $('#frm_section_order').prop('readonly', true);
    $('#frm_section_order').val($('#frm_sections option:selected').attr('data-order'));
    $('#frm_section_verb').val('delete');
    $('#btn_section').prop('value', 'Delete Section');
}

function reset_frm_issue_sections_form(){
   $('#frm_sections').val('');
   $('#frm_section_name').prop('readonly', false);
   $('#frm_section_order').prop('readonly', false);
   $('#frm_section_name').val('');
   $('#frm_section_order').val('');
   $('#frm_section_verb').val('add');
   $('#btn_section').prop('value', 'Add Section');
}

function set_frm_article_image_form(){
	$('#frm_article_image_form #frm_image_upload').prop('disabled', true);
	$('#frm_article_image_form #frm_image_caption').val($('#frm_article_images_list option:selected').attr('data-image-caption'));
	$('#frm_article_image_form #frm_image_copyright').val($('#frm_article_images_list option:selected').attr('data-image-credits'));
	$('#frm_article_image_form #frm_image_weight').val($('#frm_article_images_list option:selected').attr('data-image-weight'));
	$('#frm_article_image_form #frm_article_image_id').val($('#frm_article_images_list option:selected').val());
	$('#frm_article_image_form #frm_image_verb').val('update');
frm_image_verb

}

function reset_frm_article_image_form(){
	$('#frm_article_image_form #frm_image_upload').prop('disabled', false);
	$('#frm_article_image_form #frm_image_caption').val('');
	$('#frm_article_image_form #frm_image_copyright').val('');
	$('#frm_article_image_form #frm_image_weight').val('1');
	$('#frm_article_image_form #frm_article_image_id').val('');
	$('#frm_article_image_form #frm_image_verb').val('add');
    $('#frm_article_images_list_form #frm_article_images_list').val('');
}

function get_date(dateformat){
    $('#frm_pub_issue_deadline').fdatepicker({
	    format: dateformat,
	    disableDblClickSelection: true
	});	
}

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
});