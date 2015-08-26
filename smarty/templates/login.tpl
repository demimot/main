<div class="panel callout" style="margin-top: 40px;">
<!--[if $debug]--><!--[$smarty.template]--><!--[/if]-->
<form action="/" method="post">
    <div class="row">
        <div class="large-12 columns">
            <h5>Login na DemiMot</h5>
            <div class="row">
                <div class="large-4 columns">
                    <label for="right-label" class="right inline">Username:</label>
                </div>
                <div class="large-8 columns">
                    <input type="text" name="frm_username" id="frm_username" placeholder="Username">
                </div>
            </div>
            <div class="row">
                <div class="large-4 columns">
                    <label for="right-label" class="right inline">Password:</label>
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
<div class="row">&nbsp;</div>
<p><a href="/signup">Registration</a></p>
</div>