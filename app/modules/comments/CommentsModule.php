<?php

namespace app\modules\comments;


class CommentsModule extends  \uni\base\Module
{
    public static $name = 'comments';
    public static $commentModelClass = 'app\modules\comments\models\CommentModel';
    public  $controllerNamespace = 'app\modules\comments\controllers';
}
