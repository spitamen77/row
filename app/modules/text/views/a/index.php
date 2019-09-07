<?php
use uni\helpers\Url;

$this->title = Uni::t('app', 'Texts');

$module = $this->context->module->id;
?>

<?= $this->render('_menu') ?>
<div class="content-box">
    <?php if($data->count > 0) : ?>
        <table class="table table-bordered table-hover">
            <thead>
            <tr>

                    <th width="50">#</th>

                <th><?= Uni::t('app', 'Text') ?></th>

                    <th><?= Uni::t('app', 'Slug') ?></th>
                    <th width="30"></th>

            </tr>
            </thead>
            <tbody>
            <?php foreach($data->models as $item) : ?>
                <tr>
                        <td><?= $item->primaryKey ?></td>
                    <td><a href="<?= Url::to(['/admin/'.$module.'/a/edit', 'id' => $item->primaryKey]) ?>"><?= $item->text ?></a></td>

                        <td><?= $item->slug ?></td>
                        <td><a href="<?= Url::to(['/admin/'.$module.'/a/delete', 'id' => $item->primaryKey]) ?>" class="btn btn-danger confirm-delete" title="<?= Uni::t('app', 'Delete item') ?>"><i class="glyph-icon icon-remove"></i></a></td>

                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?= uni\widgets\LinkPager::widget([
            'pagination' => $data->pagination
        ]) ?>
    <?php else : ?>
        <p><?= Uni::t('app', 'No records found') ?></p>
    <?php endif; ?>
</div>
