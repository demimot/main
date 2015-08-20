            <form id="frm_publication_form" name="frm_publication_form" action="" method="post">
                <div class="row">
                    <div class="large-12 columns">
                        <label for="left-label" class="left">Name:</label>
                        <input type="text" class="validate[required]" name="frm_publication_name" id="frm_publication_name" placeholder="Type your publication name here" value="<!--[$this_publication.pub_name|escape]-->">
                    </div>
                </div>
                <div class="row">
                    <div class="large-12 columns">
                        <label for="left-label" class="left">Mote:</label>
                        <input type="text" class="validate[required]" name="frm_publication_mote" id="frm_publication_mote" placeholder="Type your publication mote here" value="<!--[$this_publication.pub_mote|escape]-->">
                    </div>
                </div>
                <div class="row">
                    <div class="large-4 columns">
                        <label for="left-label" class="left">Language:</label>
                        <div class="error-spacer">
                            <span class="form-error-message" id="country_error">&nbsp;</span>
                            <p>
                                <select class="validate[required]" id="language" name="language" title="language">
                                    <option value="">Language</option>
                                    <option data-list="en" value="en"<!--[if $this_publication.pub_language=='en']--> selected="selected"<!--[/if]-->>English</option> 
                                    <option data-list="fr" value="fr"<!--[if $this_publication.pub_language=='fr']--> selected="selected"<!--[/if]-->>French</option> 
                                    <option data-list="pt" value="pt"<!--[if $this_publication.pub_language=='pt']--> selected="selected"<!--[/if]-->>Portuguese</option> 
                                </select>
                            </p>
                        </div>
                    </div>
                    <div class="large-4 columns">
                        <label for="left-label" class="left">Country:</label>
                        <div class="error-spacer">
                            <span class="form-error-message" id="country_error">&nbsp;</span>
                            <p>
                                <select class="validate[required]" id="country" name="country" title="Country">
                                    <option value="">Country</option>
                                    <option data-list="us" value="us"<!--[if $this_publication.pub_country=='us']--> selected="selected"<!--[/if]-->>United States</option> 
                                    <option data-list="fr" value="fr"<!--[if $this_publication.pub_country=='fr']--> selected="selected"<!--[/if]-->>France</option> 
                                    <option data-list="br" value="br"<!--[if $this_publication.pub_country=='br']--> selected="selected"<!--[/if]-->>Brasil</option> 
                                </select>
                            </p>
                        </div>
                    </div>
                    <div class="large-4 columns">
                        <label for="left-label" class="left">Slug (friendly url):</label>
                        <input type="text" <!--[if $smarty.get.pubid != 'new']-->class="validate[required]"<!--[/if]--> name="frm_publication_slug" id="frm_publication_slug" placeholder="Type your publications 'slug' here" value="<!--[$this_publication.pub_slug|escape]-->">
                    </div>
                </div>
                <div class="row">
                    <div class="large-12 columns">
                        <input class="button small large-1" type="submit" value="Save" <!--[if $no_edit]-->disabled<!--[/if]-->/>
                        <input type="hidden" name="frm_submit" value=20 />
                        <!--[if isset($smarty.get.pubid)]--><input type="hidden"   name="frm_pub_id" value=<!--[$smarty.get.pubid]--> /><!--[/if]-->
                        <input type="hidden" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
                    </div>
                </div>
            </form>