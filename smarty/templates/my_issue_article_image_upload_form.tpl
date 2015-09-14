<!--[if $debug]--><span style="color:red;"><!--[$smarty.template]--></span><!--[/if]--><!--[dmm_template_static_content template_name=$smarty.template language=$smarty.session.language assign='static_content']-->
        <form id="frm_issue_article_image_form" name="frm_issue_article_image_form" action="" method="post" enctype="multipart/form-data">
            <label for="frm_image_upload" class="left"><!--[$static_content.label01|escape]--> </label>
            <!--[if $smarty.get.message]--><label for="frm_image_upload" class="left"><span style="color:red !important;"><!--[$smarty.get.message|escape]--></span></label><!--[/if]-->
            <input class="file validate[required]" name="frm_image_upload" id="frm_image_upload" placeholder="Logo filename" type="file" disabled>
            <div id="article-details">
            <div class="row">
                <div class="large-12 columns">
                    <label for="frm_image_caption" class="left"><!--[$static_content.label02|escape]--></label>
                    <input type="text" name="frm_image_caption" id="frm_image_caption" placeholder="<!--[$static_content.label10|escape]-->" disabled>
                </div>
            </div>
            <div class="row">
                <div class="large-6 columns">
                    <label for="frm_image_copyright" class="left"><!--[$static_content.label03|escape]--></label>
                    <input type="text" name="frm_image_copyright" id="frm_image_copyright" placeholder="<!--[$static_content.label11|escape]-->" disabled>
                </div>
                <div class="large-6 columns">
                    <label for="frm_image_weight" class="left">Peso:</label>
                    <select name="frm_image_weight" id="frm_image_weight" disabled>
                        <option value="0">0 - <!--[$static_content.label06|escape]--></option> 
                        <option value="1" selected="selected">1 - <!--[$static_content.label07|escape]--></option>
                        <option value="2">2 - <!--[$static_content.label08|escape]--></option>
                   </select>
                   <input type="hidden" id="save-label" name="save-label" value="<!--[$static_content.label04|escape]-->">
                   <input type="hidden" id="delete-label" name="delete-label" value="<!--[$static_content.label09|escape]-->">
                </div>
            </div>
            </div>
            <input class="button small large-5 left" id="btn_submit" name="btn_submit" type="submit" value="<!--[$static_content.label04|escape]-->" disabled />
            <input class="button small large-5 right" id="btn_cancel" name="btn_cancel" type="button" value="<!--[$static_content.label05|escape]-->" onclick="reset_frm_pub_issue_section_articles_form();reset_frm_issue_article_image_form();" disabled />
            <input type="hidden" id="frm_image_verb" name="frm_image_verb" value="add" />
            <input type="hidden" id="frm_submit" name="frm_submit" value=56 />
            <input type="hidden" id="frm_article_image_id" name="frm_article_image_id" />
            <input type="hidden" id="frm_article_id" name="frm_article_id" value="" />
            <!--[if $this_issue.pub_issue_id]--><input type="hidden" name="frm_pub_issue_id" value=<!--[$this_issue.pub_issue_id|escape]--> /><!--[/if]-->
            <input type="hidden" id="frm_xss" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
        </form>