<?php
namespace app\components\behaviors;

use Uni;

/**
 * Status behavior. Adds statuses to models
 * @package app\modules\nextadmin\behaviors
 */
class StatusController extends \uni\base\Behavior
{
    public $model;

    public function changeStatus($id, $status)
    {
        $modelClass = $this->model;

        if(($model = $modelClass::findOne($id))){
            $model->status = $status;
            $model->update();
        }
        else{
            $this->error = Uni::t('app', 'Not found');
        }

        return $this->owner->formatResponse(Uni::t('app', 'Status successfully changed'));
    }
}