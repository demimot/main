<div class="large-8 medium-10 small-12 columns"><!--[if $debug]--><span style="color:red;"><!--[$smarty.template]--></span><!--[/if]--><!--[dmm_template_static_content template_name=$smarty.template language=$smarty.session.language assign='static_content']-->
    <div class="callout panel" style="margin-top: 20px;">
        <h1><!--[$static_content.welcome|escape]--> <!--[$dmm_user.user_nickname|escape]-->!!!</h1>
        <p><!--[$static_content.mote|escape]--></p>
    </div>
    <!--[include file='newsstand_banner.tpl']-->
    <div class="panel">
      <!--[if isset($smarty.session.user_id)]-->
        <h4><!--[$static_content.session_discl1|escape]--></h4>
        <p><!--[$static_content.session_discl2|escape]--> <!--[$dmm_user.user_firstname|escape]--> <!--[$dmm_user.user_lastname|escape]--> - <!--[$static_content.session_discl3|escape]--> <!--[$dmm_user.user_tel|escape]--> - <!--[$static_content.session_discl4|escape]--> <!--[$dmm_user.user_email|escape]--></p>
      <!--[else]-->
        <h4><!--[$static_content.no_session_discl1|escape]--></h4>
      <!--[/if]-->
    </div>
    <!-- Block of featured Publications with a search box on top 
    The Logic for featured and the quantity of featured TBD  
    It is supposed to be an smarty array of pub names, indexes and cover images for thumbnails
    It is suposed not to have an defined issue and so, the most recent will be serverd
    in each pub there should be a link for past issues browsing and selecting
    -->
    <!--[include file='featured_pubs.tpl']-->
</div>