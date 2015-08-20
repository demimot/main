                        <form id="frm_cover_file_form" name="frm_cover_file_form" action="" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <label for="frm_image_upload" class="left">Issue Cover: <!--[$this_issue.pub_issue_cover|escape]--></label>
                                <!--[if $smarty.get.msgcover]--><label for="frm_image_upload" class="left"><span style="color:red !important;">&nbsp;<!--[$smarty.get.msgcover|escape]--></span></label><!--[/if]-->
                                <input class="file validate[required]" name="frm_image_upload" id="frm_image_upload" placeholder="Cover filename" type=file>
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