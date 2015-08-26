<!--[if $debug]--><!--[$smarty.template]--><!--[/if]-->
<h4 class="subheader">My Articles:</h4>
<a href="/create-article" class="button">New Article</a>
<!--[if $your_unpublished_articles]-->
<div class="panel callout">
<h6 class="subheader">Unpublished articles:</h6>
<ul class="no-bullet">
  <!--[foreach name=externo item=unpub_article from=$your_unpublished_articles]-->
    <li><small><a href="/edit-article-<!--[$unpub_article.article_id|escape]-->"><!--[$unpub_article.article_title|escape]--> <!--[if $unpub_article.article_source]--> - <!--[$unpub_article.article_source|escape]--> - issue: <!--[$unpub_article.pub_issue|escape]--><!--[/if]--></a></small></li>
  <!--[/foreach]-->
</ul>
</div>
<!--[/if]-->
<!--[if $your_published_articles]-->
<div class="panel">
<h6 class="subheader">Published articles:</h6>
<ul class="no-bullet">
  <!--[foreach name=externo item=pub_article from=$your_published_articles]-->
    <li><small><a href="/adm-article-<!--[$pub_article.article_id|escape]-->"><!--[$pub_article.article_title|escape]--> - <!--[$pub_article.article_source|escape]--></a></small></li>
  <!--[/foreach]-->
</ul>
</div>
<!--[/if]-->