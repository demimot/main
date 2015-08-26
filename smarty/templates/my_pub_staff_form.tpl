<!--[if $debug]--><!--[$smarty.template]--><!--[/if]-->
                            <form id="frm_pub_staff_form" name="frm_pub_staff_form" action="" method="post">
                                <label for="pub_staff" class="left">Regular contributors:</label>
                                <select id="pub_staff_select" name="pub_staff_select" multiple style="min-height:200px;" <!--[if not $contributors]-->disabled<!--[/if]--> >
                                    <!--[if not $contributors]--><option value="">No contributers so far</option><!--[/if]-->
                                    <!--[foreach name=externo item=pub_contr from=$contributors]-->
                                    <option value="<!--[$pub_contr.user_id|escape]-->"><!--[$pub_contr.user_nickname|escape]--></option>
                                    <!--[/foreach]-->
                                </select>
                                <label for="frm_pub_staff_name" class="left">Contributor:</label>
                                <input class="validate[required]" id="frm_pub_staff_name" name="frm_pub_staff_name" type="text" placeholder="Select a user on the table" readonly />
                                <input class="button small large-5" id="btn_staff" name="btn_staff" type="submit" value="Add contributor" <!--[if $no_edit]-->disabled<!--[/if]-->/>
                                <input type="hidden" id="frm_pub_staff_user_id" name="frm_pub_staff_user_id" />
                                <input type="hidden" id="frm_pub_staff_verb" name="frm_pub_staff_verb" value="add">
                                <input type="hidden" id="frm_submit" name="frm_submit" value=27 />
                                <!--[if isset($smarty.get.pubid)]--><input type="hidden"   name="frm_pub_id" value=<!--[$smarty.get.pubid]--> /><!--[/if]-->
                                <input type="hidden" id="frm_xss" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
                            </form>