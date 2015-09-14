<ul class="clearing-thumbs small-block-grid-5" data-clearing >
<!--[if $debug]--><span style="color:red;"><!--[$smarty.template]--></span><!--[/if]-->
<!--[foreach name=externo item=article_img from=$article_image]-->
    <li>
        <a href='/<!--[$default_img_path]--><!--[$article_img.article_image_filename]-->'><img data-caption='<!--[$article_img.article_image_caption]--><br><!--[$article_img.article_image_credits]-->' src='<!--[demimot_html_createthumb file="`$default_img_path``$article_img.article_image_filename`" naked=true height="100" link=false]-->'></a>
    </li>
<!--[/foreach]-->
</ul>