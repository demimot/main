<div class="large-8 medium-10 small-12 columns" style="margin-top: 40px;"><!-- for allowing space below navigation bar -->
<!--[if $debug]--><!--[$smarty.template]--><!--[/if]-->
    <div class="row">
        <div class="panel<!--[if $smarty.get.pubid=='new']--> callout<!--[/if]-->">
            <div class="row">
                <div class="large-12 columns">
                    <h2>Publication: <!--[$this_publication.pub_name|escape]--></h2>
                    <p>Created by <strong><!--[$dmm_user.user_nickname|escape]--></strong> on <strong><!--[$this_publication.pub_tstamp|escape]--></strong> </p>
                </div>
            </div>
<!--[include file="my_pub_basic_form.tpl"]-->
        </div>
    </div>
<!--[if $smarty.get.pubid!='new']-->
    <dl class="accordion" data-accordion>
        <dd class="accordion-navigation">
            <a href="#Issues"><h3><!--[$this_publication.pub_name|escape]--> Issues...</h3></a>
            <div id="Issues" class="content active">
                <div class="panel callout">
                    <div class="row">
                        <div class="large-12 columns">
<!--[include file="my_pub_create_issue_form.tpl"]-->
                        </div>
                    </div>    
                    <div class="row">
                        <div class="large-4 columns left" >
<!--[include file="my_pub_unpublished_issues_form.tpl"]-->
                        </div>
                        <div class="large-4 columns left" >
<!--[include file="my_pub_published_issues_form.tpl"]-->
                        </div>
                    </div>
                </div>
            </div>
        </dd>
        <dd class="accordion-navigation">
            <a href="#defaults"><h3>Default settings: <!--[$this_publication.pub_name|escape]-->...</h3></a>
            <div id="defaults" class="content"> 
                <div class="panel callout">
                    <div class="row">
                        <div class="large-12 columns">
                            <div class="large-4 columns" >
<!--[include file="my_pub_css_form.tpl"]-->
                            </div>
                            <div class="large-4 columns" >
<!--[include file="my_pub_sections_form.tpl"]-->
                            </div>
                            <div class="large-4 columns" >
<!--[include file="my_pub_columns_form.tpl"]-->
                            </div>        
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-12 columns">
                            <div class="large-4 columns">
<!--[include file="my_pub_logo_upload_form.tpl"]-->                          
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </dd>
        <dd class="accordion-navigation">
            <a href="#Staff"><h3><!--[$this_publication.pub_name|escape]--> contributors...</h3></a>
            <div id="Staff" class="content">
                <div class="panel callout">
                    <div class="row">
                        <div class="large-4 columns left" >
<!--[include file="my_pub_staff_form.tpl"]-->
                        </div>
                        <div class="large-8 columns" >
                            <div class="large-12 columns">Search for contributors:</div>
<!--[include file="my_pub_users_data_table.tpl"]-->
                        </div>
                    </div>            
                </div>
            </div>
        </dd>
    </dl>
<!--[/if]-->
</div>