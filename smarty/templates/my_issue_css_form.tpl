<!--[if $debug]--><span style="color:red;"><!--[$smarty.template]--></span><!--[/if]--><!--[dmm_template_static_content template_name=$smarty.template language=$smarty.session.language assign='static_content']-->
                        <form id="frm_issue_css_form" name="frm_issue_css_form" action="" method="post">

                                <label for="frm_issue_css" class="left"><!--[$static_content.label01|escape]--></label>
                                <textarea class="validate[required]" name="frm_issue_css" id="frm_issue_css" placeholder="<!--[$static_content.label02|escape]-->" style="min-height: 275px;"><!--[$this_issue.pub_issue_css|escape]--></textarea>

                                <input class="button small large-5" type="submit" value="<!--[$static_content.label03|escape]-->" <!--[if $no_edit]-->disabled<!--[/if]-->/>
                                <input type="hidden" name="frm_submit" value=50 />
                                <input type="hidden" name="frm_pub_issue_id" value=<!--[$this_issue.pub_issue_id]--> />
                                <input type="hidden" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />

                        </form>