<!--[dmm_template_static_content template_name=$smarty.template language=$smarty.session.language assign='static_content']-->
<div class="large-8 medium-10 small-12 columns" style="margin-top: 20px;"><!-- for allowing space below navigation bar -->
<!--[if $debug]--><span style="color:red;"><!--[$smarty.template]--></span><!--[/if]-->
    <div class="row">
        <div class="panel<!--[if $smarty.get.pubid=='new']--> callout<!--[/if]-->">
            <div class="row">
                <div class="large-12 columns">
                    <h2><!--[$static_content.label1|escape]--> <!--[$this_publication.pub_name|escape]--></h2>
                    <!--[if $smarty.get.pubid neq 'new']--><p><!--[$static_content.label2|escape]--> <strong><!--[$dmm_user.user_nickname|escape]--></strong> <!--[$static_content.label3|escape]--> <strong><!--[$this_publication.pub_tstamp|escape]--></strong> </p><!--[/if]-->
                </div>
            </div>
<!--[include file="my_pub_basic_form.tpl"]-->
        </div>
    </div>
<!--[if $smarty.get.pubid neq 'new']-->
    <dl class="accordion" data-accordion>
    <!--[if $this_publication.pub_style neq 2]-->
        <dd class="accordion-navigation">
            <a href="#Issues"><h3><!--[$this_publication.pub_name|escape]--> <!--[$static_content.label4|escape]--></h3></a>
            <div id="Issues" class="content active">
                <div class="panel callout">
                    <div class="row">
                        <div class="large-4 columns left" >
<!--[include file="my_pub_unpublished_issues_form.tpl"]-->
                        </div>
                        <div class="large-4 columns left" >
<!--[include file="my_pub_published_issues_form.tpl"]-->
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-4 columns">
<!--[include file="my_pub_create_issue_form.tpl"]-->
                        </div>
                    </div>    
                </div>
            </div>
        </dd>
    <!--[else]-->
        <dd class="accordion-navigation">
            <a href="#articles"><h3><!--[$this_publication.pub_name|escape]--> La lalala lara</h3></a>
            <div id="articles" class="content active">
                <div class="panel callout">
                    <div class="row">
                        <div class="large-4 columns left" >
                            some form
                        </div>
                        <div class="large-4 columns left" >
                            some form
                        </div>
                        <div class="large-4 columns">
                            some form
                        </div>
                    </div>    
                </div>
            </div>
        </dd>
    <!--[/if]-->    
        <dd class="accordion-navigation">
            <a href="#defaults"><h3><!--[$this_publication.pub_name|escape]--> <!--[$static_content.label5|escape]--></h3></a>
            <div id="defaults" class="content"> 
                <div class="panel callout">
                    <div class="row">
                            <div class="large-4 columns left" >
<!--[include file="my_pub_css_form.tpl"]-->
                            </div>
                            <div class="large-4 columns left" >
<!--[include file="my_pub_sections_form.tpl"]-->
                            </div>
                            <!--[if $this_publication.pub_style neq 2]-->
                            <div class="large-4 columns left" >
<!--[include file="my_pub_columns_form.tpl"]-->
                            </div>
                            <!--[/if]-->   
                            <div class="large-4 columns left">
<!--[include file="my_pub_logo_upload_form.tpl"]-->                          
                            </div>
                    </div>
                </div>
            </div>
        </dd>
        <dd class="accordion-navigation">
            <a href="#Staff"><h3><!--[$this_publication.pub_name|escape]--> <!--[$static_content.label6|escape]--></h3></a>
            <div id="Staff" class="content">
                <div class="panel callout">
                    <div class="row">
                        <div class="large-4 columns left" >
<!--[include file="my_pub_staff_form.tpl"]-->
                        </div>
                        <div class="large-8 columns" >
                            <div class="large-12 columns"><!--[$static_content.label7|escape]--></div>
<!--[include file="my_pub_users_data_table.tpl"]-->
                        </div>
                    </div>            
                </div>
            </div>
        </dd>
    </dl>
<!--[/if]-->
<!--[if isset($smarty.get.debug)]-->
    <div class="row">
        <div class="panel  large-12 columns">
            <div class="row">
                <div class="large-12 columns">
                    <h4><!--[$this_publication.pub_name|escape]--></h4>
                    <h6><!--[$smarty.template]--> - smarty: <!--[$smarty.version]--></h6>
                    <h6>$this_publication</h6>
                    <pre><!--[$this_publication|@var_dump]--></pre>
                    <h6>$_GET</h6>
                    <pre><!--[$smarty.get|@var_dump]--></pre>
                </div>
            </div>
        </div>
    </div>
<!--[/if]-->
</div>
