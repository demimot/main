<!--[if $debug]--><span style="color:red;"><!--[$smarty.template]--></span><!--[/if]--><!--[dmm_template_static_content template_name=$smarty.template language=$smarty.session.language assign='static_content']-->
<form id="frm_search_pub_form" name="frm_search_pub_form" action="/" method="get">
    <div class="row collapse">
        <div class="small-9 large-10 columns">
            <input type="text" id="search_pub" name="search_pub" placeholder="<!--[$static_content.label01|escape]-->" value="<!--[if $smarty.get.search_pub]--><!--[$smarty.get.search_pub]--><!--[/if]-->">
        </div>
        <div class="small-3 large-2 columns">
            <input type="submit" class="button postfix" value="<!--[$static_content.label02|escape]-->">
        </div>  
    </div>
</form>