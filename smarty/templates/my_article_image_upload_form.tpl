<!--[if $debug]--><!--[$smarty.template]--><!--[/if]-->
        <form id="frm_article_image_form" name="frm_pub_logo_form" action="" method="post" enctype="multipart/form-data">
            <label for="frm_image_upload" class="left">Select image: <!--[$this_publication.pub_logo|escape]--></label>
            <!--[if $smarty.get.message]--><label for="frm_image_upload" class="left"><span style="color:red !important;"><!--[$smarty.get.message|escape]--></span></label><!--[/if]-->
            <input class="file validate[required]" name="frm_image_upload" id="frm_image_upload" placeholder="Logo filename" type="file" <!--[if $no_edit]-->disabled<!--[/if]-->>
            <div class="row">
                <div class="large-12 columns">
                    <label for="frm_image_caption" class="left">Image caption:</label>
                    <input type="text" name="frm_image_caption" id="frm_image_caption" placeholder="Type your image caption here" <!--[if $no_edit]-->readonly<!--[/if]-->>
                </div>
            </div>
            <div class="row">
                <div class="large-8 columns">
                    <label for="frm_image_copyright" class="left">Image copyright:</label>
                    <input type="text" name="frm_image_copyright" id="frm_image_copyright" placeholder="Type your copyright info here" <!--[if $no_edit]-->readonly<!--[/if]-->>
                </div>
                <div class="large-4 columns">
                    <label for="frm_image_weight" class="left">Weight:</label>
                    <input type="text" name="frm_image_weight" id="frm_image_weight" placeholder="default = 0" <!--[if $no_edit]-->readonly<!--[/if]-->>
                </div>
            </div>
            <input class="button small large-4 left" type="submit" value="Save image" <!--[if $no_edit]-->disabled<!--[/if]--> />
            <input type="hidden" name="frm_submit" value=11 />
            <!--[if isset($this_article.article_id)]--><input type="hidden"   name="frm_article_id" value=<!--[$this_article.article_id]--> /><!--[/if]-->
            <input type="hidden" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
        </form>