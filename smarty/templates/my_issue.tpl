<div class="large-8 medium-10 small-12 columns" style="margin-top: 40px;"><!-- for allowing space below navigation bar -->
    <div class="row">
        <div class="panel">
            <div class="row">
                <div class="large-12 columns">
                    <div class="left">
                    <h1><!--[$this_issue.pub_name|escape]--> - Issue: <!--[$this_issue.pub_issue|escape]--></h1>
                    <h4><!--[$this_issue.pub_issue_tstamp|date_format:"%A, %B %e, %Y"|escape]--> (creation date)</h4>
                    <h6><!--[$smarty.template]--></h6>
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
                            <p>Published</p> 
                            
                            
                             <!-- in fact this if will wrap almost the whole page...
                             I will load a different template for unpublished and for published issues. 
                             Published issues will have no forms except 
                             * one to request removal of issue 
                             * one to reuqest removal of article
                             Both for removals based on judicial decisions ONLY 
                             and depending on our approval (notification of court decision)
                             -->
                            
                        <!--[/if]-->
                    </div>
                </div>
            </div>
        </div>
    </div> 
    <!--[if $this_issue.issue_sections]-->
<!--[include file="my_issue_sections_content.tpl"]-->
    <!--[/if]-->
    <!--[foreach item=article_section from=$this_issue.issue_articles]-->
        <!--[if $article_section.section_id|default:"NULL"=="NULL"]--><!--[assign var="nosection" value="1"]--><!--[/if]-->
    <!--[/foreach]-->
    <!--[if $nosection]-->
<!--[include file="my_issue_no_section_content.tpl"]--> 
    <!--[/if]-->   
    <div class="row">
        <div class="panel callout">
            <div class="row">
                <div class="large-12 columns">
                    <h4>Issue General Settings</h4>
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
    </div>
    <div class="row">
        <div class="panel">
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
</div>