<!--[if $debug]--><span style="color:red;"><!--[$smarty.template]--></span><!--[/if]--><!--[dmm_template_static_content template_name=$smarty.template language=$smarty.session.language assign='static_content']-->
<h4 class="subheader"><!--[$static_content.my_articles|escape]--></h4>
<a href="/create-article" class="button"><!--[$static_content.new_article|escape]--></a>
<!--[if $your_unpublished_articles]-->
<div class="panel callout">
<h6 class="subheader"><!--[$static_content.unpub_articles|escape]--></h6>
<ul class="no-bullet">
  <!--[foreach name=externo item=unpub_article from=$your_unpublished_articles]-->
    <li><small><a href="/edit-article-<!--[$unpub_article.article_id|escape]-->"><!--[$unpub_article.article_title|escape]--> <!--[if $unpub_article.article_source]--> - <!--[$unpub_article.article_source|escape]--><!--[if $unpub_article.pub_issue]--> - <!--[$static_content.issue|escape]--> <!--[$unpub_article.pub_issue|escape]--><!--[else]--> - <span style="color:red;"><!--[$static_content.label1|escape]--></span><!--[/if]--><!--[else]--> - <span style="color:red;"><!--[$static_content.label1|escape]--></span><!--[/if]--></a></small></li>
  <!--[/foreach]-->
</ul>
</div>
<!--[/if]-->
<!--[if $your_published_articles]-->
<div class="panel">
<h6 class="subheader"><!--[$static_content.pub_articles|escape]--></h6>
<ul class="no-bullet">
  <!--[foreach name=externo item=pub_article from=$your_published_articles]-->
    <li><small><a href="/adm-article-<!--[$pub_article.article_id|escape]-->"><!--[$pub_article.article_title|escape]--> - <!--[$pub_article.article_source|escape]--></a></small></li>
  <!--[/foreach]-->
</ul>
</div>
<!--[/if]-->