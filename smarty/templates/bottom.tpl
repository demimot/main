    <script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/js/foundation.min.js"></script>
<!--[if $page_has_form]-->
    <script type="text/javascript" src="/js/jve_loc/jquery.validationEngine-en.js"></script>
    <script type="text/javascript" src="/js/jquery.validationEngine.js"></script>
    <script type="text/javascript" src="/js/foundation-datepicker.js"></script>
<!--[/if]-->
    <script src="/js/dmm.js"></script>
<!--[if $smarty.get.ta==101]--><!--[include file="ta_101_inc.tpl"]--><!--[/if]-->

    <script type="text/javascript">
    $(document).foundation();	

    $(document).ready(function() {
	
<!--[if !$editing and !$ispreview]-->	    $( "div.placehold" ).replaceWith(""); <!--[/if]-->

<!--[if $smarty.get.ta==101]-->
    <!--[include file="ta_101.tpl"]-->
<!--[elseif $smarty.get.ta==150]-->
    <!--include file="ta_101.tpl"-->
<!--[/if]-->
<!--[if $page_has_form]-->
<!--[foreach name=externo item=form_id from=$this_forms]-->
	    $("#<!--[$form_id]-->").validationEngine();
<!--[/foreach]-->
<!--[/if]-->
} );
    </script>
<!--[if $debug]-->
<pre>

From <!--[$smarty.template]-->:
GET
<!--[$smarty.get|var_dump]-->

SESSION
<!--[$smarty.session|var_dump]-->

$_SERVER['HTTP_HOST']
<!--[$smarty.server.HTTP_HOST|var_dump]-->


HOST - commented
<!--$smarty.server|var_dump-->
<pre>
<!--[/if]-->    
</body>
</html>