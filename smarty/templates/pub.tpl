<!--[dmm_template_static_content template_name=$smarty.template language=$smarty.session.language assign='static_content']-->
<div class="large-8 medium-10 small-12 columns" style="margin-top: 20px; /* for allowing space below navigation bar */">
<!--[if $debug]--><span style="color:red;"><!--[$smarty.template]--></span><!--[/if]-->    <div class="pub_banner">
    <a href="<!--[if $ispreview]-->/preview-pub-<!--[else]-->/read-<!--[/if]--><!--[$this_pub.pub_slug|escape]-->/issue-<!--[$this_pub.pub_issue|escape]-->">
        <!--[if $this_pub.pub_issue_logo]--><div class="pub_issue_logo" style="background:transparent url('/<!--[$default_img_path]--><!--[$this_pub.pub_issue_logo]-->');">&nbsp;</div><!--[/if]-->
        <h1 class="pub_banner"><strong><!--[$this_pub.pub_name|escape]--></strong></h1>
        <h5 class="pub_banner"><!--[$this_pub.pub_mote|escape]--></h5>
        <p class="pub_banner"><!--[$static_content.label1|escape]--> <!--[$this_pub.pub_issue|escape]--> - <!--[$this_pub.pub_issue_tstamp|date_format:"%A, %B %e, %Y"|escape]--></p>
    </a>      
    </div>
    <dl class="accordion" data-accordion id='accordion'>
        <!--[foreach name=externo item=article from=$this_content]-->
            <dd class="accordion-navigation">
         <!-- This should go... 
                 It should be in the controler, not in the template... 
                 it is not an output funtion but a content retrieving function 
         -->
            <!--[dmm_article_image_handler assign='article_image' article_id=$article.article_id]-->
            <a href="#panel<!--[$article.article_id|escape]-->b">
              <!--[if $article_image[0].article_image_filename]-->
                <div class="pub_article_thumb" style="background-image:url('<!--[demimot_html_createthumb file="`$default_img_path``$article_image[0].article_image_filename`" naked=true height="100" link=false]-->')"></div>
              <!--[/if]-->
              <h2><!--[$article.article_title|escape]--></h2><h5><!--[$article.article_subtitle|escape]--></h5>
              <!--[if $article.article_source]--><!--[$static_content.label2|escape]--> <!--[$article.article_source|escape]--><!--[/if]-->
            </a>
            <div id="panel<!--[$article.article_id]-->b" class="content<!--[if $smarty.foreach.externo.first]--> active<!--[/if]-->" data-slug="panel<!--[$article.article_id]-->b">
              <!--[if $article_image[0].article_image_filename]-->
                <!--[include file="article_img.tpl"]-->
              <!--[/if]-->
              <!--[if $article.article_source]--><p><a href="/check-source-<!--[$article.article_pub_issue_id|escape]-->/article-<!--[$article.article_id|escape]-->" target="_blank"><!--[$static_content.label2|escape]--> <!--[$article.article_source|escape]--></a></p><!--[/if]-->
              <!--[p_tag_this string=$article.article_body|escape article=$article.article_id|escape]-->
              <!--[if $user_publications and not $ispreview]--><a href="#" class="button tiny">Demi-Mot</a><!--[/if]-->
            </div>
            </dd>
            <hr />
        <!--[/foreach]-->
    </dl>
<!--[if $debug]--><div><pre><!--[$this_content|var_dump]--></pre></div><!--[/if]-->
</div>