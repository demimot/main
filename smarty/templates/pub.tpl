<div class="row">
    <div class="large-12 medium-12 columns">
        <div class="row">
            <div class="large-2 medium-1 small-0 columns">&nbsp;</div>
            <div class="large-8 medium-10 small-12 columns" style="margin-top: 40px; /* for allowing space below navigation bar */">
                <a href="?pub=<!--[$this_pub.pub_issue_id|escape]-->&issue=<!--[$this_pub.pub_issue|escape]-->"><h1><strong><!--[$this_pub.pub_name|escape]--></strong></h1>
                    <h5><!--[$this_pub.pub_mote|escape]--></h5>
                    <p>issue: <!--[$this_pub.pub_issue|escape]--></p>
                </a>
                    <!--<pre> <!--$this_content|@var_dump-->  <!--</pre>-->      
                <dl class="accordion" data-accordion id='accordion'>
                    <!--[foreach name=externo item=article from=$this_content]-->
                    <dd class="accordion-navigation">
                        <!--[dmm_article_image_handler assign='article_image' article_id=$article.article_id ]--><!-- 
                                                                                                                      This should go... 
                                                                                                                      It should be in the controler, not in the template... 
                                                                                                                      it is not an output funtion but a content retrieving function 
                                                                                                                      
                                                                                                                      -->
                        <a href="#panel<!--[$article.article_id|escape]-->b">
                            <!--[if $article_image[0].article_image_filename]-->
                                <div class="pub_article_thumb" style="background-image:url('<!--[demimot_html_createthumb file="`$default_img_path``$article_image[0].article_image_filename`" naked=true height="100" link=false]-->')"></div>
                            <!--[/if]-->
                            <h2><!--[$article.article_title|escape]--></h2><h5><!--[$article.article_subtitle|escape]--></h5>
                            <!--[if $article.article_source]-->source: <!--[$article.article_source|escape]--><!--[/if]-->
                        </a>
                        <div id="panel<!--[$article.article_id]-->b" class="content<!--[if $smarty.foreach.externo.first]--> active<!--[/if]-->" data-slug="panel<!--[$article.article_id]-->b">
                        <!--[if $article_image[0].article_image_filename]-->
                            <!--[include file="article_img.tpl"]-->
                        <!--[/if]-->
                        <!--[p_tag_this string=$article.article_body|escape article=$article.article_id|escape]--><!--[$teste]-->
                        
                        </div>
                    </dd>
                    <hr />
                    <!--[/foreach]-->
                </dl>
            </div>
            <div class="show-for-large-up">
                <div class="large-2 medium-0 small-0 columns">
                    <h5>This could be a publicity area for Demimot Publications</h5>
                    <p><a href="#" class="small button">Simple Button</a><br/>
                    <a href="#" class="small radius button">Radius Button</a><br/>
                    <a href="#" class="small round button">Round Button</a><br/>            
                    <a href="#" class="medium success button">Success Btn</a><br/>
                    <a href="#" class="medium alert button">Alert Btn</a><br/>
                    <a href="#" class="medium secondary button">Secondary Btn</a></p>           
                </div>
            </div>               
            <div class="large-0 medium-1 small-0 columns">&nbsp;</div>
        </div>
    </div>
</div>
<div class="hide-for-large-up"><!-- medium and small only pub area -->
    <div class="row">
        <div class="medium-12 small 12 columns">
            <div class="medium-1 small-0 columns">&nbsp;</div>
            <div class="medium-10 small-0 columns">
                <h5>This could be a publicity area for Demimot Publications</h5>
                <p><a href="#" class="small button">Simple Button</a><br/>
                <a href="#" class="small radius button">Radius Button</a><br/>
                <a href="#" class="small round button">Round Button</a><br/>            
                <a href="#" class="medium success button">Success Btn</a><br/>
                <a href="#" class="medium alert button">Alert Btn</a><br/>
                <a href="#" class="medium secondary button">Secondary Btn</a></p>           
            </div>
            <div class="medium-1 small-0 columns">&nbsp;</div>
        </div>
    </div>
</div>