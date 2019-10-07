<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;
use Yii;
use app\models\LoginForm;

/**
 * Site controller for the `admin` module
 */
class SiteController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    


    public function actionLogin()
    {

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['/admin/default']);
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }
}
