<!--[if $debug]--><span style="color:red;"><!--[$smarty.template]--></span><!--[/if]--><!--[dmm_template_static_content template_name=$smarty.template language=$smarty.session.language assign='static_content']-->
<form id="frm_pub_issue_section_articles" id="frm_pub_issue_section_articles">
    <label for="frm_articles" class="left"><!--[$static_content.label1|escape]--></label>
    <select name="frm_articles" id="frm_articles" multiple  style="min-height:200px;" onchange="set_frm_pub_issue_section_articles_form();set_frm_issue_article_image_form();" >
    <!--[assign var="flag" value="0"]-->
    <!--[foreach name=externo item=section_article from=$this_issue.issue_articles]-->
        <option data-use-images="<!--[$section_article.use_article_images|escape]-->"data-deadline="<!--[$section_article.article_deadline|escape]-->" data-weight="<!--[$section_article.article_weight|escape]-->" data-author="<!--[$section_article.article_author_id|escape]-->" data-section="<!--[$section_article.section_id|escape]-->" value="<!--[$section_article.article_id|escape]-->"><!--[$section_article.article_title]--></option>
        <!--[assign var="flag" value="1"]-->
    <!--[/foreach]-->
    <!--[if not $flag]-->    <option value=""><!--[$static_content.label2|escape]--></option><!--[/if]-->
    </select>
</form>
<form id="frm_pub_manage_articles_images" id="frm_pub_manage_articles_images" method="post" action="">
    <div class="row">
        <div class="large-12 columns">
            <label for="frm_pub_articles_images" class="left"><!--[$static_content.label01|escape]--></label>
            <select name="frm_pub_articles_images" id="frm_pub_articles_images" multiple  style="min-height:96px;" disabled >
                <option value=""><!--[$static_content.label02|escape]--></option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <input type="checkbox" name="frm_use_article_images" id="frm_use_article_images" class="left" onchange="enable_use_image_button();"disabled>
            <label for="frm_use_article_images" class="left"><!--[$static_content.label03|escape]-->&nbsp;&nbsp;</label>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <input class="button small large-5 left" id="btn_confirm_article_images"  name="btn_confirm_article_images" type="submit" value="<!--[$static_content.label05|escape]-->" disabled />
            <input class="button small large-5 right" id="btn_cancel_article_images" name="btn_cancel_article_images" type="button" value="<!--[$static_content.label06|escape]-->" onclick="reset_frm_pub_issue_section_articles_form();reset_frm_issue_article_image_form();" disabled />
            <input type="hidden" name="frm_submit" id="frm_submit" value=55 />
            <input type="hidden" name="frm_pub_issue_id" id="frm_pub_issue_id" value=<!--[$this_issue.pub_issue_id]--> />
            <input type="hidden" name="frm_pub_issue_article_id" id="frm_pub_issue_article_id" value=""/>
            <input type="hidden" name="frm_article_images_verb" id="frm_article_images_verb" value="confirm">
            <input type="hidden" name="frm_xss" id="frm_xss" value=<!--[$smarty.session.form_xss]--> />
        </div>
    </div>
</form>
