<?php

namespace app\modules\comments\widgets;

use app\assets\CommentAsset;
use app\modules\comments\CommentsModule;
use app\modules\comments\models\CommentModel;
use Uni;
use uni\base\InvalidConfigException;
use uni\base\Widget;
use uni\data\ArrayDataProvider;
use uni\helpers\Json;

/**
 * Class Comment
 *
 * @package uni2mod\comments\widgets
 */
class Comment extends Widget
{
    /**
     * @var \uni\db\ActiveRecord|null Widget model
     */
    public $model;

    /**
     * @var string relatedTo custom text, for example: cms url: about-us, john comment about us page, etc.
     * By default - class:primaryKey of the current model
     */
    public $relatedTo;

    /**
     * @var string the view file that will render the comment tree and form for posting comments
     */
    public $commentView = '@app/modules/comments/widgets/views/index';

    /**
     * @var string comment form id
     */
    public $formId = 'comment-form';

    /**
     * @var string pjax container id
     */
    public $pjaxContainerId;

    /**
     * @var null|int maximum comments level, level starts from 1, null - unlimited level;
     */
    public $maxLevel = 10;

    /**
     * @var string entity id attribute
     */
    public $entityIdAttribute = 'id';

    /**
     * @var array DataProvider config
     */
    public $dataProviderConfig = [
        'pagination' => [
            'pageSize' => false,
        ],
    ];

    /**
     * @var array ListView config
     */
    public $listViewConfig = [
        'emptyText' => '',
    ];

    /**
     * @var array comment widget client options
     */
    public $clientOptions = [];

    /**
     * @var string hash(crc32) from class name of the widget model
     */
    protected $entity;

    /**
     * @var int primary key value of the widget model
     */
    protected $entityId;

    /**
     * @var string encrypted entity
     */
    protected $encryptedEntity;

    /**
     * @var string comment wrapper tag id
     */
    protected $commentWrapperId;

    /**
     * Initializes the widget params.
     */
    public function init()
    {
        parent::init();

        if (empty($this->model)) {
            throw new InvalidConfigException(Uni::t('app', 'The "model" property must be set.'));
        }

        if (empty($this->pjaxContainerId)) {
            $this->pjaxContainerId = 'comment-pjax-container-' . $this->getId();
        }

        if (empty($this->model->{$this->entityIdAttribute})) {
            throw new InvalidConfigException(Uni::t('app', 'The "entityIdAttribute" value for widget model cannot be empty.'));
        }

        $this->entity = hash('crc32', get_class($this->model));
        $this->entityId = $this->model->{$this->entityIdAttribute};

        if (empty($this->relatedTo)) {
            $this->relatedTo = get_class($this->model) . ':' . $this->entityId;
        }

        $this->encryptedEntity = $this->getEncryptedEntity();
        $this->commentWrapperId = $this->entity . $this->entityId;

        $this->registerAssets();
    }

    /**
     * Executes the widget.
     *
     * @return string the result of widget execution to be outputted
     */
    public function run()
    {
        $commentClass = CommentsModule::$commentModelClass;
        $commentModel = Uni::createObject([
            'class' => $commentClass,
            'entity' => $this->entity,
            'entityId' => $this->entityId,
        ]);
        $commentDataProvider = $this->getCommentDataProvider($commentClass);

        return $this->render($this->commentView, [
            'commentDataProvider' => $commentDataProvider,
            'commentModel' => $commentModel,
            'maxLevel' => $this->maxLevel,
            'encryptedEntity' => $this->encryptedEntity,
            'pjaxContainerId' => $this->pjaxContainerId,
            'formId' => $this->formId,
            'listViewConfig' => $this->listViewConfig,
            'commentWrapperId' => $this->commentWrapperId,
        ]);
    }

    /**
     * Get encrypted entity
     *
     * @return string
     */
    protected function getEncryptedEntity()
    {
        return utf8_encode(Uni::$app->getSecurity()->encryptByKey(Json::encode([
            'entity' => $this->entity,
            'entityId' => $this->entityId,
            'relatedTo' => $this->relatedTo,
        ]), CommentsModule::$name));
    }

    /**
     * Register assets.
     */
    protected function registerAssets()
    {
        $view = $this->getView();
        CommentAsset::register($view);
        $view->registerJs("jQuery('#{$this->commentWrapperId}').comment({$this->getClientOptions()});");
    }

    /**
     * @return string
     */
    protected function getClientOptions()
    {
        $this->clientOptions['pjaxContainerId'] = '#' . $this->pjaxContainerId;
        $this->clientOptions['formSelector'] = '#' . $this->formId;

        return Json::encode($this->clientOptions);
    }

    /**
     * Get comment ArrayDataProvider
     *
     * @param CommentModel $commentClass
     *
     * @return ArrayDataProvider
     */
    protected function getCommentDataProvider($commentClass)
    {
        $dataProvider = new ArrayDataProvider($this->dataProviderConfig);
        if (!isset($this->dataProviderConfig['allModels'])) {
            $dataProvider->allModels = $commentClass::getTree($this->entity, $this->entityId, $this->maxLevel);
        }

        return $dataProvider;
    }
}
