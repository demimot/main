<div class="fixed">
    <div class="row">
    <div class="large-12 columns">
    
        <nav class="top-bar dmm-top-bar" data-topbar>
            <ul class="title-area">
                <li class="name"><h1><a href="/"><!--[$name]--></a></h1></li>
                <li class="toggle-topbar menu-icon"><a href="/">Menu</a></li>
            </ul>
            <section class="top-bar-section dmm-top-bar-section">
            <!-- Right Nav Section -->
                <ul class="right">
                    <!--[if !isset($smarty.session.user_id)]--><div class="hide-for-large-up"><!--[/if]-->
                    <li class="dmm-active" style="min-width:5em;"><a href="/?<!--[$LoginMenuUrl]-->"><!--[$LoginMenu]--></a></li>
                    <!--[if !isset($smarty.session.user_id)]--></div><!--[/if]-->
                    <li class="has-dropdown" style="min-width:4em"><a href="/"><!--[$InfoMenu]--></a>
                        <ul class="dropdown">
                            <li class="dmm-active" style="min-width:12em"><a href="/"><!--[$NewsMenu]--></a></li>
                            <li class="dmm-active"><a href="/"><!--[$CalendarMenu]--></a></li>
                            <li class="dmm-active"><a href="/"><!--[$ResultsMenu]--></a></li>
                            <li class="has-dropdown"><a href="/"><!--[$MediaMenu]--></a>
                                <ul class="dropdown">
                                    <li><a href="/"><!--[$GalleryMenu]--></a></li>
                                    <li><a href="/"><!--[$VideoMenu]--></a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="has-dropdown" style="min-width:6em"><a href="/"><!--[$AboutMenu]--></a>
                        <ul class="dropdown">
                            <li style="min-width:12em"><a href="/"><!--[$WhoMenu]--></a></li>
                            <li><a href="/"><!--[$ContactMenu]--></a></li>
                            <li><a href="/"><!--[$SocialMenu]--></a></li>
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
            <!-- Left Nav Section -->
            <!-- <ul class="left">
                <li><a href="#">Left Nav Button</a></li>
            </ul> -->
          </section>
        </nav>
    </div>
    </div>
    <div class="row">
    <div class="large-12 columns">&nbsp;<!--[myfunc assign='vidalouca' passtext='']--><!--[$vidalouca]--></div>
</div>
</div>