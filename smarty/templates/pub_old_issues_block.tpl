<!--[if isset($old_issues)]-->
  <div class="row">&nbsp;</div>
  <div class="row">&nbsp;</div>
  <!--[if $old_issues[0].pub_issue]-->
    <div class="panel callout">
      <h5><!--[$this_pub.pub_name|escape]--></h5>
      <p><!--[if $old_issues[0].pub_issue<$this_pub.pub_issue]-->previous issues:<!--[else]-->other issues<!--[/if]--><!--$old_issues|@var_dump--></p>
      <ul>
      <!--[foreach name=outer item=pastissue from=$old_issues]-->
        <li><a href="/read-<!--[$this_pub.pub_slug|escape]-->/issue-<!--[$pastissue.pub_issue|escape]-->"><!--[$pastissue.pub_name|escape]--> - <!--[$pastissue.pub_issue|escape]--></a></li>
      <!--[/foreach]-->
      </ul> 
    </div>
  <!--[/if]-->
<!--[/if]-->