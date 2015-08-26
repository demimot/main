<!--[if $debug]--><!--[$smarty.template]--><!--[/if]-->
                            <form action="" id="frm_pub_unpublished_issue_form" name="frm_pub_unpublished_issue_form" method="post">
                                <label for="left-label" class="left" >Unpublished issues:</label>
                                <select class="validate[required]" name="frm_pub_issue_id" id="frm_pub_issue_id" multiple style="min-height:200px;" <!--[if not $unpublished_issues]-->disabled<!--[/if]-->  >
                                    <!--[if not $unpublished_issues]--><option>No unpublished issues so far</option><!--[/if]-->
                                    <!--[foreach name=externo item=pub_issue from=$unpublished_issues]-->
                                    <option value="<!--[$pub_issue.pub_issue_id|escape]-->" ><!--[$pub_issue.pub_name|escape]--> - <!--[$pub_issue.pub_issue|escape]--></option>
                                    <!--[/foreach]-->
                                </select>
                                <input class="button small large-5"  id="btn_goto_issue" type="submit" value="Edit issue"/>
                                <input type="hidden" name="frm_submit" value=26 onclick="return submitForm();" />
                                <!--[if isset($smarty.get.pubid)]--><input type="hidden"   name="frm_pub_id" value=<!--[$smarty.get.pubid]--> /><!--[/if]-->
                                <input type="hidden" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
                            </form>