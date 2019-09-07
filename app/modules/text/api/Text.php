<?php
namespace app\modules\nextadmin\modules\text\api;

use app\modules\nextadmin\components\ActiveRecord;
use app\modules\nextadmin\components\Lang;
use Uni;
use app\modules\nextadmin\components\API;
use app\modules\nextadmin\helpers\Data;
use uni\helpers\Url;
use app\modules\nextadmin\modules\text\models\Text as TextModel;
use uni\helpers\Html;

/**
 * Text module API
 * @package app\modules\nextadmin\modules\text\api
 *
 * @method static get(mixed $id_slug) Get text block by id or slug
 */
class Text extends API
{
    private $_texts = [];

    public function init()
    {
        parent::init();

        $this->_texts = Data::cache(TextModel::CACHE_KEY, 3600, function(){
            return TextModel::find()->with('translation')->asArray()->all();
        });
    }

    public function api_get($id_slug)
    {
        $def_lang=Lang::getDefaultLang()->url;
        $current=ActiveRecord::getLang();
        if(($text = $this->findText($id_slug)) === null){
            return $this->notFound($id_slug);
        }
        $t=$text['text'];
        if(isset($text['translation'][$current]))$t=$text['translation'][$current]['text'];
        return LIVE_EDIT ? API::liveEdit($t, Url::to(['/admin/text/a/edit/', 'id' => $text['text_id']])) : $t;
    }

    private function findText($id_slug)
    {

        foreach ($this->_texts as $item) {
            if(($item['slug'] == $id_slug || $item['text_id'] == $id_slug)){
                return $item;
            }
        }
        return null;
    }

    private function notFound($id_slug)
    {
        $text = '';

        if(!Uni::$app->user->isGuest && Uni::$app->user->identity->_('admin')&&preg_match(TextModel::$SLUG_PATTERN, $id_slug)){
            $text = Html::a(Uni::t('app', 'Create text'), ['/admin/text/a/create', 'slug' => $id_slug], ['target' => '_blank']);
        }

        return $text;
    }
}