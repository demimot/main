            <div class="large-8 medium-10 small-12 columns">
                <div class="callout panel" style="margin-top: 40px;">
                    <h1>Seja bem-vindo à DemiMot <!--[$dmm_user.user_nickname|escape]-->!!!</h1>
                    <p>A sua plataforma para criação de Jornais e revistas de qualidade</p> <pre> <!--$dmm_user|@var_dump-->  </pre>
                </div><hr />
                <div class="block-grid">
                    <center><img class="center" src="/css/img/newsstand-clipart-newsstand_CoolClips_vc010005.jpg" width="375" height="316" alt="newsstand" longdesc="http://www.demimot.com"></center>
                </div><hr />
                <div class="panel"><!--[$onde]-->
                    <!--[if isset($smarty.session.user_id)]-->
                    <h4>Tanto a dizer, e tão pouco tempo!</h4>
                    <p>Name: <!--[$dmm_user.user_firstname|escape]--> <!--[$dmm_user.user_lastname|escape]--> - Phone: <!--[$dmm_user.user_tel|escape]--> - E-mail: <!--[$dmm_user.user_email|escape]--></p>
                    <!--[else]-->
                    <h4>Tanto a ler, e tão pouco tempo!</h4>
                    <!--[/if]-->
                </div>
                 <!-- Block of featured Publications with a search box on top 
                 The Logic for featured and the quantity of featured TBD  
                 It is supposed to be an smarty array of pub names, indexes and cover images for thumbnails
                 It is suposed not to have an defined issue and so, the most recent will be serverd
                 in each pub there should be a link for past issues browsing and selecting
                 -->
                <div class="large-12 columns" style="outline:auto;margin-bottom:15px !important;">
                <h3 class="text-center">Search<h5>
                
                <!--[foreach name=outer item=featured from=$current_featured]-->      
                    <div class="small-12 medium-4 large-3 columns"><a href="/read-<!--[$featured.pub_slug|escape]-->">
                        <!--[assign var="thiscover" value="`$default_img_path``$featured.pub_issue_cover`"]-->
                        <div class="panel dmm-featured-pub" style="background-image:url('<!--[demimot_html_createthumb file=$thiscover naked=true height="200" link=false]-->')">
                            <center><h4 style="color:red; font-weight:700"><!--[$featured.pub_name|escape]--></h2></center>
                        </div></a>
                    </div>
                <!--[/foreach]-->
                <div class="small-12 medium-4 large-3 columns"><a href="/?piid=BBBB">
                          <div class="panel" style="min-height: 200px;background-color:transparent;background-image:url('<!--[demimot_html_createthumb file='img/newsstand-clipart-news_stand_CoolClips_vc015998.jpg' naked=true height="200" link=false html="class='img float'"]-->')"><center><!--<a class="th" role="button" aria-label="Thumbnail" href="/?piid=BBBB">
                             <!--<img style="max-height:120px;" src="/img/newsstand-clipart-news_stand_CoolClips_vc015998.jpg" width="150" link=false  class="img float" /></a>--><h2 style="color:red; font-weight:900">BBBB</h2></center>
                          </div></a>
                </div>
                </div>
            </div>