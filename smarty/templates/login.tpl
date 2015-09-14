<div id="login" name="login" class="reveal-modal tiny" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog"><!--[dmm_template_static_content template_name=$smarty.template language=$smarty.session.language assign='static_content']--><!--[if $debug]--><span style="color:red;"><!--[$smarty.template]--></span><!--[/if]-->
<form action="" method="post">
    <div class="row">
        <div class="large-12 columns">
            <h5><!--[$static_content.login|escape]--></h5>
            <div class="row">
                <div class="large-4 columns">
                    <label for="right-label" class="right inline"><!--[$static_content.username|escape]--></label>
                </div>
                <div class="large-8 columns">
                    <input type="text" name="frm_username" id="frm_username" placeholder="Username">
                </div>
            </div>
            <div class="row">
                <div class="large-4 columns">
                    <label for="right-label" class="right inline"><!--[$static_content.password|escape]--></label>
                </div>
                <div class="large-8 columns">
                    <input type="password" id="frm_password" name="frm_password" placeholder="Password">
                </div>
            </div>
            <div class="row">
                <div class="large-4 columns">&nbsp;</div>
                <div class="large-8 columns">
                    <input class="button small large-12" type="submit" value="Ok" />
                    <input type="hidden" name="frm_submit" value=1 />
                    <input type="hidden" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
                    <input type="hidden" name="called_from" value=<!--[$called_uri]--> />
                </div>
            </div>
        </div>
    </div>
</form>
<div class="row"><hr /></div>

<a class="tiny button large-8" href="/signup"><!--[$static_content.registration|escape]--></a>
<!--[if $smarty.session.reset_pwd]-->
<a class="tiny button large-8" href="/password-reset"><!--[$static_content.label05|escape]--></a>
<!--[/if]-->
</div>