<!--[if $debug]--><span style="color:red;"><!--[$smarty.template]--></span><!--[/if]--><!--[dmm_template_static_content template_name=$smarty.template language=$smarty.session.language assign='static_content']-->
                            <form id="frm_pub_staff_form" name="frm_pub_staff_form" action="" method="post">
                                <label for="pub_staff" class="left"><!--[$static_content.label1|escape]--></label>
                                <select id="pub_staff_select" name="pub_staff_select" multiple style="min-height:200px;" <!--[if not $this_publication.pub_staff]-->disabled<!--[/if]--> >
                                    <!--[if not $this_publication.pub_staff]--><option value=""><!--[$static_content.label2|escape]--></option><!--[/if]-->
                                    <!--[foreach name=externo item=pub_contr from=$this_publication.pub_staff]-->
                                    <option value="<!--[$pub_contr.user_id|escape]-->"><!--[$pub_contr.user_nickname|escape]--></option>
                                    <!--[/foreach]-->
                                </select>
                                <label for="frm_pub_staff_name" class="left"><!--[$static_content.label3|escape]--></label>
                                <input class="validate[required]" id="frm_pub_staff_name" name="frm_pub_staff_name" type="text" placeholder="<!--[$static_content.label4|escape]-->" readonly />
                                <input class="button small large-6" id="btn_staff" name="btn_staff" type="submit" value="<!--[$static_content.label5|escape]-->" <!--[if $no_edit]-->disabled<!--[/if]-->/>
                                <input class="button small large-5" id="btn_staff_cancel" type="button" value="<!--[$static_content.label6|escape]-->" onclick="reset_frm_pub_staff_form();" />&nbsp;&nbsp;&nbsp;
                                <input type="hidden" id="frm_pub_staff_user_id" name="frm_pub_staff_user_id" />
                                <input type="hidden" id="frm_pub_staff_verb" name="frm_pub_staff_verb" value="add">
                                <input type="hidden" id="frm_submit" name="frm_submit" value=27 />
                                <!--[if isset($smarty.get.pubid)]--><input type="hidden"   name="frm_pub_id" value=<!--[$smarty.get.pubid]--> /><!--[/if]-->
                                <input type="hidden" id="frm_xss" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
                            </form>