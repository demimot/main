<!--[if $debug]--><span style="color:red;"><!--[$smarty.template]--></span><!--[/if]--><!--[dmm_template_static_content template_name=$smarty.template language=$smarty.session.language assign='static_content']-->
                    <form id="frm_publish_issue_form" name="frm_publish_issue_form" action="" method="post" onsubmit="return confirm_publishing();">
                        <div class="row large-12">
                            <input class="button small large-6" name="publish" id="publish" type="submit" value="Publish Issue" disabled/>
                        </div>
                        <div class="row large-12" >
                            <input type="checkbox" class="validate[required]" name="frm_check_publish_issue" id="frm_check_publish_issue" onchange="document.getElementById('publish').disabled=!document.getElementById('frm_check_publish_issue').checked;
 alert"> <!--[$static_content.label01|escape]--> 
<!--[if $smarty.get.blocking]--><p><span style="color:red;word-wrap:true"><!--[$static_content.label02|escape]--><br />
<!--[$static_content.label03|escape]--> <br /><!--[$static_content.label04|escape]--></span></p><!--[/if]-->
                            <input type="hidden" name="frm_submit" value=100 />
                            <input type="hidden" name="frm_pub_issue_id" value=<!--[$this_issue.pub_issue_id]--> />
                            <input type="hidden" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
                        </div> 	            
                    </form>