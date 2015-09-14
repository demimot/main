<!--[if $debug]--><span style="color:red;"><!--[$smarty.template]--></span><!--[/if]--><!--[dmm_template_static_content template_name=$smarty.template language=$smarty.session.language assign='static_content']-->
<form id="frm_edit_article_form" name="frm_edit_article_form" action="" method="post">
    <div class="row">
        <div class="large-12 columns">
            <h4><!--[$static_content.label1|escape]--> <strong><!--[$this_article.article_title|escape]--></strong></h4>
            <!--[if $this_article.pub_issue]-->
            <h6><!--[$static_content.label2|escape]--> <strong><!--[$this_article.pub_name|escape]--></strong></h6>
            <h6><!--[$static_content.label3|escape]--> <strong><!--[$this_article.pub_issue|escape]--></strong></h6>
            <!--[if $this_article.article_deadline != '0000-00-00 00:00:00']-->
            <h6><!--[$static_content.label4|escape]--> <strong><!--[$this_article.article_deadline|date_format:$smarty_date_format|escape]--></strong> </h6>
            <!--[/if]-->
            <!--[/if]-->
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label for="frm_article_title" class="left"><!--[$static_content.label5|escape]--></label>
            <input type="text" class="validate[required]" name="frm_article_title" id="frm_article_title" placeholder="Type your article title here" value="<!--[$this_article.article_title|escape]-->" <!--[if $no_edit]-->readonly<!--[/if]-->>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label for="frm_article_subtitle" class="left"><!--[$static_content.label6|escape]--></label>
            <input type="text" class="validate[required]" name="frm_article_subtitle" id="frm_article_subtitle" placeholder="Type your article subtitle here" value="<!--[$this_article.article_subtitle|escape]-->" <!--[if $no_edit]-->readonly<!--[/if]-->>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns" >
          <label for="frm_article_body" class="left"><!--[$static_content.label7|escape]--></label>
            <textarea class="validate[required]" name="frm_article_body" id="frm_article_body" placeholder="Type your article body here" style="min-height: 240px;" <!--[if $no_edit]-->readonly<!--[/if]-->><!--[$this_article.article_body|escape]--></textarea>       
        </div>
    </div>
    <!--[if not $this_article.pub_issue]-->
    <div class="row">
        <div class="large-12 columns" >
            <label for="frm_article_pub" class="left" ><!--[$static_content.label10|escape]--></span></label><span class="has-tip tip-top noradius" data-width="210" title="<!--[$static_content.label13|escape]-->">&nbsp;?</span>
            <select id="frm_article_pub"  name="frm_article_pub" >
                <option value=0><!--[$static_content.label11|escape]--></option>
                <!--[foreach name=externo item=pub_contr from=$staff_of]-->
                <option value=<!--[$pub_contr.pub_id|escape]--> <!--[if $this_article['article_spontaneous'] eq $pub_contr.pub_id]-->selected=true<!--[/if]--> ><!--[$pub_contr.pub_name|escape]--></option>
                <!--[/foreach]-->
            </select>            
        </div>
    </div>
    <!--[/if]-->
    <div class="row">
        <div class="large-12 columns">
            <label for="frm_article_ready" class="left"><!--[$static_content.label8|escape]-->&nbsp;&nbsp;</label>
            <input type="checkbox" name="frm_article_ready" id="frm_article_ready" value="<!--[$this_article.article_ready]-->|escape" <!--[if $this_article.article_ready]--> checked='checked'<!--[/if]--> <!--[if $no_edit]-->disabled<!--[/if]-->>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <div class="large-12 columns">
            <input class="button large-3" type="submit" value="<!--[$static_content.label9|escape]-->" <!--[if $no_edit]-->disabled<!--[/if]--> />
            <input type="hidden" name="frm_submit" value=10 />
            <!--[if isset($smarty.get.artid)]--><input type="hidden" name="frm_article_id" value=<!--[$smarty.get.artid]--> /><!--[/if]-->
            <!--[if $this_article.article_pub_issue_id]--><input type="hidden" name="frm_pub_issue_id" value=<!--[$this_article.article_pub_issue_id|escape]--> /><!--[/if]-->
            <input type="hidden" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
            </div>
        </div>
    </div>
</form>