<!--[if $debug]--><span style="color:red;"><!--[$smarty.template]--></span><!--[/if]--><!--[dmm_template_static_content template_name=$smarty.template language=$smarty.session.language assign='static_content']-->
                            <form action="" method="post" onsubmit="return confirm_new_issue();">
                                <input class="button small large-6" type="submit" value="<!--[$static_content.label1|escape]-->" />
                                <!--[if isset($smarty.get.pubid)]--><input type="hidden"   name="frm_pub_id" value=<!--[$smarty.get.pubid]--> /><!--[/if]-->
                                <input type="hidden" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
                                <input type="hidden" name="frm_submit" value=25 />
                            </form>