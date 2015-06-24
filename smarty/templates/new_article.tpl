<div class="large-8 medium-10 small-12 columns" style="margin-top: 40px; /* for allowing space below navigation bar */">
<form action="/index.php" method="post">
    <div class="row">
        <div class="large-12 columns">
            <h5>Article</h5>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label for="left-label" class="left">Title:</label>
            <input type="text" name="frm_article_title" id="frm_article_title" placeholder="Type your article title here" value="<!--[$this_article.article_title|escape]-->">
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label for="left-label" class="left">Subtitle:</label>
            <input type="text" name="frm_article_subtitle" id="frm_article_subtitle" placeholder="Type your article subtitle here" value="<!--[$this_article.article_subtitle|escape]-->">
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns" >
          <label for="left-label" class="left">Article body:</label>
            <textarea name="frm_article_body" id="frm_article_body" placeholder="Type your article body here" style="min-height: 240px;"><!--[$this_article.article_body|escape]--></textarea>
          
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label for="left-label" class="left">Ready for publication:&nbsp;&nbsp;</label>
            <input type="checkbox" name="frm_article_ready" id="frm_article_ready" value="<!--[$this_article.article_ready]-->" <!--[if $this_article.article_ready]--> checked='checked'<!--[/if]-->>
        </div>
    </div>
    <!--[if $this_article.article_deadline != '0000-00-00 00:00:00']--><div class="row">
        <div class="large-12 columns">
            <label for="left-label" class="left">Article deadline: <strong><!--[$this_article.article_deadline|escape]--></strong> </label>
        </div>
    </div><!--[/if]-->
    <div class="row">
        <div class="large-12 columns">
            <input class="button small large-1" type="submit" value="Save" <!--[if $no_edit]-->disabled<!--[/if]--> />
            <input type="hidden" name="frm_submit" value=10 />
            <!--[if isset($smarty.get.artid)]--><input type="hidden"   name="frm_article_id" value=<!--[$smarty.get.artid]--> /><!--[/if]-->
            <!--[if $this_article.article_pub_issue_id]--><input type="hidden" name="frm_article_pub_issue_id" value=<!--[$this_article.article_pub_issue_id]--> /><!--[/if]-->
            <input type="hidden" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
        </div>
    </div>
</form>
</div>