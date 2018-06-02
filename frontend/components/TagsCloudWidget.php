<?php
namespace frontend\components;

use Yii;
use yii\Base\Widget;
use yii\helpers\Html;

class TagsCloudWidget extends Widget
{

    public $tags;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $tagString = '';
        $fontStyle = [
            '6' => 'danger',
            '5' => 'info',
            '4' => 'warning',
            '3' => 'primary',
            '2' => 'success',
        ];

        foreach ($this->tags as $tag=>$weight)
        {
            $tagString .= '<a href="'.Yii::$app->homeUrl.'?r=article/index&ArticleSearch[tags]'.$tag.'">'.
                '<h'.$weight.' style="display:inline-block;"><span class="label label-'
            .$fontStyle[$weight].'">'.$tag.'</span></h'.$weight.'></a>';
        }
        return $tagString;
    }
}