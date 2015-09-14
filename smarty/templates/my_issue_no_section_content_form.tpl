<!--[if $debug]--><span style="color:red;"><!--[$smarty.template]--></span><!--[/if]-->
                            <div class="large-4 columns">
                                 <label for="frm_no_section_articles" class="left">Issue articles:</label>
                                 <select name="frm_no_section_articles" id="frm_no_section_articles" multiple  style="min-height:200px;" onchange="get_article_preview(this.value,'');get_article_images_preview(this.value,'');" >
                                    <!--[assign var="flag" value="0"]-->
                                    <!--[foreach name=externo item=section_article from=$this_issue.issue_articles]-->
                                        <!--[if $section_article.section_id==""]-->
                                        <option data-section="<!--[$section_article.section_id|escape]-->" value="<!--[$section_article.article_id|escape]-->"><!--[$section_article.article_title|escape]--></option>
                                        <!--[assign var="flag" value="1"]-->
                                        <!--[/if]-->
                                    <!--[/foreach]-->
                                    <!--[if not $flag]-->    <option value="">-- None --</option><!--[/if]-->
                                 </select>
                            </div>
                            <div class="large-8 columns">
                                <div id="frm_article_content" name="frm_article_content" style="overflow:auto; max-height:240px;background-color:white; border:thin;"></div>
                            </div>
                            <div class="large-12 columns">
                                <div id="frm_article_images" name="frm_article_images"></div>
                            </div>     