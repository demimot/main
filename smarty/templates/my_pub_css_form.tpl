<!--[if $debug]--><span style="color:red;"><!--[$smarty.template]--></span><!--[/if]--><!--[dmm_template_static_content template_name=$smarty.template language=$smarty.session.language assign='static_content']-->
                                <form id="frm_pub_css_form" name="frm_pub_css_form" action="" method="post">
                                    <div class="row">
                                    <div class="large-12 columns">
                                        <label for="left-label" class="left"><!--[$static_content.label1|escape]--></label>
                                        <textarea class="validate[required]" name="frm_publication_css" id="frm_publication_css" placeholder="<!--[$static_content.label2|escape]-->" style="min-height: 353px;"><!--[$this_publication.pub_css|escape]--></textarea>
                                    </div></div>
                                    <div class="row"><div class="large-12 columns">
                                        <input class="button small large-6" type="submit" value="<!--[$static_content.label3|escape]-->" <!--[if $no_edit]-->disabled<!--[/if]-->/>
                                        <input type="hidden" name="frm_submit" value=21 />
                                        <!--[if isset($smarty.get.pubid)]--><input type="hidden"   name="frm_pub_id" value=<!--[$smarty.get.pubid]--> /><!--[/if]-->
                                        <input type="hidden" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
                                    </div></div>
                                </form>