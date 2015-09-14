<!--[if isset($old_issues)]-->
  <!--[if $old_issues[0].pub_issue]-->
    <!--[dmm_template_static_content template_name=$smarty.template language=$smarty.session.language assign='static_content']-->
    <div class="panel callout" style="margin-top: 20px;">
<!--[if $debug]--><span style="color:red;"><!--[$smarty.template]--></span><pre>
<!--[$smarty.section.language]-->
</pre>
<!--[/if]-->
      <h5><!--[$this_pub.pub_name|escape]--></h5>
      <p><!--[if $old_issues[0].pub_issue<$this_pub.pub_issue]--><!--[$static_content.previous_issues|escape]--><!--[else]--><!--[$static_content.other_issues|escape]--><!--[/if]--></p>
      <ul>
      <!--[foreach name=outer item=pastissue from=$old_issues]-->
        <li><a href="/read-<!--[$this_pub.pub_slug|escape]-->/issue-<!--[$pastissue.pub_issue|escape]-->"><!--[$pastissue.pub_name|escape]--> - <!--[$pastissue.pub_issue|escape]--></a></li>
      <!--[/foreach]-->
      </ul> 
    </div>
  <!--[/if]-->
<!--[/if]-->