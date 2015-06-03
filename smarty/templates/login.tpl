<div class="row">&nbsp;</div><div class="row">&nbsp;</div>
<form action="/index.php" method="post">
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
                    <input class="button small large-12" type="submit" value="Ok" /><input type="hidden" name="frm_submit" value=1 />
                    <!--[if isset($smarty.get.pub)]--><input type="hidden"   name="frm_pub" value=<!--[$smarty.get.pub]--> /><!--[/if]-->
                    <!--[if isset($smarty.get.issue)]--><input type="hidden" name="frm_issue" value=<!--[$smarty.get.issue]--> /><!--[/if]-->
                </div>
            </div>
        </div>
    </div>
</form>