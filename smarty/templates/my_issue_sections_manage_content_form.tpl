<!--[if $debug]--><!--[$smarty.template]--><!--[/if]-->
<form id="frm_pub_issue_section_articles_form" id="frm_pub_issue_section_articles_form" action="" method="post" onsubmit="return confirm_remove_article();">
    <label for="frm_pub_issue_article" class="left">Title:</label>
    <input type="text" class="validate[required]" name="frm_pub_issue_article" id="frm_pub_issue_article" placeholder="Type article's title" >
    <label for="frm_pub_issue_article_author" class="left">Author:</label>
    <select class="validate[required]" name="frm_pub_issue_article_author" id="frm_pub_issue_article_author" <!--[if not $this_issue.issue_staff]-->disabled<!--[/if]-->>
    <!--[assign var="flag" value="0"]-->
        <option value="">Select an author</option> 
    <!--[foreach name=externo item=issue_staff from=$this_issue.issue_staff]-->
        <option value="<!--[$issue_staff.user_id]-->"><!--[$issue_staff.user_nickname|escape]--></option>
        <!--[assign var="flag" value="1"]-->
    <!--[/foreach]-->
    <!--[if not $flag]-->    <option value="">-- None --</option><!--[/if]-->
    </select>
    <label for="frm_pub_issue_article_section" class="left">Section:</label>
    <select class="validate[required]" name="frm_pub_issue_article_section" id="frm_pub_issue_article_section"<!--[if not $this_issue.issue_sections]-->disabled<!--[/if]-->>
    <!--[assign var="flag" value="0"]-->
        <option value="">Select a section</option> 
    <!--[foreach name=externo item=issue_section from=$this_issue.issue_sections]-->
        <option value="<!--[$issue_section.section_id]-->"><!--[$issue_section.section_name|escape]--></option>
        <!--[assign var="flag" value="1"]-->
    <!--[/foreach]-->
    <!--[if not $flag]-->    <option value="">-- None --</option><!--[/if]-->
    </select>
    <label for="frm_pub_issue_deadline" class="left">Deadline:</label>
    <input type="text" class="validate[required]" name="frm_pub_issue_deadline" id="frm_pub_issue_deadline" placeholder="Date 'dd-mm-yyyy'"  onclick="$('#frm_pub_issue_deadline').fdatepicker({
					format: '<!--[$date_format]-->',
					disableDblClickSelection: true
				})" >
    <div class="row">
    <div class="large-12 columns">
        <input class="button small large-5" id="btn_manage_content" type="submit" value="Request Article" <!--[if $no_edit]-->disabled<!--[/if]-->/>&nbsp;&nbsp;&nbsp;
        <input class="button small large-5" id="btn_manage_content_cancel" type="button" value="cancel" onclick="$('#frm_pub_issue_article_author').val('');
                                                                                                      $('#frm_pub_issue_article').prop('readonly', false);
                                                                                                      $('#frm_pub_issue_article').val('');
                                                                                                      $('#frm_pub_issue_article_section').val('');
                                                                                                      $('#frm_pub_issue_article_section').prop('disabled', false);
                                                                                                      $('#frm_pub_issue_section_articles #frm_articles').val('');
                                                                                                      $('#frm_pub_issue_deadline').val('');
                                                                                                      $('#frm_pub_issue_deadline').prop('disabled', false);
                                                                                                      $('#frm_pub_issue_article_id').val('');
                                                                                                      $('#frm_manage_content_verb').val('add');
                                                                                                      $('#btn_manage_content').prop('value', 'Request Article');" />&nbsp;&nbsp;&nbsp;
                                
        <input type="hidden" name="frm_submit" id="frm_submit" value=54 />
        <input type="hidden" name="frm_pub_issue_id" id="frm_pub_issue_id" value=<!--[$this_issue.pub_issue_id]--> />
        <input type="hidden" name="frm_pub_issue_article_id" id="frm_pub_issue_article_id" value=""/>
        <input type="hidden" name="frm_manage_content_verb" id="frm_manage_content_verb" value="add">
        <input type="hidden" name="frm_xss" id="frm_xss" value=<!--[$smarty.session.form_xss]--> />
    </div>
    </div>                      
</form>