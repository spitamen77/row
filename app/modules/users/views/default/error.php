<?php
$this->title = Uni::t('app', 'Error');
?>
<div class="md-card">
    <div class="md-card-content">
        <div class="error_page_header">
            <div class="uk-width-8-10 uk-container-center">
                404!
            </div>
        </div>
        <div class="error_page_content">
            <div class="uk-width-8-10 uk-container-center">
                <p class="heading_b"><?=Uni::t('app', 'Page not found')?></p>
                <p class="uk-text-large">
                    <?=Uni::t('app', 'The requested URL')?> <span class="uk-text-muted">/some_url</span> <?=Uni::t('app', 'was not found on this server')?>.
                </p>
                <a class="md-btn md-btn-success md-btn-small" onclick="window.history.back();"><?=Uni::t('app','Back')?></a>

            </div>
        </div>
    </div>
</div>