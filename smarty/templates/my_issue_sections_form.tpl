                        <form id="frm_issue_sections_form" name="frm_issue_sections_form" action="" method="post">
                            <div class="row">
                                <div class="large-12 columns">
                                    <label for="frm_sections" class="left">Issue Sections:</label>
                                    <select name="frm_sections" id="frm_sections" multiple onchange="$('#frm_section_name').val($('#frm_sections option:selected').text());
                                                                                 $('#frm_section_name').prop('readonly', true);
                                                                                 $('#frm_section_order').val($('#frm_sections option:selected').attr('data-order'));
                                                                                 $('#frm_section_verb').val('delete');
                                                                                 $('#btn_section').prop('value', 'Delete Section');" style="min-height:200px;" <!--[if not $this_issue.issue_sections]-->disabled<!--[/if]--> />
                                        <!--[if not $this_issue.issue_sections]--><option>Use below text area to create sections</option><!--[/if]-->
                                        <!--[foreach name=externo item=issue_section from=$this_issue.issue_sections]-->
                                        <option data-order="<!--[$issue_section.section_order]-->" value="<!--[$issue_section.section_id]-->"><!--[$issue_section.section_name]--></option>
                                        <!--[/foreach]-->
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="large-9 columns">
                                    <label for="frm_section_name" class="left">Add section:</label>
                                    <input type="text" class="validate[required]" name="frm_section_name" id="frm_section_name" placeholder="Type your section name here" value="">
                                </div>
                                <div class="large-3 columns">                
                                    <label for="frm_section_order" class="left">Order:</label>
                                    <input type="text" class="validate[required]" name="frm_section_order" id="frm_section_order" placeholder="Type your section order here" value="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="large-12 columns">
                                <input class="button small large-5" id="btn_section" type="submit" value="Add Section" <!--[if $no_edit]-->disabled<!--[/if]-->/>&nbsp;&nbsp;&nbsp;
                                <input class="button small large-5" id="btn_section_cancel" type="button" value="cancel" onclick="$('#frm_sections').val('');
                                                                                                                                  $('#frm_section_name').prop('readonly', false);
                                                                                                                                  $('#frm_section_name').val('');
                                                                                                                                  $('#frm_section_order').val('');
                                                                                                                                  $('#frm_section_verb').val('add');
                                                                                                                                  $('#btn_section').prop('value', 'Add Section');" />&nbsp;&nbsp;&nbsp;
                                
                                <input type="hidden" name="frm_submit" value=51 />
                                <input type="hidden" name="frm_pub_issue_id" value=<!--[$this_issue.pub_issue_id]--> />
                                <input type="hidden" name="frm_section_verb" id="frm_section_verb" value="add">
                                <input type="hidden" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
                                </div>
                            </div>                      
                        </form>