<!--[if $debug]--><span style="color:red;"><!--[$smarty.template]--></span><!--[/if]--><!--[dmm_template_static_content template_name=$smarty.template language=$smarty.session.language assign='static_content']-->
<form id="frm_pub_issue_section_articles_form" id="frm_pub_issue_section_articles_form" action="" method="post" onsubmit="return confirm_add_remove_article();">
    <div class="row">
        <div class="large-12 columns">
        <label for="frm_pub_issue_article" class="left"><!--[$static_content.label1|escape]--></label>
        <input type="text" class="validate[required]" name="frm_pub_issue_article" id="frm_pub_issue_article" placeholder="<!--[$static_content.label2|escape]-->" >
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
        <label for="frm_pub_issue_article_author" class="left"><!--[$static_content.label3|escape]--></label>
        <select class="validate[required]" name="frm_pub_issue_article_author" id="frm_pub_issue_article_author" <!--[if not $this_issue.issue_staff]-->disabled<!--[/if]-->>
        <!--[assign var="flag" value="0"]-->
            <option value=""><!--[$static_content.label4|escape]--></option> 
        <!--[foreach name=externo item=issue_staff from=$this_issue.issue_staff]-->
            <option value="<!--[$issue_staff.user_id]-->"><!--[$issue_staff.user_nickname|escape]--></option>
            <!--[assign var="flag" value="1"]-->
        <!--[/foreach]-->
        <!--[if not $flag]-->    <option value=""><!--[$static_content.label5|escape]--></option><!--[/if]-->
        </select>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label for="frm_pub_issue_article_section" class="left"><!--[$static_content.label6|escape]--></label>
            <select class="validate[required]" name="frm_pub_issue_article_section" id="frm_pub_issue_article_section" onchange="prep_update_frm_pub_issue_section_articles_form();"<!--[if not $this_issue.issue_sections]-->disabled<!--[/if]--> >
            <!--[assign var="flag" value="0"]-->
                <option value=""><!--[$static_content.label7|escape]--></option> 
            <!--[foreach name=externo item=issue_section from=$this_issue.issue_sections]-->
                <option value="<!--[$issue_section.section_id]-->"><!--[$issue_section.section_name|escape]--></option>
                <!--[assign var="flag" value="1"]-->
            <!--[/foreach]-->
            <!--[if not $flag]-->    <option value=""><!--[$static_content.label5|escape]--></option><!--[/if]-->
            </select>
        </div>
    </div>
    <div class="row">
        <div class="large-4 columns">
            <label for="frm_pub_issue_deadline" class="left"><!--[$static_content.label8|escape]--></label>
            <input type="text" class="validate[required]" name="frm_pub_issue_deadline" id="frm_pub_issue_deadline" placeholder="<!--[$static_content.label9|escape]-->"  onclick="get_date('<!--[$date_format]-->');" >
        </div>
        <div class="large-8 columns">
            <label for="frm_pub_issue_article_weight" class="left"><!--[$static_content.label10|escape]--></label>
            <select name="frm_pub_issue_article_weight" id="frm_pub_issue_article_weight" onchange="prep_update_frm_pub_issue_section_articles_form();"<!--[if not $this_issue.issue_sections]-->disabled<!--[/if]--> >
                <option value="0">0 - <!--[$static_content.label11|escape]--></option> 
                <option value="1">1 - <!--[$static_content.label12|escape]--></option>
                <option value="2">2 - <!--[$static_content.label13|escape]--></option>
                <option value="3" selected="selected">3 - <!--[$static_content.label14|escape]--></option>
                <option value="4">4 - <!--[$static_content.label15|escape]--></option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <input class="button small large-5 left" id="btn_manage_content" type="submit" value="<!--[$static_content.label16|escape]-->" <!--[if $no_edit]-->disabled<!--[/if]-->/>
            <input class="button small large-5 right" id="btn_manage_content_cancel" type="button" value="<!--[$static_content.label17|escape]-->" onclick="reset_frm_pub_issue_section_articles_form();reset_frm_issue_article_image_form();" />                    
            <input type="hidden" name="frm_submit" id="frm_submit" value=54 />
            <input type="hidden" name="frm_pub_issue_id" id="frm_pub_issue_id" value=<!--[$this_issue.pub_issue_id]--> />
            <input type="hidden" name="frm_pub_issue_article_id" id="frm_pub_issue_article_id" value=""/>
            <input type="hidden" name="frm_manage_content_verb" id="frm_manage_content_verb" value="add">
            <input type="hidden" name="frm_xss" id="frm_xss" value=<!--[$smarty.session.form_xss]--> />
        </div>
    </div>                      
</form>