    <div class="row">
        <div class="panel callout">
            <div class="row">
                <div class="large-12 columns">
                    <h4>Sections and content</h4>
                    <dl class="tabs" data-tab>
                        <!--[foreach name=externo item=issue_section from=$this_issue.issue_sections]-->
                        <dd class="tab-title<!--[if $smarty.foreach.externo.first]--> active<!--[/if]-->"><a href="#panel<!--[$issue_section.section_id]-->"><!--[$issue_section.section_name]--></a></dd>
                        <!--[/foreach]-->
                    </dl>
                    <div class="tabs-content">
                    <!--[foreach name=externo item=issue_section from=$this_issue.issue_sections]-->
                        <div class="content<!--[if $smarty.foreach.externo.first]--> active<!--[/if]-->" id="panel<!--[$issue_section.section_id]-->" style="background-color:white;width:100%;">
                            <div class="dmm-tab-block">
                                <p>Use este espaço para adicionar artigos existentes, solicitar colunas e artigos para autores, etc.</p>
                                <p>Seção "<span style=" font-weight:600"><!--[$issue_section.section_name]--></span>"</p>
                            </div>
                            <div class="panel" style="margin-left:10px;margin-right:10px; min-height:270px">
<!--[include file="my_issue_sections_content_form.tpl"]-->
                            </div>
                        </div>
                    <!--[/foreach]-->
                    </div>
                </div>
            </div>
        </div>
    </div>