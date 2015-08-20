                        <form id="frm_issue_css_form" name="frm_issue_css_form" action="" method="post">
                            <div class="row"><div class="large-12 columns">
                                <label for="frm_issue_css" class="left">Issue CSS:</label>
                                <textarea class="validate[required]" name="frm_issue_css" id="frm_issue_css" placeholder="Type your issue CSS" style="min-height: 275px;"><!--[$this_issue.pub_issue_css|escape]--></textarea>
                            </div></div>
                            <div class="row"><div class="large-12 columns">
                                <input class="button small large-4" type="submit" value="Save CSS" <!--[if $no_edit]-->disabled<!--[/if]-->/>
                                <input type="hidden" name="frm_submit" value=50 />
                                <input type="hidden" name="frm_pub_issue_id" value=<!--[$this_issue.pub_issue_id]--> />
                                <input type="hidden" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
                            </div></div>
                        </form>