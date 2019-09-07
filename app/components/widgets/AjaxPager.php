<?php

namespace app\components\widgets;


use Uni;
use uni\helpers\Html;
use uni\widgets\LinkPager;

class AjaxPager extends LinkPager{

    protected function renderPageButton($label, $page, $class, $disabled, $active)
    {
        $options = ['class' => $class === '' ? null : $class];
        if ($active) {
            Html::addCssClass($options, $this->activePageCssClass);
        }
        if ($disabled) {
            Html::addCssClass($options, $this->disabledPageCssClass);

            return Html::tag('li', Html::tag('span', $label), $options);
        }
        $linkOptions = $this->linkOptions;
        $linkOptions['data-page'] = $page;
        if(isset($linkOptions['ui-sref']) and !empty($linkOptions['ui-sref'])){
            $linkOptions['ui-sref'] = str_replace('%page%',$page,$linkOptions['ui-sref']);
        }
        return Html::tag('li', Html::a($label, $this->pagination->createUrl($page), $linkOptions), $options);
    }

}