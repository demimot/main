<div class="large-8 medium-10 small-12 columns" style="margin-top: 40px; /* for allowing space below navigation bar */">
<!--[if $debug]--><!--[$smarty.template]--><!--[/if]-->
    <div class="panel<!--[if !$this_article.pub_issue_published]--> callout<!--[/if]-->">
<!--[include file="my_article_text_form.tpl"]-->
    </div>
<!--[if isset($this_article.article_id)]-->
    <div class="panel">
        <div class="row">
            <div class="large-4 columns">
                <h4>Article images:</h4>
                <p>Make sure you own or have the right to publish the image(s).<br />Demi Mot is not responsible for your content<br />Read the terms and conditions...</p>

<!--[include file="my_article_image_upload_form.tpl"]-->
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
</div>
