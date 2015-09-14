<!--[if $debug]--><span style="color:red;"><!--[$smarty.template]--></span><!--[/if]--><!--[dmm_template_static_content template_name=$smarty.template language=$smarty.session.language assign='static_content']-->
<h4 class="subheader"  style="margin-top: 20px;"><!--[$static_content.my_pubs|escape]--></h4>
<a href="create_new_pub" class="button"><!--[$static_content.new_pub|escape]--></a>
<!--[if $user_publications]-->
<div class="panel callout">
<h6 class="subheader"><!--[$static_content.existing_pubs|escape]--></h6>
<ul class="no-bullet">
  <!--[foreach name=externo item=existing_publications from=$user_publications]-->
    <li><small><a href="/admin-pub-<!--[$existing_publications.pub_id|escape]-->"><!--[$existing_publications.pub_name|escape]--> - <!--[$existing_publications.pub_country|escape]--> - <!--[$existing_publications.pub_language|escape]--></a></small></li>
  <!--[/foreach]-->
</ul>
</div>
<!--[/if]-->
