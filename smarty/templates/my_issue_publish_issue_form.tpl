                    <form id="frm_publish_issue_form" name="frm_publish_issue_form" action="" method="post">
                        <div class="row large-12">
                            <input class="button small large-6" id="publish" type="submit" value="Publish Issue" disabled/>
                        </div>
                        <div class="row large-12" >
                            <input type="checkbox" class="validate[required]" name="frm_check_publish_issue" id="frm_check_publish_issue" onchange="document.getElementById('publish').disabled=!document.getElementById('frm_check_publish_issue').checked"> I Choose to publish this issue now.
                            <input type="hidden" name="frm_submit" value=100 />
                            <input type="hidden" name="frm_pub_issue_id" value=<!--[$this_issue.pub_issue_id]--> />
                            <input type="hidden" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
                        </div> 	            
                    </form>