<h4 class="subheader">My Publications:</h4>
<a href="create_new_pub" class="button">New Publication</a>
<!--[if $user_publications]-->
<div class="panel callout">
<h6 class="subheader">Existing publications:</h6>
<ul class="no-bullet">
  <!--[foreach name=externo item=existing_publications from=$user_publications]-->
    <li><small><a href="/?pubadmid=<!--[$existing_publications.pub_id|escape]-->"><!--[$existing_publications.pub_name|escape]--> - <!--[$existing_publications.pub_country|escape]--> - <!--[$existing_publications.pub_language|escape]--></a></small></li>
  <!--[/foreach]-->
</ul>
</div>
<!--[/if]-->
