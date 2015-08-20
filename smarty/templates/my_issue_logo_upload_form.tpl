                        <form id="frm_logo_file_form"  action="" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <label for="frm_image_upload" class="left">Issue Logo: <!--[$this_issue.pub_issue_logo|escape]--></label>
                                <!--[if $smarty.get.msglogo]--><label for="frm_image_upload" class="left"><span style="color:red !important;">&nbsp;<!--[$smarty.get.msglogo|escape]--></span></label><!--[/if]-->
                                <input class="file validate[required]" name="frm_image_upload" id="frm_image_upload" placeholder="Logo filename" type=file>
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