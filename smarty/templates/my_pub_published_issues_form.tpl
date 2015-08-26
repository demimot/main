<!--[if $debug]--><!--[$smarty.template]--><!--[/if]-->
                            <form id="frm_pub_published_issue_form" id="frm_pub_published_issue_form" action="" method="post">
                                <label for="frm_pub_issue_id" class="left">Published issues:</label>
                                <select class="validate[required]" name="frm_pub_issue_id" id="frm_pub_issue_id" multiple style="min-height:200px;" <!--[if not $published_issues]-->disabled<!--[/if]--> >
                                    <!--[if not $published_issues]--><option>No Published issues so far</option><!--[/if]-->
                                    <!--[foreach name=externo item=pub_issue from=$published_issues]-->
                                    <option value="<!--[$pub_issue.pub_issue_id|escape]-->"><!--[$pub_issue.pub_name|escape]--> - <!--[$pub_issue.pub_issue|escape]--></option>
                                    <!--[/foreach]-->
                                </select>
                                <input class="button small large-5" id="btn_goto_published_issue" type="submit" value="View Issue" <!--[if $no_edit]-->disabled<!--[/if]-->/>
                                <input type="hidden" name="frm_submit" value=24 />
                                <!--[if isset($smarty.get.pubid)]--><input type="hidden"   name="frm_pub_id" value=<!--[$smarty.get.pubid]--> /><!--[/if]-->
                                <input type="hidden" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
                            </form>