<!--[if $debug]--><span style="color:red;"><!--[$smarty.template]--></span><!--[/if]--><!--[dmm_template_static_content template_name=$smarty.template language=$smarty.session.language assign='static_content']-->
            <form id="frm_publication_form" name="frm_publication_form" action="" method="post">
                <div class="row">
                    <div class="large-12 columns">
                        <label for="frm_publication_name" class="left"><!--[$static_content.label1|escape]--></label>
                        <input type="text" class="validate[required]" name="frm_publication_name" id="frm_publication_name" placeholder="<!--[$static_content.label2|escape]-->" value="<!--[$this_publication.pub_name|escape]-->">
                    </div>
                </div>
                <div class="row">
                    <div class="large-12 columns">
                        <label for="frm_publication_mote" class="left"><!--[$static_content.label3|escape]--></label>
                        <input type="text" class="validate[required]" name="frm_publication_mote" id="frm_publication_mote" placeholder="<!--[$static_content.label4|escape]-->" value="<!--[$this_publication.pub_mote|escape]-->">
                    </div>
                </div>
                <div class="row">
                    <div class="large-4 columns">
                        <label for="frm_publication_type" class="left"><!--[$static_content.label17|escape]--></label>
                        <select class="validate[required]" name="frm_publication_type" id="frm_publication_type" title="" <!--[if $smarty.get.pubid neq 'new']-->disabled=true<!--[/if]-->>
                            <option value=""><!--[$static_content.label18|escape]--></option>
                        <!--[foreach name=externo item=pub_type from=$publication_options.pub_types]-->
                            <option value="<!--[$pub_type.pub_type_id|escape]-->" <!--[if $this_publication.pub_type eq $pub_type.pub_type_id]--> selected="selected"<!--[/if]-->><!--[$pub_type.pub_type|escape]--></option>
                        <!--[/foreach]-->
                        </select>
                    </div>
                    <div class="large-4 columns">
                        <label for="frm_publication_style" class="left"><!--[$static_content.label19|escape]--></label>
                        <select class="validate[required]" name="frm_publication_style" id="frm_publication_style" title="" <!--[if $smarty.get.pubid neq 'new']-->disabled=true<!--[/if]-->>
                            <option value=""><!--[$static_content.label20|escape]--></option>
                            <option value="1" <!--[if $this_publication.pub_style eq 1]--> selected="selected"<!--[/if]-->><!--[$static_content.label21|escape]--></option>
                            <option value="2" <!--[if $this_publication.pub_style eq 2]--> selected="selected"<!--[/if]-->><!--[$static_content.label22|escape]--></option>
                        </select>
                    </div>
                    <div class="large-4 columns">
                        <label for="frm_publication_income" class="left"><!--[$static_content.label23|escape]--></label>
                        <select class="validate[required]" name="frm_publication_income" id="frm_publication_income" title="" <!--[if $smarty.get.pubid neq 'new']-->disabled=true<!--[/if]-->>
                            <option value=""><!--[$static_content.label24|escape]--></option>
                        <!--[foreach name=externo item=pub_income from=$publication_options.pub_income_status]-->
                            <option value="<!--[$pub_income.pub_income_id|escape]-->" <!--[if $this_publication.pub_income_status eq $pub_income.pub_income_id]--> selected="selected"<!--[/if]-->><!--[$pub_income.pub_income|escape]--></option>
                        <!--[/foreach]-->
                        </select>
                    </div>
                </div>                
                <div class="row">
                    <div class="large-4 columns">
                        <label for="language" class="left"><!--[$static_content.label5|escape]--></label>
                        <div class="error-spacer">
                            <span class="form-error-message" id="country_error">&nbsp;</span>
                            <p>
                                <select class="validate[required]" id="language" name="language" title="language" <!--[if $smarty.get.pubid neq 'new']-->disabled=true<!--[/if]-->>
                                    <option value=""><!--[$static_content.label6|escape]--></option>
                                    <option data-list="fr" value="fr"<!--[if $this_publication.pub_language=='fr']--> selected="selected"<!--[/if]-->><!--[$static_content.label7|escape]--></option> 
                                    <option data-list="en" value="en"<!--[if $this_publication.pub_language=='en']--> selected="selected"<!--[/if]-->><!--[$static_content.label8|escape]--></option> 
                                    <option data-list="pt" value="pt"<!--[if $this_publication.pub_language=='pt']--> selected="selected"<!--[/if]-->><!--[$static_content.label9|escape]--></option> 
                                </select>
                            </p>
                        </div>
                    </div>
                    <div class="large-4 columns">
                        <label for="country" class="left"><!--[$static_content.label10|escape]--></label>
                        <div class="error-spacer">
                            <span class="form-error-message" id="country_error">&nbsp;</span>
                            <p>
                                <select class="validate[required]" id="country" name="country" title="Country" <!--[if $smarty.get.pubid neq 'new']-->disabled=true<!--[/if]-->>
                                    <option value=""><!--[$static_content.label11|escape]--></option>
                                    <option data-list="br" value="br"<!--[if $this_publication.pub_country=='br']--> selected="selected"<!--[/if]-->><!--[$static_content.label12|escape]--></option> 
                                    <option data-list="fr" value="fr"<!--[if $this_publication.pub_country=='fr']--> selected="selected"<!--[/if]-->><!--[$static_content.label13|escape]--></option> 
                                    <option data-list="us" value="us"<!--[if $this_publication.pub_country=='us']--> selected="selected"<!--[/if]-->><!--[$static_content.label14|escape]--></option> 
                                </select>
                            </p>
                        </div>
                    </div>
                    <div class="large-4 columns">
                        <label for="frm_publication_slug" class="left"><!--[$static_content.label15|escape]--></label>
                        <input type="text" <!--[if $smarty.get.pubid != 'new']-->class="validate[required]"<!--[/if]--> name="frm_publication_slug" id="frm_publication_slug" placeholder="Type your publications 'slug' here" value="<!--[$this_publication.pub_slug|escape]-->">
                    </div>
                </div>
                <div class="row">
                    <div class="large-12 columns">
                        <input class="button small large-3" type="submit" value="<!--[$static_content.label16|escape]-->" <!--[if $no_edit]-->disabled<!--[/if]-->/>
                        <input type="hidden" name="frm_submit" value=20 />
                        <!--[if isset($smarty.get.pubid)]--><input type="hidden"   name="frm_pub_id" value=<!--[$smarty.get.pubid]--> /><!--[/if]-->
                        <input type="hidden" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
                    </div>
                </div>
            </form>