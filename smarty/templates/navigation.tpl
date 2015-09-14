<div class="fixed"><!--[dmm_template_static_content template_name=$smarty.template language=$smarty.session.language assign='static_content']-->
    <nav class="top-bar dmm-top-bar" data-topbar>
        <ul class="title-area">
            <li class="name"><h1><a href="/"><!--[$name]--><!--[if $debug]-->-<!--[$smarty.template]--><!--[/if]--></a></h1></li>
            <li class="toggle-topbar menu-icon"><a href="/">Menu</a></li>
        </ul>
        <section class="top-bar-section dmm-top-bar-section">
            <ul class="right">
                    <li class="dmm-active" style="min-width:6em"><!--[if $not_demimot]--><a href="http://www.demimot.com/home"><!--[$static_content.HomeMenu]--> (DemiMot)</a><!--[else]--><a href="/home"><!--[$static_content.HomeMenu]--></a><!--[/if]--></li>
                    <li class="dmm-active" style="min-width:5em;"><a href="<!--[$LoginMenuUrl]-->" <!--[if not isset($smarty.session.user_id)]-->data-reveal-id="login"><!--[$static_content.LoginMenu]--><!--[else]-->><!--[$static_content.LogOffMenu]--><!--[/if]--></a></li>
                    <!--[if not isset($smarty.session.user_id)]-->
                    <li class="dmm-active" style="min-width:6em"><a href="/signup"><!--[$static_content.SignUpMenu]--></a></li>
                    <!--[/if]-->
                    <li class="has-dropdown" style="min-width:5em"><a href="/"><!--[$static_content.InfoMenu]--></a>

                    <ul class="dropdown">
                        <li class="dmm-active"><a href="/"><!--[$static_content.HowToMenu]--></a></li>
                        <li class="dmm-active"><a href="/"><!--[$static_content.ColaborateMenu]--></a></li>
                        <li class="dmm-active"><a href="/"><!--[$static_content.HelpMenu]--></a>
                        </li>
                    </ul>
                </li>
                <li class="has-dropdown" style="min-width:6em"><a href="/"><!--[$static_content.AboutMenu]--></a>
                    <ul class="dropdown">
                        <li style="min-width:12em"><a href="/"><!--[$static_content.WhoMenu]--></a></li>
                        <li><a href="/"><!--[$static_content.ContactMenu]--></a></li>
                        <li><a href="/"><!--[$static_content.SocialMenu]--></a></li>
                        <li><a href="/terms-of-service"><!--[$static_content.TermsOfUse]--></a></li>
                        <li><a href="/privacy-policy"><!--[$static_content.PrivacyPolicy]--></a></li>
                    </ul>
                </li>
                <li class="dmm-active" style="min-width:0.5em;margin-right:5px;margin-top:-1.8px;float:inherit">
                    <!--[langswitch assign='otherlangs' lang=$smarty.session.language]-->
                    <a href="?lang=<!--[$otherlangs.lang1]-->" >
                        <img src="/css/img/<!--[$otherlangs.flag1]-->" width="20" height="13" alt="<!--[$otherlangs.lang1]-->" />
                    </a>
                </li>
                <li class="dmm-active" style="min-width:0.5em;margin-right:5px;margin-top:-1.8px;float:inherit">
                    <a href="?lang=<!--[$otherlangs.lang2]-->" >
                        <img src="/css/img/<!--[$otherlangs.flag2]-->" width="20" height="13" alt="<!--[$otherlangs.lang2]-->" />
                    </a>
                </li>
            </ul>
        </section>
    </nav>
</div>