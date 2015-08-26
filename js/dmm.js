// Julio 15-08-2015
function get_article_preview(article_id, section_id) {
    if(article_id){
        var element='#frm_article_content'.concat(section_id);
            $(element).load("/config/preview_issue_article.php?artid=".concat(article_id));
    } 
}

function get_article_images_preview(article_id, section_id) {
    if(article_id){
        var element='#frm_article_images'.concat(section_id);
            $(element).load("/config/preview_issue_article_images.php?artid=".concat(article_id));
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

function confirm_remove_article() {
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
	}
	return resp;
}