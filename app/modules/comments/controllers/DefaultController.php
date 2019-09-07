<?php

namespace app\modules\comments\controllers;
use app\components\behaviors\AdjacencyListBehavior;
use app\components\Controller;
use app\modules\comments\CommentsModule;
use app\modules\comments\models\CommentModel;
use Uni;
use uni\filters\VerbFilter;
use uni\web\NotFoundHttpException;

class DefaultController extends Controller
{
    /**
     * @var string path to index view file, which is used in admin panel
     */
    public $indexView = '@app/views/comments/index';

    /**
     * @var string path to update view file, which is used in admin panel
     */
    public $updateView = '@app/views/comments/update';

    /**
     * @var string search class name for searching
     */
    public $searchClass = 'app\modules\comments\models\CommentSearch';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['get'],
                    'update' => ['get', 'post'],
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all comments.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = Uni::createObject($this->searchClass);
        $dataProvider = $searchModel->search(Uni::$app->request->queryParams);
        $commentModel = CommentsModule::$commentModelClass;

        return $this->render($this->indexView, [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'commentModel' => $commentModel,
        ]);
    }

    /**
     * Updates an existing CommentModel model.
     *
     * If update is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Uni::$app->request->post()) && $model->save()) {
            Uni::$app->session->setFlash('success', Uni::t('app', 'Comment has been saved.'));

            return $this->redirect(['index']);
        }

        return $this->render($this->updateView, [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing comment with children.
     *
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->deleteWithChildren();
        Uni::$app->session->setFlash('success', Uni::t('app', 'Comment has been deleted.'));

        return $this->redirect(['index']);
    }

    /**
     * Finds the CommentModel model based on its primary key value.
     *
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @throws NotFoundHttpException if the model cannot be found
     *
     * @return CommentModel|AdjacencyListBehavior the loaded model
     */
    protected function findModel($id)
    {
        $commentModel =CommentsModule::$commentModelClass;

        if (($model = $commentModel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Uni::t('app', 'The requested page does not exist.'));
        }
    }
}