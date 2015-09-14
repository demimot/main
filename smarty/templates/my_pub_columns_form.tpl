<!--[if $debug]--><span style="color:red;"><!--[$smarty.template]--></span><!--[/if]--><!--[dmm_template_static_content template_name=$smarty.template language=$smarty.session.language assign='static_content']-->
                                <form id="frm_pub_columns_form" name="frm_pub_columns_form" action="" method="post">
                                    <div class="row">
                                        <div class="large-12 columns">
                                            <label for="left-label" class="left"><!--[$static_content.label1|escape]--></label>
                                            <select name="frm_columns" id="frm_columns" multiple onchange="set_frm_pub_columns_form();" style="min-height:100px;" <!--[if not $this_publication.pub_columns]-->disabled<!--[/if]--> >
                                                <!--[if not $this_publication.pub_columns]--><option><!--[$static_content.label2|escape]--></option><!--[/if]-->
                                                <!--[foreach name=externo item=pub_column from=$this_publication.pub_columns]-->
                                                <option data-column-id="<!--[$pub_column.column_id|escape]-->" data-column-section-id="<!--[$pub_column.section_id|escape]-->" data-column-user-id="<!--[$pub_column.user_id|escape]-->" value="<!--[$pub_column.column_id]-->"><!--[$pub_column.column_name|escape]--></option>
                                                <!--[/foreach]-->
                                            </select>
                                        </div>
                                   
                                        <div class="large-12 columns">
                                            <label for="frm_column_name" class="left"><!--[$static_content.label3|escape]--></label>
                                            <input type="text" class="validate[required]" name="frm_column_name" id="frm_column_name" placeholder="<!--[$static_content.label4|escape]-->" value="">
                                        </div>
                                    
                                    <!--[if $this_publication.pub_sections]-->
                                    
                                        <div class="large-12 columns">
                                            <label for="frm_column_section" class="left"><!--[$static_content.label5|escape]--></label>
                                                <select class="validate[required]" name="frm_column_section" id="frm_column_section" <!--[if not $this_publication.pub_sections]-->disabled<!--[/if]--> >
                                                <option value=""><!--[$static_content.label6|escape]--></option>
                                                <!--[foreach name=externo item=pub_section from=$this_publication.pub_sections]-->
                                                    <option value="<!--[$pub_section.section_id|escape]-->"><!--[$pub_section.section_name|escape]--></option>
                                                <!--[/foreach]-->
                                            </select>
                                        </div>
                                    
                                    <!--[/if]-->
                                    
                                        <div class="large-12 columns">
                                            <label for="column_staff_select" class="left"><!--[$static_content.label7|escape]--></label>
                                                <select class=class="validate[required]" id="column_staff_select" name="column_staff_select" >
                                                <!--[if not $this_publication.pub_staff]-->    <option value=""><!--[$static_content.label8|escape]--></option><!--[else]-->    <option value=""><!--[$static_content.label9|escape]--></option><!--[/if]-->
                                                <!--[foreach name=externo item=pub_contr from=$this_publication.pub_staff]-->
                                                    <option value="<!--[$pub_contr.user_id|escape]-->"><!--[$pub_contr.user_nickname|escape]--></option>
                                                <!--[/foreach]-->
                                            </select>
                                        </div>
                                    
                                        <div class="large-12 columns">
                                            <input class="button small large-5" id="btn_column" type="submit" value="<!--[$static_content.label10|escape]-->" <!--[if $no_edit]-->disabled<!--[/if]-->/>&nbsp;&nbsp;&nbsp;
                                            <input class="button small large-5" id="btn_column_cancel" type="button" value="<!--[$static_content.label11|escape]-->" onclick="reset_frm_pub_columns_form();" />
                                            <input type="hidden" name="frm_submit" value=28 />
                                            <!--[if isset($smarty.get.pubid)]--><input type="hidden"   name="frm_pub_id" value=<!--[$smarty.get.pubid]--> /><!--[/if]-->
                                            <input type="hidden" name="frm_column_verb" id="frm_column_verb" value="add">
                                            <input type="hidden" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
                                        </div>
                                    </div>
                                </form>