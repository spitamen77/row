<?php
/**
 * Created by PhpStorm.
 * User: rashidovn
 * Date: 4/9/2017
 * Time: 6:12 PM
 */

namespace app\modules\page\controllers;


use app\components\behaviors\ModerationBehavior;
use app\modules\comments\CommentsModule;
use app\modules\comments\events\CommentEvent;
use app\modules\comments\models\CommentModel;
use uni\filters\VerbFilter;
use uni\helpers\Json;
use uni\web\BadRequestHttpException;
use uni\web\Controller;
use uni\web\NotFoundHttpException;
use uni\web\Response;
use Uni;
use uni\widgets\Form;

class CommentController extends  Controller
{

    /**
     * Event is triggered before creating a new comment.
     * Triggered with uni2mod\comments\events\CommentEvent
     */
    const EVENT_BEFORE_CREATE = 'beforeCreate';

    /**
     * Event is triggered after creating a new comment.
     * Triggered with uni2mod\comments\events\CommentEvent
     */
    const EVENT_AFTER_CREATE = 'afterCreate';

    /**
     * Event is triggered before deleting the comment.
     * Triggered with uni2mod\comments\events\CommentEvent
     */
    const EVENT_BEFORE_DELETE = 'beforeDelete';

    /**
     * Event is triggered after deleting the comment.
     * Triggered with uni2mod\comments\events\CommentEvent
     */
    const EVENT_AFTER_DELETE = 'afterDelete';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'create' => ['post'],
                    'delete' => ['post', 'delete'],
                ],
            ],
            'contentNegotiator' => [
                'class' => 'uni\filters\ContentNegotiator',
                'only' => ['create'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ];
    }

    /**
     * Create a comment.
     *
     * @param $entity string encrypt entity
     *
     * @return array
     */
    public function actionCreate($entity)
    {
        /* @var $commentModel CommentModel */
        $commentModel = \Uni::createObject(CommentsModule::$commentModelClass);
        $event = Uni::createObject(['class' => CommentEvent::class, 'commentModel' => $commentModel]);
        $commentModel->setAttributes($this->getCommentAttributesFromEntity($entity));
        $this->trigger(self::EVENT_BEFORE_CREATE, $event);
        if ($commentModel->load(Uni::$app->request->post()) && $commentModel->saveComment()) {
            $this->trigger(self::EVENT_AFTER_CREATE, $event);

            return ['status' => 'success'];
        }

        return [
            'status' => 'error',
            'errors' => Form::validate($commentModel),
        ];
    }

    /**
     * Delete comment.
     *
     * @param int $id Comment ID
     *
     * @return string Comment text
     */
    public function actionDelete($id)
    {
        $commentModel = $this->findModel($id);
        $event = Uni::createObject(['class' => CommentEvent::class, 'commentModel' => $commentModel]);
        $this->trigger(self::EVENT_BEFORE_DELETE, $event);

        if ($commentModel->markRejected()) {
            $this->trigger(self::EVENT_AFTER_DELETE, $event);

            return Uni::t('app', 'Comment has been deleted.');
        } else {
            Uni::$app->response->setStatusCode(500);

            return Uni::t('app', 'Comment has not been deleted. Please try again!');
        }
    }

    /**
     * Find model by ID.
     *
     * @param int|array $id Comment ID
     *
     * @return null|CommentModel|ModerationBehavior
     *
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        /** @var CommentModel $model */
        $commentModelClass = CommentsModule::$commentModelClass;
        if (($model = $commentModelClass::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Uni::t('app', 'The requested page does not exist.'));
        }
    }

    /**
     * Get list of attributes from encrypted entity
     *
     * @param $entity string encrypted entity
     *
     * @return array|mixed
     *
     * @throws BadRequestHttpException
     */
    protected function getCommentAttributesFromEntity($entity)
    {
        $decryptEntity = Uni::$app->getSecurity()->decryptByKey(utf8_decode($entity), CommentsModule::$name);
        if ($decryptEntity !== false) {
            return Json::decode($decryptEntity);
        }

        throw new BadRequestHttpException(Uni::t('app', 'Oops, something went wrong. Please try again later.'));
    }
}