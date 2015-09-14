<!--[if $debug]--><span style="color:red;"><!--[$smarty.template]--></span><!--[/if]--><!--[dmm_template_static_content template_name=$smarty.template language=$smarty.session.language assign='static_content']-->
        <form id="frm_article_image_form" name="frm_article_image_form" action="" method="post" enctype="multipart/form-data">
            <label for="frm_image_upload" class="left"><!--[$static_content.label1|escape]--> </label>
            <!--[if $smarty.get.message]--><label for="frm_image_upload" class="left"><span style="color:red !important;"><!--[$smarty.get.message|escape]--></span></label><!--[/if]-->
            <input class="file validate[required]" name="frm_image_upload" id="frm_image_upload" placeholder="Logo filename" type="file" <!--[if $no_edit]-->disabled<!--[/if]-->>
            <div class="row">
                <div class="large-12 columns">
                    <label for="frm_image_caption" class="left"><!--[$static_content.label2|escape]--></label>
                    <input type="text" name="frm_image_caption" id="frm_image_caption" placeholder="Type your image caption here" <!--[if $no_edit]-->readonly<!--[/if]-->>
                </div>
            </div>
            <div class="row">
                <div class="large-8 columns">
                    <label for="frm_image_copyright" class="left"><!--[$static_content.label3|escape]--></label>
                    <input type="text" name="frm_image_copyright" id="frm_image_copyright" placeholder="Type your copyright info here" <!--[if $no_edit]-->readonly<!--[/if]-->>
                </div>
                <div class="large-4 columns">
                    <label for="frm_image_weight" class="left"><!--[$static_content.label4|escape]--></label>
                    <select name="frm_image_weight" id="frm_image_weight" <!--[if $no_edit]-->disabled<!--[/if]--> >
                        <option value="0">0 - <!--[$static_content.label5|escape]--></option> 
                        <option value="1" selected="selected">1 - <!--[$static_content.label6|escape]--></option>
                        <option value="2">2 - <!--[$static_content.label7|escape]--></option>
                   </select>
                </div>
            </div>
            <input class="button small large-5 left" type="submit" value="<!--[$static_content.label8|escape]-->" <!--[if $no_edit]-->disabled<!--[/if]--> />
            <input class="button small large-5 right" id="btn_section_cancel" name="btn_section_cancel" type="button" value="<!--[$static_content.label9|escape]-->" onclick="reset_frm_article_image_form();" <!--[if $no_edit]-->disabled<!--[/if]--> />
            <input type="hidden" id="frm_image_verb" name="frm_image_verb" value="add" />
            <input type="hidden" id="frm_submit" name="frm_submit" value=11 />
            <input type="hidden" id="frm_article_image_id" name="frm_article_image_id" />
            <!--[if isset($this_article.article_id)]--><input type="hidden"   name="frm_article_id" value=<!--[$this_article.article_id]--> /><!--[/if]-->
            <!--[if $this_article.article_pub_issue_id]--><input type="hidden" name="frm_pub_issue_id" value=<!--[$this_article.article_pub_issue_id|escape]--> /><!--[/if]-->
            <input type="hidden" id="frm_xss" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
        </form>