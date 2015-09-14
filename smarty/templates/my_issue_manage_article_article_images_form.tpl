<!--[if $debug]--><span style="color:red;"><!--[$smarty.template]--></span><!--[/if]--><!--[dmm_template_static_content template_name=$smarty.template language=$smarty.session.language assign='static_content']-->

<form id="frm_pub_manage_issue_articles_images" id="frm_pub_manage_issue_articles_images">
    <label for="frm_pub_issue_articles_images" class="left"><!--[$static_content.label01|escape]--></label>
    <select name="frm_pub_issue_articles_images" id="frm_pub_issue_articles_images" multiple  style="min-height:96px;" onchange="get_article_image_details(this.value);" disabled >
        <option value=""><!--[$static_content.label02|escape]--></option>
    </select>
</form>

<!--[include file="my_issue_article_image_upload_form.tpl"]-->