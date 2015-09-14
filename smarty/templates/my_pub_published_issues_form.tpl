<!--[if $debug]--><span style="color:red;"><!--[$smarty.template]--></span><!--[/if]--><!--[dmm_template_static_content template_name=$smarty.template language=$smarty.session.language assign='static_content']-->
                            <form id="frm_pub_published_issue_form" id="frm_pub_published_issue_form" action="" method="post">
                                <label for="frm_pub_issue_id" class="left"><!--[$static_content.label1|escape]--></label>
                                <select class="validate[required]" name="frm_pub_issue_id" id="frm_pub_issue_id" multiple style="min-height:200px;" <!--[if not $this_publication.pub_published_issues]-->disabled<!--[/if]--> >
                                    <!--[if not $this_publication.pub_published_issues]--><option><!--[$static_content.label2|escape]--></option><!--[/if]-->
                                    <!--[foreach name=externo item=pub_issue from=$this_publication.pub_published_issues]-->
                                    <option value="<!--[$pub_issue.pub_issue_id|escape]-->"><!--[$pub_issue.pub_name|escape]--> - <!--[$pub_issue.pub_issue|escape]--></option>
                                    <!--[/foreach]-->
                                </select>
                                <input class="button small large-6" id="btn_goto_published_issue" type="submit" value="<!--[$static_content.label3|escape]-->" <!--[if $no_edit]-->disabled<!--[/if]-->/>
                                <input type="hidden" name="frm_submit" value=24 />
                                <!--[if isset($smarty.get.pubid)]--><input type="hidden"   name="frm_pub_id" value=<!--[$smarty.get.pubid]--> /><!--[/if]-->
                                <input type="hidden" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
                            </form>