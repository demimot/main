<div class="large-8 medium-10 small-12 columns" style="margin-top: 20px; /* for allowing space below navigation bar */"><!--[dmm_template_static_content template_name=$smarty.template language=$smarty.session.language assign='static_content']-->
<!--[if $debug]--><span style="color:red;"><!--[$smarty.template]--></span><!--[/if]-->
    <div class="panel<!--[if !$this_article.pub_issue_published]--> callout<!--[/if]-->">
<!--[include file="my_article_text_form.tpl"]-->
    </div>
<!--[if isset($this_article.article_id)]-->
    <div class="panel">
        <div class="row">
            <div class="large-6 columns">
                <h4><!--[$static_content.images|escape]--></h4>
                <p><!--[$static_content.discl1|escape]--><br /><!--[$static_content.discl2|escape]--><br /><!--[$static_content.discl3|escape]--></p>

<!--[include file="my_article_image_upload_form.tpl"]-->
            </div>
            <div class="large-6 columns">
<!--[include file="my_article_image_list_form.tpl"]-->
            </div>
        </div>
         <!-- This should go... 
                 It should be in the controler, not in the template... 
                 it is not an output funtion but a content retrieving function 
         -->
         <!--[dmm_article_image_handler assign='article_image' article_id=$this_article.article_id]-->    
    <!--[if $article_image[0].article_image_filename]-->
        <div class="row">
            <div class="large-8 columns">
<!--[include file="article_img.tpl"]-->
            </div>
        </div>
    <!--[/if]-->
    </div>
<!--[/if]-->
<!--[if isset($smarty.get.debug)]-->
    <div class="row">
        <div class="panel  large-12 columns">
            <div class="row">
                <div class="large-12 columns">
                    <h5>Pub: <!--[$this_article.pub_name|escape]--></h5>
                    <h5>Issue: <!--[$this_article.pub_issue|escape]--></h5	>
                    <h4>Title:<!--[$this_article.article_title|escape]--> id: <!--[$this_article.article_id|escape]--></h4>
                    <h6><!--[$smarty.template]--> - smarty: <!--[$smarty.version]--></h6>
                    <h6>$this_article</h6>
                    <pre><!--[$this_article|@var_dump]--></pre>
                </div>
            </div>
        </div>
    </div>
<!--[/if]-->
</div>
