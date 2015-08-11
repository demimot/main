<div class="large-8 medium-10 small-12 columns" style="margin-top: 40px;"><!-- for allowing space below navigation bar -->
    <div class="row">
        <div class="panel">
            <div class="row">
                <div class="large-12 columns">
                    <div class="left">
                    <h1><!--[$this_issue.pub_name|escape]--> - Issue: <!--[$this_issue.pub_issue|escape]--></h1>
                    <h4><!--[$this_issue.pub_issue_tstamp|date_format:"%A, %B %e, %Y"|escape]--> (creation date)</h4>
                    <h6><!--[$smarty.template]--></h6>
                    </div>
                    <div class="right" style="margin-right:10px">
                        <!--[if not $this_issue.pub_issue_published]-->
                             <!-- in fact this if will wrap almost the whole page...
                             I will load a different template for unpublished and for published issues. 
                             Published issues will have no forms except 
                             * one to request removal of issue 
                             * one to reuqest removal of article
                             Both for removals based on judicial decisions ONLY 
                             and depending on our approval (notification of court decision)
                             -->
                        <form action="" method="post">
                        <div class="row large-12">
                            <input class="button small large-6" id="publish" type="submit" value="Publish Issue" disabled/>
                        </div>
                        <div class="row large-12" >
                            <input type="checkbox" name="frm_check_publish_issue" id="frm_check_publish_issue" onchange="document.getElementById('publish').disabled=!document.getElementById('frm_check_publish_issue').checked"> I Choose to publish this issue now.
                            <input type="hidden" name="frm_submit" value=100 />
                            <input type="hidden" name="frm_pub_issue_id" value=<!--[$this_issue.pub_issue_id]--> />
                            <input type="hidden" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
                        </div> 	            
                        </form>
                        <!--[else]-->
                            <p>Published</p> 
                            
                            
                             <!-- in fact this if will wrap almost the whole page...
                             I will load a different template for unpublished and for published issues. 
                             Published issues will have no forms except 
                             * one to request removal of issue 
                             * one to reuqest removal of article
                             Both for removals based on judicial decisions ONLY 
                             and depending on our approval (notification of court decision)
                             -->
                            
                        <!--[/if]-->
                    </div>
                </div>
            </div>
        </div>
    </div> 
    <!--[if $this_issue.issue_sections]-->
    <div class="row">
        <div class="panel callout">
            <div class="row">
            <div class="large-12 columns">
                <h4>Sections and content</h4>
                <dl class="tabs" data-tab>
                    <!--[foreach name=externo item=issue_section from=$this_issue.issue_sections]-->
                    <dd class="tab-title<!--[if $smarty.foreach.externo.first]--> active<!--[/if]-->"><a href="#panel<!--[$issue_section.section_id]-->"><!--[$issue_section.section_name]--></a></dd>
                    <!--[/foreach]-->
                </dl>
                <div class="tabs-content">
                    <!--[foreach name=externo item=issue_section from=$this_issue.issue_sections]-->
                    <div class="content<!--[if $smarty.foreach.externo.first]--> active<!--[/if]-->" id="panel<!--[$issue_section.section_id]-->" style="background-color:white;width:100%;">
                        <p class="dmm_p_margin">Use este espaço para adicionar artigos existentes, solicitar colunas e artigos para autores, etc.
                        <p class="dmm_p_margin">Seção "<span style=" font-weight:600"><!--[$issue_section.section_name]--></span>"</p>
                    </div>
                    <!--[/foreach]-->
                </div>
            </div>
            </div>
        </div>
    </div>
    <!--[/if]-->
    <div class="row">
        <div class="panel callout">
            <div class="row">
                <div class="large-12 columns">
                    <h4>Issue General Settings</h4>
                    <div class="large-4 columns" >
                        <form action="" method="post">
                            <div class="row">
                                <label for="frm_issue_css" class="left">Issue CSS:</label>
                                <textarea name="frm_issue_css" id="frm_issue_css" placeholder="Type your issue CSS" style="min-height: 275px;"><!--[$this_issue.pub_issue_css|escape]--></textarea>
                            </div>
                            <div class="row">
                                <input class="button small large-4" type="submit" value="Save CSS" <!--[if $no_edit]-->disabled<!--[/if]-->/>
                                <input type="hidden" name="frm_submit" value=50 />
                                <input type="hidden" name="frm_pub_issue_id" value=<!--[$this_issue.pub_issue_id]--> />
                                <input type="hidden" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
                            </div>
                        </form>
                    </div>
                    <div class="large-4 columns">
                        <form action="" method="post">
                            <div class="row">
                                <div class="large-12 columns">
                                    <label for="frm_sections" class="left">Issue Sections:</label>
                                    <select name="frm_sections" id="frm_sections" multiple onchange="$('#frm_section_name').val($('#frm_sections option:selected').text());
                                                                                 $('#frm_section_name').prop('readonly', true);
                                                                                 $('#frm_section_order').val($('#frm_sections option:selected').attr('data-order'));
                                                                                 $('#frm_section_verb').val('delete');
                                                                                 $('#btn_section').prop('value', 'Delete Section');" style="min-height:200px;" <!--[if not $this_issue.issue_sections]-->disabled<!--[/if]--> >
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
                                    <input type="text" name="frm_section_name" id="frm_section_name" placeholder="Type your section name here" value="">
                                </div>
                                <div class="large-3 columns">                
                                    <label for="frm_section_order" class="left">Order:</label>
                                    <input type="text" name="frm_section_order" id="frm_section_order" placeholder="Type your section order here" value="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="large-12 columns">
                                <input class="button small large-5" id="btn_section" type="submit" value="Add Section" <!--[if $no_edit]-->disabled<!--[/if]-->/>&nbsp;&nbsp;&nbsp;
                                <a href="" class="button small large-5" id="btn_cancel" type="button" style="color:white">Cancel</a>
                                <input type="hidden" name="frm_submit" value=51 />
                                <input type="hidden" name="frm_pub_issue_id" value=<!--[$this_issue.pub_issue_id]--> />
                                <input type="hidden"   name="frm_section_verb" id="frm_section_verb" value="add">
                                <input type="hidden" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
                                </div>
                            </div>                      
                        </form>
                    </div>
                    <div class="large-4 columns" >
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <label for="frm_image_upload" class="left">Issue Cover: <!--[$this_issue.pub_issue_cover|escape]--></label>
                                <!--[if $smarty.get.msgcover]--><label for="frm_image_upload" class="left"><span style="color:red !important;">&nbsp;<!--[$smarty.get.msgcover|escape]--></span></label><!--[/if]-->
                                <input class="file" name="frm_image_upload" id="frm_image_upload" placeholder="Cover filename" type=file>
                            </div>
                            <!--[if $this_issue.pub_issue_cover]-->
                                <div class="row">
                                    <div class="large-12 columns">
                                    <img class="right" src="/<!--[$default_img_path]--><!--[$this_issue.pub_issue_cover]-->" alt="$this_issue.pub_name" name="cover" />
                                    </div>&nbsp;
                                </div>
                            <!--[/if]-->
                            <div class="row">
                                <input class="button small large-4 right" type="submit" value="Save Cover" <!--[if $no_edit]-->disabled<!--[/if]--> />
                                <input type="hidden" name="frm_submit" value=52 />
                                <input type="hidden" name="frm_pub_issue_id" value=<!--[$this_issue.pub_issue_id]--> />
                                <input type="hidden" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
                            </div>
                        </form>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <label for="frm_image_upload" class="left">Issue Logo: <!--[$this_issue.pub_issue_logo|escape]--></label>
                                <!--[if $smarty.get.msglogo]--><label for="frm_image_upload" class="left"><span style="color:red !important;">&nbsp;<!--[$smarty.get.msglogo|escape]--></span></label><!--[/if]-->
                                <input class="file" name="frm_image_upload" id="frm_image_upload" placeholder="Logo filename" type=file>
                            </div>
                            <!--[if $this_issue.pub_issue_logo]-->
                                <div class="row">
                                    <div class="large-12 columns">
                                    <img class="right" src="/<!--[$default_img_path]--><!--[$this_issue.pub_issue_logo]-->" alt="$this_issue.pub_name" name="logo" />
                                    </div>&nbsp;
                                </div>
                            <!--[/if]-->
                            <div class="row">
                                <input class="button small large-4 right" type="submit" value="Save Logo" <!--[if $no_edit]-->disabled<!--[/if]--> />
                                <input type="hidden" name="frm_submit" value=53 />
                                <input type="hidden" name="frm_pub_issue_id" value=<!--[$this_issue.pub_issue_id]--> />
                                <input type="hidden" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="panel">
            <div class="row">
                <div class="large-12 columns">
                    <h4><!--[$this_issue.pub_name|escape]--> Issue: <!--[$this_issue.pub_issue|escape]--></h4>
                    <h6><!--[$smarty.template]--></h6>
                    <pre><!--[$this_issue|@var_dump]--></pre>
                </div>
            </div>
        </div>
    </div>
</div>