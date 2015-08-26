<!--[if $debug]--><!--[$smarty.template]--><!--[/if]-->
                                <form id="frm_pub_columns_form" name="frm_pub_columns_form" action="" method="post">
                                    <div class="row">
                                        <div class="large-12 columns">
                                            <label for="left-label" class="left">Columns:</label>
                                            <select name="frm_columns" id="frm_columns" multiple onchange="$('#frm_column_name').val($('#frm_columns option:selected').text());
                                                                                 $('#frm_column_name').prop('readonly', true);
                                                                                 $('#frm_column_section').val($('#frm_columns option:selected').attr('data-column-id'));
                                                                                 $('#column_staff_select').val($('#frm_columns option:selected').attr('data-column-user-id'));
                                                                                 $('#frm_column_verb').val('delete');
                                                                                 $('#btn_column').prop('value', 'Delete column');" style="min-height:100px;" <!--[if not $this_pub_columns]-->disabled<!--[/if]--> >
                                                <!--[if not $this_pub_columns]--><option>Use below text area to create Columns</option><!--[/if]-->
                                                <!--[foreach name=externo item=pub_column from=$this_pub_columns]-->
                                                <option data-column-id="<!--[$pub_column.column_id|escape]-->" data-column-section-id="<!--[$pub_column.section_id|escape]-->" data-column-user-id="<!--[$pub_column.user_id|escape]-->" value="<!--[$pub_column.column_id]-->"><!--[$pub_column.column_name|escape]--></option>
                                                <!--[/foreach]-->
                                            </select>
                                        </div>
                                   
                                        <div class="large-12 columns">
                                            <label for="frm_column_name" class="left">Column:</label>
                                            <input type="text" class="validate[required]" name="frm_column_name" id="frm_column_name" placeholder="Type your section name here" value="">
                                        </div>
                                    
                                    <!--[if $this_pub_sections]-->
                                    
                                        <div class="large-12 columns">
                                            <label for="frm_column_section" class="left">Section:</label>
                                                <select class="validate[required]" name="frm_column_section" id="frm_column_section" <!--[if not $this_pub_sections]-->disabled<!--[/if]--> >
                                                <option value="">-- Select a section --</option>
                                                <!--[foreach name=externo item=pub_section from=$this_pub_sections]-->
                                                    <option value="<!--[$pub_section.section_id|escape]-->"><!--[$pub_section.section_name|escape]--></option>
                                                <!--[/foreach]-->
                                            </select>
                                        </div>
                                    
                                    <!--[/if]-->
                                    
                                        <div class="large-12 columns">
                                            <label for="column_staff_select" class="left">Author:</label>
                                                <select class=class="validate[required]" id="column_staff_select" name="column_staff_select" >
                                                <!--[if not $contributors]-->    <option value="">No contributers so far</option><!--[else]-->    <option value="">-- Select an author --</option><!--[/if]-->
                                                <!--[foreach name=externo item=pub_contr from=$contributors]-->
                                                    <option value="<!--[$pub_contr.user_id|escape]-->"><!--[$pub_contr.user_nickname|escape]--></option>
                                                <!--[/foreach]-->
                                            </select>
                                        </div>
                                    
                                        <div class="large-12 columns">
                                            <input class="button small large-5" id="btn_column" type="submit" value="Add Column" <!--[if $no_edit]-->disabled<!--[/if]-->/>&nbsp;&nbsp;&nbsp;
                                            <input class="button small large-5" id="btn_column_cancel" type="button" value="cancel" onclick="$('#frm_columns').val('');
                                                                                                                                  $('#frm_column_name').prop('readonly', false);
                                                                                                                                  $('#frm_column_name').val('');
                                                                                                                                  $('#frm_column_section').val('');
                                                                                                                                  $('#column_staff_select').val('');
                                                                                                                                  $('#frm_column_verb').val('add');
                                                                                                                                  $('#btn_column').prop('value', 'Add Column');" />
                                            <input type="hidden" name="frm_submit" value=28 />
                                            <!--[if isset($smarty.get.pubid)]--><input type="hidden"   name="frm_pub_id" value=<!--[$smarty.get.pubid]--> /><!--[/if]-->
                                            <input type="hidden" name="frm_column_verb" id="frm_column_verb" value="add">
                                            <input type="hidden" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
                                        </div>
                                    </div>
                                </form>