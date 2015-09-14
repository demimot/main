<!--[if $debug]--><span style="color:red;"><!--[$smarty.template]--></span><!--[/if]--><!--[dmm_template_static_content template_name=$smarty.template language=$smarty.session.language assign='static_content']-->
                            <form action="" id="frm_pub_unpublished_issue_form" name="frm_pub_unpublished_issue_form" method="post">
                                <label for="left-label" class="left" ><!--[$static_content.label1|escape]--></label>
                                <select class="validate[required]" name="frm_pub_issue_id" id="frm_pub_issue_id" multiple style="min-height:200px;" <!--[if not $this_publication.pub_unpublished_issues]-->disabled<!--[/if]-->  >
                                    <!--[if not $this_publication.pub_unpublished_issues]--><option><!--[$static_content.label2|escape]--></option><!--[/if]-->
                                    <!--[foreach name=externo item=pub_issue from=$this_publication.pub_unpublished_issues]-->
                                    <option value="<!--[$pub_issue.pub_issue_id|escape]-->" ><!--[$pub_issue.pub_name|escape]--> - <!--[$pub_issue.pub_issue|escape]--></option>
                                    <!--[/foreach]-->
                                </select>
                                <input class="button small large-6"  id="btn_goto_issue" type="submit" value="<!--[$static_content.label3|escape]-->"/>
                                <input type="hidden" name="frm_submit" value=26 onclick="return submitForm();" />
                                <!--[if isset($smarty.get.pubid)]--><input type="hidden"   name="frm_pub_id" value=<!--[$smarty.get.pubid]--> /><!--[/if]-->
                                <input type="hidden" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
                            </form>