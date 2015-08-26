<div class="large-8 medium-10 small-12 columns">
<!--[if $debug]--><!--[$smarty.template]--><!--[/if]-->    <div class="callout panel" style="margin-top: 40px;">
        <h1>Seja bem-vindo à DemiMot <!--[$this_user.user_nickname|escape]-->!!!</h1>
        <p>A sua plataforma para criação de Jornais e revistas de qualidade</p>
    </div><hr />
    <div class="block-grid">
        <center><img class="center" src="/css/img/newsstand-clipart-newsstand_CoolClips_vc010005.jpg" width="375" height="316" alt="newsstand" longdesc="http://www.demimot.com"></center>
    </div><hr />
    <div class="panel callout">
        <h3>Congratulations<!--[if $this_user.user_firstname|escape]--> <!--[$this_user.user_firstname|escape]--><!--[/if]-->!!!</h3>
        <h4>Your account has been validated with success.</h4>
        <p>You can login to your account at anytime now</p>
        <p>Name: <!--[$this_user.user_firstname|escape]--> <!--[$this_user.user_lastname|escape]--> - Phone: <!--[$this_user.user_tel|escape]--> - E-mail: <!--[$this_user.user_email|escape]--></p>
    </div>
    <!-- Block of featured Publications with a search box on top 

    Consider yet another template instead of a block... It could be used in may other pages

    -->
    <div class="large-12 columns" style="outline:auto;margin-bottom:15px !important;">
        <h3 class="text-center">Search<h3>
      <!--[foreach name=outer item=featured from=$current_featured]-->      
        <div class="small-12 medium-4 large-3 columns left"><a href="/read-<!--[$featured.pub_slug|escape]-->">
            <!--[assign var="thiscover" value="`$default_img_path``$featured.pub_issue_cover`"]-->
            <div class="panel dmm-featured-pub" style="background-image:url('<!--[demimot_html_createthumb file=$thiscover naked=true height="200" link=false]-->')">
                <center><h4 style="color:red; font-weight:700"><!--[$featured.pub_name|escape]--></h2></center>
            </div></a>
        </div>
      <!--[/foreach]-->
    </div>
</div>