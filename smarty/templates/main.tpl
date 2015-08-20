<div class="row">
    <div class="large-12 medium-12 small 12 columns">
        <div class="row">
<!--Start Left Blocks-->
            <div class="large-2 medium-1 small-0 columns">
                <div class="row">&nbsp;</div>
                <div class="row">&nbsp;</div>
                <!--[include file="pub_old_issues_block.tpl"]-->
                <!--[if isset($smarty.session.user_id)]-->
                    <!--[include file="pubs_admin.tpl"]-->
                    <!--[include file="articles_admin.tpl"]-->
                <!--[/if]-->
                &nbsp;
            </div>
<!--End Left Blocks-->
<!--Start Center Block-->
            
            <!--[include file=$current_pub_tpl]-->
            
<!--End Center Block-->
            <div class="show-for-large-up"> 
<!--Start Right Blocks-->
            <!--[if !isset($smarty.session.user_id)]-->
                <div class="large-2 medium-0 small-0 columns">
                <!--[include file="login.tpl"]-->
                </div>
            <!--[/if]-->
                <div class="large-2 medium-0 small-0 columns">
                    <!--[include file="right_block_adds.tpl"]-->          
                </div>
            </div>               
<!--End Right Blocks-->
            <div class="large-0 medium-1 small-0 columns">&nbsp;</div>
        </div>
    </div>
</div>
<div class="hide-for-large-up"><!-- medium and small only pub area -->
<!--Start Right Blocks-->
    <div class="row">
        <div class="medium-12 small 12 columns">
            <div class="medium-1 small-0 columns">&nbsp;</div>
            <div class="medium-10 small-0 columns">
                <!--[include file="right_block_adds.tpl"]-->           
            </div>
            <div class="medium-1 small-0 columns">&nbsp;</div>
        </div>
    </div>
<!--End Right Blocks-->
</div>