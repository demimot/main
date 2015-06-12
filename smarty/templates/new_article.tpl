<form action="/index.php" method="post">
    <div class="row">
        <div class="large-12 columns">
            <h5>Login na DemiMot</h5>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label for="left-label" class="left inline">Title:</label>
            <input type="text" name="frm_article_title" id="frm_article_title" placeholder="Type your article title here">
        </div>
    </div>
  <div class="row">
    <div class="large-12 columns" name="frm_article_body" id="frm_article_body">
      <label>Article body:
        <textarea placeholder="Type your article body here"></textarea>
      </label>
    </div>
  </div>
    <div class="row">
        <div class="large-12 columns">
            <input class="button small large-1" type="submit" value="Save" /><input type="hidden" name="frm_submit" value=10 />
            <!--[if isset($smarty.get.artid)]--><input type="hidden"   name="frm_pub" value=<!--[$smarty.get.artid]--> /><!--[/if]-->
            <!--[if isset($smarty.get.apiid)]--><input type="hidden" name="frm_issue" value=<!--[$smarty.get.apiid]--> /><!--[/if]-->
            <input type="hidden" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
        </div>
    </div>
</form>