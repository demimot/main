<!--[if $debug]--><!--[$smarty.template]--><!--[/if]-->
                                <div class="large-4 columns">
                                        <label for="frm_articles<!--[$issue_section.section_id]-->" class="left">Section <!--[$issue_section.section_name|escape]--> articles:</label>
                                        <select name="frm_articles<!--[$issue_section.section_id]-->" id="frm_articles<!--[$issue_section.section_id]-->" multiple  style="min-height:200px;" onchange="get_article_preview(this.value, <!--[$issue_section.section_id]-->); get_article_images_preview(this.value, <!--[$issue_section.section_id]-->);" >
                                        <!--[assign var="flag" value="0"]-->
                                        <!--[foreach name=externo item=section_article from=$this_issue.issue_articles]-->
                                            <!--[if $section_article.section_id eq $issue_section.section_id]-->
                                                <option data-section="<!--[$section_article.article_id|escape]-->" value="<!--[$section_article.article_id|escape]-->"><!--[$section_article.article_title|escape]--></option>
                                                <!--[assign var="flag" value="1"]-->
                                            <!--[/if]-->   
                                        <!--[/foreach]-->
                                        <!--[if not $flag]-->    <option value="">-- None --</option><!--[/if]-->
                                        </select>
                                </div>
                                <div class="large-8 columns">
                                     <div id="frm_article_content<!--[$issue_section.section_id]-->" name="frm_article_content<!--[$issue_section.section_id]-->" style="overflow:auto; max-height:240px;background-color:white; border:thin;"></div>
                                </div>
                                <div class="large-12 columns">
                                    <div id="frm_article_images<!--[$issue_section.section_id]-->" name="frm_article_images<!--[$issue_section.section_id]-->"></div>
                                </div>                                
                                                                