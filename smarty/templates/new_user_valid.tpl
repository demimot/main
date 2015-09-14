<div class="large-8 medium-10 small-12 columns"><!--[dmm_template_static_content template_name=$smarty.template language=$smarty.session.language assign='static_content']-->
<!--[if $debug]--><span style="color:red;"><!--[$smarty.template]--></span><!--[/if]-->    <div class="callout panel" style="margin-top: 20px;">
        <h1><!--[$static_content.label1|escape]--> <!--[$this_user.user_nickname|escape]-->!!!</h1>
        <p><!--[$static_content.label2|escape]--></p>
    </div>
    <!--[include file='newsstand_banner.tpl']-->
    <div class="panel callout">
        <h3><!--[$static_content.label3|escape]--><!--[if $this_user.user_firstname|escape]--> <!--[$this_user.user_firstname|escape]--><!--[/if]-->!!!</h3>
        <h4><!--[$static_content.label4|escape]--></h4>
        <p><!--[$static_content.label5|escape]--></p>
        <p><!--[$static_content.label6|escape]--> <!--[$this_user.user_firstname|escape]--> <!--[$this_user.user_lastname|escape]--> - <!--[$static_content.label7|escape]--> <!--[$this_user.user_tel|escape]--> - <!--[$static_content.label8|escape]--> <!--[$this_user.user_email|escape]--></p>
    </div>
<!--[include file='featured_pubs.tpl']-->
    </div>
</div>