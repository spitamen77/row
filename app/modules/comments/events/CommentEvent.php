<?php

namespace app\modules\comments\events;

use app\modules\comments\models\CommentModel;
use uni\base\Event;

/**
 * Class CommentEvent
 *
 * @package uni2mod\comments\events
 */
class CommentEvent extends Event
{
    /**
     * @var CommentModel
     */
    private $_commentModel;

    /**
     * @return CommentModel
     */
    public function getCommentModel()
    {
        return $this->_commentModel;
    }

    /**
     * @param CommentModel $commentModel
     */
    public function setCommentModel(CommentModel $commentModel)
    {
        $this->_commentModel = $commentModel;
    }
}
