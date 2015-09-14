<!--[if $debug]--><span style="color:red;"><!--[$smarty.template]--></span><!--[/if]--><!--[dmm_template_static_content template_name=$smarty.template language=$smarty.session.language assign='static_content']-->
    <div class="large-12 columns" style="margin-bottom:15px !important;">
        <h3 class="text-center"><!--[include file='search_pub.tpl']--><h3>
      <!--[foreach name=outer item=featured from=$current_featured]-->      
        <div class="small-12 medium-4 large-3 columns left"><a href="/read-<!--[$featured.pub_slug|escape]-->">
            <!--[assign var="thiscover" value="`$default_img_path``$featured.pub_issue_cover`"]-->
            <div class="panel dmm-featured-pub" <!--[if $featured.pub_issue_cover]-->style="background-image:url('<!--[demimot_html_createthumb file=$thiscover naked=true height="200" link=false]-->')"<!--[/if]-->>
                <center><h4 style="color:red; font-weight:700"><!--[$featured.pub_name|escape]--></h2></center>
            </div></a>
        </div>
      <!--[/foreach]-->
    </div>