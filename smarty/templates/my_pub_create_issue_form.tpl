<!--[if $debug]--><!--[$smarty.template]--><!--[/if]-->
                            <form action="" method="post">
                                <input class="button small large-3" type="submit" value="Create new Issue" />
                                <!--[if isset($smarty.get.pubid)]--><input type="hidden"   name="frm_pub_id" value=<!--[$smarty.get.pubid]--> /><!--[/if]-->
                                <input type="hidden" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
                                <input type="hidden" name="frm_submit" value=25 />
                            </form>