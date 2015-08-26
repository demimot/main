<!--[if $debug]--><!--[$smarty.template]--><!--[/if]--><form id="frm_edit_article_form" name="frm_edit_article_form" action="" method="post">
    <div class="row">
        <div class="large-12 columns">
            <h4>Article: <strong><!--[$this_article.article_title|escape]--></strong></h4>
            <!--[if $this_article.pub_issue]-->
            <h6>Pub: <strong><!--[$this_article.pub_name|escape]--></strong></h6>
            <h6>Issue: <strong><!--[$this_article.pub_issue|escape]--></strong></h6>
            <!--[if $this_article.article_deadline != '0000-00-00 00:00:00']-->
            <h6>Deadline: <strong><!--[$this_article.article_deadline|date_format:$smarty_date_format|escape]--></strong> </h6>
            <!--[/if]-->
            <!--[/if]-->
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label for="frm_article_title" class="left">Title:</label>
            <input type="text" class="validate[required]" name="frm_article_title" id="frm_article_title" placeholder="Type your article title here" value="<!--[$this_article.article_title|escape]-->" <!--[if $no_edit]-->readonly<!--[/if]-->>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label for="frm_article_subtitle" class="left">Subtitle:</label>
            <input type="text" class="validate[required]" name="frm_article_subtitle" id="frm_article_subtitle" placeholder="Type your article subtitle here" value="<!--[$this_article.article_subtitle|escape]-->" <!--[if $no_edit]-->readonly<!--[/if]-->>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns" >
          <label for="frm_article_body" class="left">Article body:</label>
            <textarea class="validate[required]" name="frm_article_body" id="frm_article_body" placeholder="Type your article body here" style="min-height: 240px;" <!--[if $no_edit]-->readonly<!--[/if]-->><!--[$this_article.article_body|escape]--></textarea>
          
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label for="frm_article_ready" class="left">Ready for publication:&nbsp;&nbsp;</label>
            <input type="checkbox" name="frm_article_ready" id="frm_article_ready" value="<!--[$this_article.article_ready]-->|escape" <!--[if $this_article.article_ready]--> checked='checked'<!--[/if]--> <!--[if $no_edit]-->disabled<!--[/if]-->>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <input class="button small large-1" type="submit" value="Save" <!--[if $no_edit]-->disabled<!--[/if]--> />
            <input type="hidden" name="frm_submit" value=10 />
            <!--[if isset($smarty.get.artid)]--><input type="hidden"   name="frm_article_id" value=<!--[$smarty.get.artid]--> /><!--[/if]-->
            <!--[if $this_article.article_pub_issue_id]--><input type="hidden" name="frm_pub_issue_id" value=<!--[$this_article.article_pub_issue_id|escape]--> /><!--[/if]-->
            <input type="hidden" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
        </div>
    </div>
</form>