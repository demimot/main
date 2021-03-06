<!--[dmm_template_static_content template_name=$smarty.template language=$smarty.session.language assign='static_content']--><div class="large-8 medium-10 small-12 columns" style="margin-top: 20px;"><!-- for allowing space below navigation bar -->
<!--[if $debug]--><span style="color:red;"><!--[$smarty.template]--></span><!--[/if]-->
    <div class="row">
        <div class="panel">
            <div class="row">
                <div class="large-12 columns">
                    <div class="left">
                    <h1><!--[$this_issue.pub_name|escape]--> - <!--[$static_content.label1|escape]--> <!--[$this_issue.pub_issue|escape]--></h1>
                    <h4><!--[$this_issue.pub_issue_tstamp|date_format:"%A, %B %e, %Y"|escape]--> <!--[$static_content.label2|escape]--></h4>
                    <!--[if not $this_issue.pub_issue_published]-->
                    <a href="/preview-pub-<!--[$this_issue.pub_slug|escape]-->/issue-<!--[$this_issue.pub_issue|escape]-->" class="button tiny" target="_blank"><!--[$static_content.label9|escape]--></a>
                    <!--[else]-->
                    <a href="/read-<!--[$this_issue.pub_slug|escape]-->/issue-<!--[$this_issue.pub_issue|escape]-->" class="button tiny" target="_blank"><!--[$static_content.label10|escape]--></a>
                    <!--[/if]-->
                    </div>
                    <div class="right" style="margin-right:10px">
                        <!--[if not $this_issue.pub_issue_published]-->
                             <!-- in fact this if will wrap almost the whole page...
                             I will load a different template for unpublished and for published issues. 
                             Published issues will have no forms except 
                             * one to request removal of issue 
                             * one to reuqest removal of article
                             Both for removals based on judicial decisions ONLY 
                             and depending on our approval (notification of court decision)
                             -->
<!--[include file="my_issue_publish_issue_form.tpl"]-->
                        <!--[else]-->
                            <p><!--[$static_content.label3|escape]--></p> 
                        <!--[/if]-->
                    </div>
                </div>
            </div>
        </div>
    </div> 
    <!--[if $this_issue.issue_sections]-->
    <div class="row">
        <div class="panel callout large-12 columns">
            <h4><!--[$static_content.label4|escape]--></h4>
            <dl class="tabs" data-tab>
            <!--[foreach name=externo item=issue_section from=$this_issue.issue_sections]-->
                <dd class="tab-title<!--[if $smarty.foreach.externo.first]--> active<!--[/if]-->"><a href="#panel<!--[$issue_section.section_id]-->"><!--[$issue_section.section_name]--></a></dd>
            <!--[/foreach]-->
            </dl>
            <div class="tabs-content">
                <!--[foreach name=externo item=issue_section from=$this_issue.issue_sections]-->
                <div class="content<!--[if $smarty.foreach.externo.first]--> active<!--[/if]-->" id="panel<!--[$issue_section.section_id]-->" style="background-color:white;width:100%;">
                    <div class="dmm-tab-block">
<!--[include file="my_issue_sections_content_form.tpl"]-->
                    </div>    
                </div>
                <!--[/foreach]-->
            </div>
        </div>
    </div>
    <!--[/if]-->
    <!--[foreach item=article_section from=$this_issue.issue_articles]-->
        <!--[if $article_section.section_id|default:"NULL"=="NULL"]--><!--[assign var="nosection" value="1"]--><!--[/if]-->
    <!--[/foreach]-->
    <!--[if $nosection]-->
    <div class="row">
        <div class="panel large-12 columns">
            <h4><!--[$static_content.label5|escape]--></h4>
<!--[include file="my_issue_no_section_content_form.tpl"]-->
        </div>
    </div>
    <!--[/if]-->
    <div class="row">
        <div class="panel callout large-12 columns">
            <h4><!--[$static_content.label6|escape]--></h4>
            <p><!--[$static_content.label7|escape]--></p>
            <div class="large-4 columns">
<!--[include file="my_issue_sections_manage_content_form.tpl"]-->
            </div>
            <div class="large-4 columns">
<!--[include file="my_issue_sections_manage_content.tpl"]-->
            </div>
            <div class="large-4 columns">
<!--[include file="my_issue_manage_article_article_images_form.tpl"]-->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="panel callout large-12 columns">
            <h4><!--[$static_content.label8|escape]--></h4>
            <div class="row">
            <div class="large-4 columns" >
<!--[include file="my_issue_css_form.tpl"]-->
            </div>
            <div class="large-4 columns">
<!--[include file="my_issue_sections_form.tpl"]-->
            </div>
            <div class="large-4 columns" >
<!--[include file="my_issue_cover_upload_form.tpl"]-->
<!--[include file="my_issue_logo_upload_form.tpl"]-->
            </div>
            </div>
        </div>
    </div>
<!--[if isset($smarty.get.debug)]-->
    <div class="row">
        <div class="panel  large-12 columns">
            <div class="row">
                <div class="large-12 columns">
                    <h4><!--[$this_issue.pub_name|escape]--> Issue: <!--[$this_issue.pub_issue|escape]--></h4>
                    <h6><!--[$smarty.template]--> - smarty: <!--[$smarty.version]--></h6>
                    <h6>$this_issue</h6>
                    <pre><!--[$this_issue|@var_dump]--></pre>
                </div>
            </div>
        </div>
    </div>
<!--[/if]-->
</div>