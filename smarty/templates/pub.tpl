<div class="large-8 medium-10 small-12 columns" style="margin-top: 40px; /* for allowing space below navigation bar */">
    <div class="pub_banner">
    <a href="/read-<!--[$this_pub.pub_slug|escape]-->/issue-<!--[$this_pub.pub_issue|escape]-->">
        <!--[if $this_pub.pub_issue_logo]--><div class="pub_issue_logo" style="background:transparent url('/<!--[$default_img_path]--><!--[$this_pub.pub_issue_logo]-->');">&nbsp;</div><!--[/if]-->
        <h1 class="pub_banner"><strong><!--[$this_pub.pub_name|escape]--></strong></h1>
        <h5 class="pub_banner"><!--[$this_pub.pub_mote|escape]--></h5>
        <p class="pub_banner">issue: <!--[$this_pub.pub_issue|escape]--> - <!--[$this_pub.pub_issue_tstamp|date_format:"%A, %B %e, %Y"|escape]--></p>
    </a>      
    </div>
    <dl class="accordion" data-accordion id='accordion'>
        <!--[foreach name=externo item=article from=$this_content]-->
            <dd class="accordion-navigation">
            <!--[dmm_article_image_handler assign='article_image' article_id=$article.article_id ]-->
         <!-- This should go... 
                 It should be in the controler, not in the template... 
                 it is not an output funtion but a content retrieving function 
         --><!--[dmm_article_image_handler assign='article_image' article_id=$article.article_id ]-->
            <a href="#panel<!--[$article.article_id|escape]-->b">
              <!--[if $article_image[0].article_image_filename]-->
                <div class="pub_article_thumb" style="background-image:url('<!--[demimot_html_createthumb file="`$default_img_path``$article_image[0].article_image_filename`" naked=true height="100" link=false]-->')"></div>
              <!--[/if]-->
              <h2><!--[$article.article_title|escape]--></h2><h5><!--[$article.article_subtitle|escape]--></h5>
              <!--[if $article.article_source]-->source: <!--[$article.article_source|escape]--><!--[/if]-->
            </a>
            <div id="panel<!--[$article.article_id]-->b" class="content<!--[if $smarty.foreach.externo.first]--> active<!--[/if]-->" data-slug="panel<!--[$article.article_id]-->b">
              <!--[if $article_image[0].article_image_filename]-->
                <!--[include file="article_img.tpl"]-->
              <!--[/if]-->
              <!--[if $article.article_source]--><p><a href="/check-source-<!--[$article.article_pub_issue_id|escape]-->/article-<!--[$article.article_id|escape]-->" target="_blank">source: <!--[$article.article_source|escape]--></a></p><!--[/if]-->
              <!--[p_tag_this string=$article.article_body|escape article=$article.article_id|escape]-->
              <!--[if $user_publications]--><a href="#" class="button tiny">Demimotize</a><!--[/if]-->
            </div>
            </dd>
            <hr />
        <!--[/foreach]-->
    </dl>
</div>