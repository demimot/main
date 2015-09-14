<div class="large-8 medium-10 small-12 columns"><!--[dmm_template_static_content template_name=$smarty.template language=$smarty.session.language assign='static_content']--><!--[if $debug]--><span style="color:red;"><!--[$smarty.template]--></span><!--[/if]-->    <div class="callout panel" style="margin-top: 20px;">
        <h3><!--[$static_content.label1|escape]--> <!--[$dmm_user.user_nickname|escape]--> <!--[$static_content.label2|escape]--></h3>
        <p><!--[$static_content.label3|escape]--></p>
    </div>
    <!--[include file='newsstand_banner.tpl']-->
    <div class="panel">
        <h4><!--[$static_content.label4|escape]--></h4>
        <p><!--[$static_content.label5|escape]--></p>
        <p><a href="/home"><!--[$static_content.label6|escape]--></a></p>
     </div>
     <!--[include file='featured_pubs.tpl']-->
</div>