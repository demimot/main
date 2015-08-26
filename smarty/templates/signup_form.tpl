<!--[if $debug]--><!--[$smarty.template]--><!--[/if]--><form action="" name="user_registration" id="user_registration" method="post">
    <div class="row">
        <div class="large-12 columns">
            <h4>Demimot User Registration</h4>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label for="frm_firstname" class="left">First name*</label>
            <input type="text" name="frm_firstname" id="frm_firstname" class="validate[required]" placeholder="Enter your first name" value="">
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label for="frm_lastname" class="left">Last name*</label>
            <input type="text" name="frm_lastname" id="frm_lastname" class="validate[required]" placeholder="Enter your last name" value="">
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label for="frm_nickname" class="left">Nickname*</label>
            <input type="text" name="frm_nickname" id="frm_nickname" class="validate[required]" placeholder="Enter your nickname" value="">
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label for="frm_username" class="left">Username*</label>
            <input type="text" name="frm_username" id="frm_username" class="validate[required]" placeholder="Enter your username" value="">
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label for="frm_passworda" class="left">Password*</label>
            <input type="password" name="frm_passworda" id="frm_passworda" class="validate[required] text-input" placeholder="Enter your password" value="">
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label for="frm_passwordb" class="left">Confirm password*</label>
            <input type="password" name="frm_passwordb" id="frm_passwordb" class="validate[required,equals[frm_passworda]]" placeholder="Confirm password" value="">
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label for="frm_emaila" class="left">e-mail*</label>
            <input type="text" name="frm_emaila" id="frm_emaila" class="validate[required,custom[email]]" placeholder="Enter your e-mail" value="">
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label for="frm_emailb" class="left">e-mail confirmation*</label>
            <input type="text" name="frm_emailb" id="frm_emailb" class="validate[required,custom[email],equals[frm_emaila]]" placeholder="confirm your e-mail" value="">
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label for="frm_telnumber" class="left">Telephone number*</label>
            <input type="text" name="frm_telnumber" id="frm_telnumber" class="validate[custom[phone]]" placeholder="Enter your telephone number e.g. '+55 21 ...'" value="">
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label for="frm_terms" class="left">I have read and agreed to the </label>&nbsp;<a href="/terms-of-service" target="_blank">terms of service</a>&nbsp;&nbsp;
            <input type="checkbox" name="frm_terms" id="frm_terms" class="validate[required]" onchange="checkTerms();">
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <input class="button small large-1" name="userreg_submit" type="submit" value="Register" disabled />
            <input type="hidden" name="frm_submit" value=5 />
            <input type="hidden" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
        </div>
    </div>
</form>