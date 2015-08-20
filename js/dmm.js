// Julio 15-08-2015
function get_article_preview(article_id, section_id) {
    if(article_id){
        var element='#frm_article_content'.concat(section_id);
            $(element).load("/config/preview_issue_article.php?artid=".concat(article_id));
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