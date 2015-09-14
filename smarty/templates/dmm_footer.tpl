<!--[dmm_template_static_content template_name=$smarty.template language=$smarty.session.language assign='static_content']--><div class="dmm-footer-bottom">
    <div class="row">
       <div class="large-12 columns center">
           <ul class="inline-list dmm-vertical-sep">
               <li><a href="/"><!--[$static_content.label1|escape]--></a></li>
               <li><a href="/about"><!--[$static_content.label2|escape]--></a></li>
               <li><a href="/contribute"><!--[$static_content.label3|escape]--></a></li>
               <li><a href="/contact"><!--[$static_content.label4|escape]--></a></li>
           </ul>
       <!--[if $debug]--><span style="color:red;"><!--[$smarty.template]--></span><!--[/if]-->
    </div>
</div>
