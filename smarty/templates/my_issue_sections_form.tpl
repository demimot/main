<!--[if $debug]--><span style="color:red;"><!--[$smarty.template]--></span><!--[/if]--><!--[dmm_template_static_content template_name=$smarty.template language=$smarty.session.language assign='static_content']-->
                        <form id="frm_issue_sections_form" name="frm_issue_sections_form" action="" method="post">
                            <div class="row">
                                <div class="large-12 columns">
                                    <label for="frm_sections" class="left"><!--[$static_content.label1|escape]--></label>
                                    <select name="frm_sections" id="frm_sections" multiple onchange="set_frm_issue_sections_form();" style="min-height:200px;" <!--[if not $this_issue.issue_sections]-->disabled<!--[/if]--> />
                                        <!--[if not $this_issue.issue_sections]--><option><!--[$static_content.label2|escape]--></option><!--[/if]-->
                                        <!--[foreach name=externo item=issue_section from=$this_issue.issue_sections]-->
                                        <option data-order="<!--[$issue_section.section_order|escape]-->" value="<!--[$issue_section.section_id|escape]-->"><!--[$issue_section.section_name|escape]--></option>
                                        <!--[/foreach]-->
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="large-9 columns">
                                    <label for="frm_section_name" class="left"><!--[$static_content.label3|escape]--></label>
                                    <input type="text" class="validate[required]" name="frm_section_name" id="frm_section_name" placeholder="<!--[$static_content.label4|escape]-->" value="">
                                </div>
                                <div class="large-3 columns">                
                                    <label for="frm_section_order" class="left"><!--[$static_content.label5|escape]--></label>
                                    <input type="text" class="validate[required]" name="frm_section_order" id="frm_section_order" placeholder="<!--[$static_content.label6|escape]-->" value="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="large-12 columns">
                                <input class="button small large-5 left" id="btn_section" type="submit" value="<!--[$static_content.label7|escape]-->" <!--[if $no_edit]-->disabled<!--[/if]-->/>
                                <input class="button small large-5 right" id="btn_section_cancel" type="button" value="<!--[$static_content.label8|escape]-->" onclick="reset_frm_issue_sections_form();" />
                                <input type="hidden" name="frm_submit" value=51 />
                                <input type="hidden" name="frm_pub_issue_id" value=<!--[$this_issue.pub_issue_id]--> />
                                <input type="hidden" name="frm_section_verb" id="frm_section_verb" value="add">
                                <input type="hidden" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
                                </div>
                            </div>                      
                        </form>