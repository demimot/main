<!--[if $debug]--><span style="color:red;"><!--[$smarty.template]--></span><!--[/if]--><!--[dmm_template_static_content template_name=$smarty.template language=$smarty.session.language assign='static_content']-->
    <form id="frm_article_images_list_form" name="frm_article_images_list_form" action="" >
       <label for="frm_article_images_list" class="left"><!--[$static_content.label1|escape]--></label>
        <select multiple id="frm_article_images_list" name="frm_article_images_list" style="min-height:300px;" onchange="set_frm_article_image_form();" <!--[if (not $this_article.article_images) or $no_edit]-->disabled<!--[/if]-->>
            <!--[if not $this_article.article_images]--><option><!--[$static_content.label2|escape]--></option><!--[/if]-->
            <!--[foreach name=externo item=article_image from=$this_article.article_images]-->
            <option data-image-weight="<!--[$article_image.article_image_weight|escape]-->" data-image-caption="<!--[$article_image.article_image_caption|escape]-->" data-image-credits="<!--[$article_image.article_image_credits]-->" value="<!--[$article_image.article_image_id|escape]-->"><!--[$article_image.article_image_filename|escape]--></option>
            <!--[/foreach]-->
        </select>
    </form>