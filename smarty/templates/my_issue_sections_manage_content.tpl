<!--[if $debug]--><!--[$smarty.template]--><!--[/if]-->
<form id="frm_pub_issue_section_articles" id="frm_pub_issue_section_articles">
    <label for="frm_articles" class="left">Issue articles:</label>
    <select name="frm_articles" id="frm_articles" multiple  style="min-height:200px;" onchange="$('#frm_pub_issue_section_articles_form #frm_pub_issue_article').val($('#frm_articles option:selected').text());
                                                                                 $('#frm_pub_issue_section_articles_form #frm_pub_issue_article').prop('readonly', true);
                                                                                 $('#frm_pub_issue_section_articles_form #frm_pub_issue_article_author').val($('#frm_articles option:selected').attr('data-author'));
                                                                                 $('#frm_pub_issue_section_articles_form #frm_pub_issue_article_section').val($('#frm_articles option:selected').attr('data-section'));
                                                                                 $('#frm_pub_issue_section_articles_form #frm_pub_issue_article_section').prop('disabled', true);
                                                                                 $('#frm_pub_issue_section_articles_form #frm_pub_issue_deadline').val($('#frm_articles option:selected').attr('data-deadline'));
                                                                                 $('#frm_pub_issue_section_articles_form #frm_pub_issue_deadline').prop('disabled', true);
                                                                                 $('#frm_pub_issue_section_articles_form #frm_pub_issue_article_id').val($('#frm_articles  option:selected').val());
                                                                                 $('#frm_pub_issue_section_articles_form #frm_manage_content_verb').val('delete');
                                                                                 $('#frm_pub_issue_section_articles_form #btn_manage_content').prop('value', 'Remove Article');" >
    <!--[assign var="flag" value="0"]-->
    <!--[foreach name=externo item=section_article from=$this_issue.issue_articles]-->
        <option data-deadline="<!--[$section_article.article_deadline|escape]-->" data-author="<!--[$section_article.article_author_id|escape]-->" data-section="<!--[$section_article.section_id|escape]-->" value="<!--[$section_article.article_id|escape]-->"><!--[$section_article.article_title]--></option>
        <!--[assign var="flag" value="1"]-->
    <!--[/foreach]-->
    <!--[if not $flag]-->    <option value="">-- None --</option><!--[/if]-->
    </select>
</form>