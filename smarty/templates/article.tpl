<div class="large-8 medium-10 small-12 columns" style="margin-top: 40px; /* for allowing space below navigation bar */">
    <!--[if $debug]--><!--[$smarty.template]--><!--[/if]-->
    <div class="pub_banner">
    <a href="/read-<!--[$this_pub.pub_slug|escape]-->/issue-<!--[$this_pub.pub_issue|escape]-->">
        <!--[if $this_pub.pub_issue_logo]--><div class="pub_issue_logo" style="background:transparent url('/<!--[$default_img_path]--><!--[$this_pub.pub_issue_logo]-->');">&nbsp;</div><!--[/if]-->
        <h1 class="pub_banner"><strong><!--[$this_pub.pub_name|escape]--></strong></h1>
        <h5 class="pub_banner"><!--[$this_pub.pub_mote|escape]--></h5>
        <p class="pub_banner">issue: <!--[$this_pub.pub_issue|escape]--> - <!--[$this_pub.pub_issue_tstamp|date_format:"%A, %B %e, %Y"|escape]--></p>
    </a>      
    </div>
    <!--[dmm_article_image_handler assign='article_image' article_id=$this_content.article_id ]--><!-- This should go... It should be in the controler, not in the template... it is not an output funtion but a content retrieving function -->
    <div class="panel">
        <h2><!--[$this_content.article_title|escape]--></h2><h5><!--[$this_content.article_subtitle|escape]--></h5>
            <!--[if $this_content.article_source]--><p>source: <!--[$this_content.article_source|escape]--></p><!--[/if]-->
    </div>
    <div id="panel<!--[$this_content.article_id]-->b" class="content" data-slug="panel<!--[$this_content.article_id]-->b">
      <!--[if $article_image[0].article_image_filename]-->
        <!--[include file="article_img.tpl"]-->
      <!--[/if]-->
      <!--[if $this_content.article_source]--><p><a href="/check-source-<!--[$this_content.article_pub_issue_id|escape]-->/article-<!--[$this_content.article_id|escape]-->" target="_blank">source: <!--[$this_content.article_source|escape]--></a></p><!--[/if]-->
      <!--[p_tag_this string=$this_content.article_body|escape article=$this_content.article_id|escape]-->
      <!--[if $user_publications]--><a href="#" class="button tiny">Demimotize</a><!--[/if]-->
    </div>
</div>