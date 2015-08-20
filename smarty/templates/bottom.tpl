    <script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/js/foundation.min.js"></script>
<!--[if $page_has_form]-->
    <script type="text/javascript" src="/js/jve_loc/jquery.validationEngine-en.js"></script>
    <script type="text/javascript" src="/js/jquery.validationEngine.js"></script>
<!--[/if]-->

<!--[if $smarty.get.ta==101]--><!--[include file="ta_101_inc.tpl"]--><!--[/if]-->

    <script type="text/javascript">
    $(document).foundation();	

    $(document).ready(function() {
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
</body>
</html>