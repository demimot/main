                                <form id="frm_pub_css_form" name="frm_pub_css_form" action="" method="post">
                                    <div class="row">
                                    <div class="large-12 columns">
                                        <label for="left-label" class="left">CSS:</label>
                                        <textarea class="validate[required]" name="frm_publication_css" id="frm_publication_css" placeholder="Type your default CSS" style="min-height: 353px;"><!--[$this_publication.pub_css|escape]--></textarea>
                                    </div></div>
                                    <div class="row"><div class="large-12 columns">
                                        <input class="button small large-4" type="submit" value="Save CSS" <!--[if $no_edit]-->disabled<!--[/if]-->/>
                                        <input type="hidden" name="frm_submit" value=21 />
                                        <!--[if isset($smarty.get.pubid)]--><input type="hidden"   name="frm_pub_id" value=<!--[$smarty.get.pubid]--> /><!--[/if]-->
                                        <input type="hidden" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
                                    </div></div>
                                </form>