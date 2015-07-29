<div class="large-8 medium-10 small-12 columns" style="margin-top: 40px;"><!-- for allowing space below navigation bar -->
<div class="row">
<div class="panel<!--[if $smarty.get.pubid=='new']--> callout<!--[/if]-->">
    <div class="row">
        <div class="large-12 columns">
            <h4>Publication: <!--[$this_publication.pub_name|escape]--></h4>
            <p>Created by <strong><!--[$dmm_user.user_nickname|escape]--></strong> on <strong><!--[$this_publication.pub_tstamp|escape]--></strong> </p>
        </div>
    </div>
    <form action="" method="post">

    <div class="row">
        <div class="large-12 columns">
            <label for="left-label" class="left">Name:</label>
            <input type="text" name="frm_publication_name" id="frm_publication_name" placeholder="Type your publication name here" value="<!--[$this_publication.pub_name|escape]-->">
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label for="left-label" class="left">Mote:</label>
            <input type="text" name="frm_publication_mote" id="frm_publication_mote" placeholder="Type your publication mote here" value="<!--[$this_publication.pub_mote|escape]-->">
        </div>
    </div>
    <div class="row">
        <div class="large-4 columns">
            <label for="left-label" class="left">Language:</label>
            <div class="error-spacer">
                <span class="form-error-message" id="country_error">&nbsp;</span>
                <p>
                    <select id="language" name="language" title="language">
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
                    <select id="country" name="country" title="Country">
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
            <input type="text" name="frm_publication_slug" id="slug" placeholder="Type your publications 'slug' here" value="<!--[$this_publication.pub_slug|escape]-->">
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <input class="button small large-1" type="submit" value="Save" <!--[if $no_edit]-->disabled<!--[/if]-->/>
            <input type="hidden" name="frm_submit" value=20 />
            <!--[if isset($smarty.get.pubid)]--><input type="hidden"   name="frm_publication_id" value=<!--[$smarty.get.pubid]--> /><!--[/if]-->
            <input type="hidden" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
        </div>
    </div>
    </form>
</div>
</div>
<!--[if $smarty.get.pubid!='new']-->
<div class="row">
<div class="panel callout">
    <div class="row">
        <div class="large-12 columns">
            <h6>Default settings: <!--[$this_publication.pub_name|escape]--></h6>
            <p>CSS</p>
            <div class="large-4 columns" >
                <form action="" method="post">
                <div class="row">
                    <label for="left-label" class="left">CSS:</label>
                    <textarea name="frm_publication_css" id="frm_publication_css" placeholder="Type your default CSS" style="min-height: 275px;"><!--[$this_publication.pub_css|escape]--></textarea>
                </div>
                <div class="row">
                    <input class="button small large-4" type="submit" value="Save CSS" <!--[if $no_edit]-->disabled<!--[/if]-->/>
                    <input type="hidden" name="frm_submit" value=21 />
                    <!--[if isset($smarty.get.pubid)]--><input type="hidden"   name="frm_publication_id" value=<!--[$smarty.get.pubid]--> /><!--[/if]-->
                    <input type="hidden" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
                </div>
                </form>
            </div>
            <div class="large-4 columns" >
               
                <form action="" method="post">
                <div class="row">
                <div class="large-12 columns">
                <label for="left-label" class="left">Sections:</label>
                <select name="frm_sections" id="frm_sections" multiple onchange="$('#frm_section_name').val($('#frm_sections option:selected').text());
                                                                                 $('#frm_section_name').prop('readonly', true);
                                                                                 $('#frm_section_order').val($('#frm_sections option:selected').attr('data-order'));
                                                                                 $('#frm_section_verb').val('delete');
                                                                                 $('#btn_section').prop('value', 'Delete Section');" style="min-height:200px;" <!--[if not $this_pub_sections]-->disabled<!--[/if]--> >
                    <!--[if not $this_pub_sections]--><option>Use below text area to create sections</option><!--[/if]-->
                    <!--[foreach name=externo item=pub_section from=$this_pub_sections]-->
                    <option data-order="<!--[$pub_section.section_order]-->" value="<!--[$pub_section.section_id]-->"><!--[$pub_section.section_name]--></option>
                    <!--[/foreach]-->
                </select>
                </div>
                </div>
                <div class="row">
                <div class="large-9 columns">
                <label for="left-label" class="left">Add section:</label>
                <input type="text" name="frm_section_name" id="frm_section_name" placeholder="Type your section name here" value="">
                </div>
                <div class="large-3 columns">                
                <label for="left-label" class="left">Order:</label>
                <input type="text" name="frm_section_order" id="frm_section_order" placeholder="Type your section order here" value="">
                </div>
                </div>
                <div class="row">
                <input class="button small large-5" id="btn_section" type="submit" value="Add Section" <!--[if $no_edit]-->disabled<!--[/if]-->/>&nbsp;&nbsp;&nbsp;
                <a href="" class="button small large-5" id="btn_cancel" type="button" style="color:white">Cancel</a>
                <input type="hidden" name="frm_submit" value=23 />
                <!--[if isset($smarty.get.pubid)]--><input type="hidden"   name="frm_publication_id" value=<!--[$smarty.get.pubid]--> /><!--[/if]-->
                <input type="hidden"   name="frm_section_verb" id="frm_section_verb" value="add">
                <input type="hidden" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
                </div>                      
                </form>
            </div>
            <div class="large-4 columns" >
                <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <label for="file" class="left">Logo: <!--[$this_publication.pub_logo|escape]--></label>
                    <!--[if $smarty.get.message]--><label for="left-label" class="left">Message: <!--[$smarty.get.message|escape]--></label><!--[/if]-->
                    <input class="file" name="frm_publication_logo" id="frm_publication_logo" placeholder="Logo filename" type=file>
                </div>
                <!--[if $this_publication.pub_logo]-->
                <div class="row">
                    <img src="<!--[demimot_html_createthumb file="`$default_img_path``$this_publication.pub_logo`" naked=true height="100" link=false]-->" alt="$this_publication.pub_name" name="logo" />
                </div>
                <!--[/if]-->
                <div class="row">
                    <input class="button small large-4" type="submit" value="Save Logo" <!--[if $no_edit]-->disabled<!--[/if]--> />
                    <input type="hidden" name="frm_submit" value=22 />
                    <!--[if isset($smarty.get.pubid)]--><input type="hidden"   name="frm_publication_id" value=<!--[$smarty.get.pubid]--> /><!--[/if]-->
                    <input type="hidden" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
                </div>
                </form>
            </div>        
        </div>
    </div>
