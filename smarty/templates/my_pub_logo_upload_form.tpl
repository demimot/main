<!--[if $debug]--><span style="color:red;"><!--[$smarty.template]--></span><!--[/if]--><!--[dmm_template_static_content template_name=$smarty.template language=$smarty.session.language assign='static_content']-->
                                <form id="frm_pub_logo_form" name="frm_pub_logo_form" action="" method="post" enctype="multipart/form-data">
                                    <div class="row"><div class="large-12 columns">
                                        <label for="frm_image_upload" class="left"><!--[$static_content.label1|escape]--> <!--[$this_publication.pub_logo|escape]--></label>
                                        <!--[if $smarty.get.message]--><label for="frm_image_upload" class="left"><span style="color:red !important;"><!--[$smarty.get.message|escape]--></span></label><!--[/if]-->
                                        <input class="file validate[required]" name="frm_image_upload" id="frm_image_upload" placeholder="Logo filename" type=file>
                                    </div></div>
                                    <!--[if $this_publication.pub_logo]-->
                                    <div class="row">
                                    	<div class="large-12 columns">
                                            <img class="right" src="/<!--[$default_img_path]--><!--[$this_publication.pub_logo]-->" alt="$this_publication.pub_name" name="logo" />
                                    	</div>&nbsp;
                                    </div>
                                    <!--[/if]-->
                                    <div class="row"><div class="large-12 columns">
                                        <input class="button small large-6 right" type="submit" value="<!--[$static_content.label2|escape]-->" <!--[if $no_edit]-->disabled<!--[/if]--> />
                                        <input type="hidden" name="frm_submit" value=22 />
                                        <!--[if isset($smarty.get.pubid)]--><input type="hidden"   name="frm_pub_id" value=<!--[$smarty.get.pubid]--> /><!--[/if]-->
                                        <input type="hidden" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
                                    </div></div>
                                </form>