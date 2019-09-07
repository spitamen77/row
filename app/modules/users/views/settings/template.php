<?php
use app\models\ContractTemplates;
?>
<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
        <div class="heading_actions">
            <a href="#" data-uk-tooltip="{pos:'bottom'}" title="Archive"><i class="md-icon material-icons">&#xE149;</i></a>
            <a href="#" data-uk-tooltip="{pos:'bottom'}" title="Print"><i class="md-icon material-icons">&#xE8AD;</i></a>
            <div data-uk-dropdown>
                <i class="md-icon material-icons">&#xE5D4;</i>
                <div class="uk-dropdown uk-dropdown-small">
                    <ul class="uk-nav">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Other Action</a></li>
                        <li><a href="#">Other Action</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <h1>Et consequuntur sunt sint eligendi dolorem aut sit.</h1>
        <span class="uk-text-upper uk-text-small"><a href="#">Altair</a> / <a href="#">ALT-23</a></span>
    </div>

    <div id="page_content_inner">

        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-margin-bottom" data-uk-margin>
                    <a href="#" class="md-btn"><i class="material-icons">&#xE254;</i> Edit</a>
                    <div class="md-btn-group">
                        <a class="md-btn" href="#">Assign</a>
                        <a href="#" class="md-btn">Start Progress</a>
                        <a href="#" class="md-btn">Close Issue</a>
                    </div>
                </div>
                <hr/>
                <div class="uk-grid uk-grid-divider" data-uk-grid-margin>
                    <div class="uk-width-medium-3-4">
                        <div class="uk-margin-large-bottom">
<iframe style="width: 100%;height: 500px;padding: 25px;" src="/users/settings/templateview/<?=$model->id?>"></iframe>
                        </div>
                        
                      
                    </div>
                    <div class="uk-width-medium-1-4">
                        <div class="uk-margin-medium-bottom">
                            <p>
                                Priority:
                                <span class="uk-badge uk-badge-success uk-text-upper uk-margin-small-left">Major</span>
                            </p>
                            <p>
                                Status:
                                <span class="uk-badge uk-badge-outline uk-text-upper uk-margin-small-left">Open</span>
                            </p>
                        </div>
                        <h2 class="heading_c uk-margin-small-bottom">Details</h2>
                        <ul class="md-list md-list-addon">
                            <li>
                                <div class="md-list-addon-element">
                                    <img class="md-user-image md-list-addon-avatar" src="<?=$model->user->avatar?>" alt=""/>
                                </div>
                                <div class="md-list-content">
                                    <span class="md-list-heading"><?=($model->user)?$model->user->makeFIO() : ''?></span>
                                    <span class="uk-text-small uk-text-muted">Assignee</span>
                                </div>
                            </li>
                            <li>
                                <div class="md-list-addon-element">
                                    <i class="md-list-addon-icon material-icons">&#xE8DF;</i>
                                </div>
                                <div class="md-list-content">
                                    <span class="md-list-heading"><?=$model->created?></span>
                                    <span class="uk-text-small uk-text-muted">
                                        <?=Uni::t('app','Created')?>
                                    </span>
                                </div>
                            </li>
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