</div>
</div>
<div class="row">
<div class="panel callout">
    <div class="row">
        <div class="large-12 columns">
            <h6><!--[$this_publication.pub_name|escape]--> Issues</h6>
            <form action="" method="post">
                <input class="button small large-3" type="submit" value="Create new Issue" />
                <!--[if isset($smarty.get.pubid)]--><input type="hidden"   name="frm_publication_id" value=<!--[$smarty.get.pubid]--> /><!--[/if]-->
                <input type="hidden" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
                <input type="hidden" name="frm_submit" value=25 />
            </form>
        </div>
    </div>    
    <div class="row">
        <div class="large-4 columns left" >
            <form action="" method="post">
            <label for="left-label" class="left">Published issues:</label>
                <select name="pub_issues" multiple style="min-height:200px;" <!--[if not $published_issues]-->disabled<!--[/if]--> >
                    <!--[if not $published_issues]--><option>No Published issues so far</option><!--[/if]-->
                    <!--[foreach name=externo item=pub_issue from=$published_issues]-->
                        <option value="<!--[$pub_issue.pub_issue_id]-->"><!--[$pub_issue.pub_name]--> - <!--[$pub_issue.pub_issue]--></option>
                    <!--[/foreach]-->
                </select>
                <input class="button small large-5" id="btn_section" type="submit" value="xxx Issue" <!--[if $no_edit]-->disabled<!--[/if]-->/>
                <input type="hidden" name="frm_submit" value=24 />
                <!--[if isset($smarty.get.pubid)]--><input type="hidden"   name="frm_publication_id" value=<!--[$smarty.get.pubid]--> /><!--[/if]-->
                <input type="hidden" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
            </form>
        </div>
        <div class="large-4 columns left" >
            <form action="" method="post">
            <label for="left-label" class="left" >Unpublished issues:</label>
                <select name="unpub_issues" multiple style="min-height:200px;" <!--[if not $unpublished_issues]-->disabled<!--[/if]-->  >
                    <!--[if not $unpublished_issues]--><option>No unpublished issues so far</option><!--[/if]-->
                    <!--[foreach name=externo item=pub_issue from=$unpublished_issues]-->
                        <option value="<!--[$pub_issue.pub_issue_id]-->" ><!--[$pub_issue.pub_name]--> - <!--[$pub_issue.pub_issue]--></option>
                    <!--[/foreach]-->
                </select>
                <input class="button small large-5"  id="btn_gotoissue" type="submit" value="xxx Issue"/>
                <input type="hidden" name="frm_submit" value=26 />
                <!--[if isset($smarty.get.pubid)]--><input type="hidden"   name="frm_publication_id" value=<!--[$smarty.get.pubid]--> /><!--[/if]-->
                <input type="hidden" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
            </form>
        </div>
    </div>
</div>
</div>
<!--[/if]-->
</div>