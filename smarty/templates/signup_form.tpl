<!--[if $debug]--><span style="color:red;"><!--[$smarty.template]--></span><!--[/if]--><!--[dmm_template_static_content template_name=$smarty.template language=$smarty.session.language assign='static_content']-->
<form action="" name="user_registration" id="user_registration" method="post">
    <div class="row">
        <div class="large-12 columns">
            <h4><!--[$static_content.label1|escape]--></h4>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label for="frm_firstname" class="left"><!--[$static_content.label2|escape]--></label>
            <input type="text" name="frm_firstname" id="frm_firstname" class="validate[required]" placeholder="<!--[$static_content.label3|escape]-->" value="">
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label for="frm_lastname" class="left"><!--[$static_content.label4|escape]--></label>
            <input type="text" name="frm_lastname" id="frm_lastname" class="validate[required]" placeholder="<!--[$static_content.label5|escape]-->" value="">
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label for="frm_nickname" class="left"><!--[$static_content.label6|escape]--></label>
            <input type="text" name="frm_nickname" id="frm_nickname" class="validate[required]" placeholder="<!--[$static_content.label7|escape]-->" value="">
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label for="frm_username" class="left"><!--[$static_content.label8|escape]--></label>
            <input type="text" name="frm_username" id="frm_username" class="validate[required]" placeholder="<!--[$static_content.label9|escape]-->" value="">
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label for="frm_passworda" class="left"><!--[$static_content.label10|escape]--></label>
            <input type="password" name="frm_passworda" id="frm_passworda" class="validate[required] text-input" placeholder="<!--[$static_content.label11|escape]-->" value="">
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label for="frm_passwordb" class="left"><!--[$static_content.label12|escape]--></label>
            <input type="password" name="frm_passwordb" id="frm_passwordb" class="validate[required,equals[frm_passworda]]" placeholder="<!--[$static_content.label13|escape]-->" value="">
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label for="frm_emaila" class="left"><!--[$static_content.label14|escape]--></label>
            <input type="text" name="frm_emaila" id="frm_emaila" class="validate[required,custom[email]]" placeholder="<!--[$static_content.label15|escape]-->" value="">
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label for="frm_emailb" class="left"><!--[$static_content.label16|escape]--></label>
            <input type="text" name="frm_emailb" id="frm_emailb" class="validate[required,custom[email],equals[frm_emaila]]" placeholder="<!--[$static_content.label17|escape]-->" value="">
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label for="frm_telnumber" class="left"><!--[$static_content.label18|escape]--></label>
            <input type="text" name="frm_telnumber" id="frm_telnumber" class="validate[custom[phone]]" placeholder="<!--[$static_content.label19|escape]-->" value="">
        </div>
    </div>
    <div class="row" style="margin-bottom:1.5em;">
        <div class="large-12 columns">
            <div class="g-recaptcha" data-sitekey="6LfhLAkTAAAAAPSo7A9NNHyJQ8_HNUXtVhdeEM9o"></div>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label for="frm_terms" class="left"><!--[$static_content.label20|escape]-->*&nbsp;&nbsp;</label>
            <input type="checkbox" name="frm_terms" id="frm_terms" class="validate[required] left" onchange="checkTerms();">
        </div>
    </div>
    <div class="row" style="margin-bottom:1.5em;">
        <div class="large-12 columns">
            <label><a href="/terms-of-service" target="_blank" ><!--[$static_content.label21|escape]--></a></label>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <input class="button small large-4" name="userreg_submit" type="submit" value="<!--[$static_content.label22|escape]-->" disabled />
            <input type="hidden" name="frm_submit" value=5 />
            <input type="hidden" name="frm_xss" value=<!--[$smarty.session.form_xss]--> />
        </div>
    </div>
</form>