<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Posts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-admin">
    <div><?=app\widgets\Alert::widget()?>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Post'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model, $key, $index, $grid) {
            if ($model->status == \app\helpers\Constant::STATUS_UNPUBLISHED) {
                return ['class' => 'bg-warning'];
            }
            elseif ($model->status == \app\helpers\Constant::STATUS_PUBLISHED && $model->published_time > time()) {
                return ['class' => 'bg-success'];
            }
            else {
                return [];
            }
        },
        'columns' => [
            'id',
            [
                'format' => 'html',
                'attribute' => 'thumbnail_url',
                'header' => Yii::t('app', 'Thumbnail'),
                'value' => function($item) {
                    return $item->thumbnail_url ? Html::img($item->thumbnail_url, ['width'=>100, 'height'=>100]) : '';
                }
            ],
            'title',
            [
                'attribute' => 'created_by',
                'header' => Yii::t('app', 'Author'),
                'value' => function($item) {
                    return $item->createdBy->username;
                }
            ],
            [
                'format' => 'html',
                'attribute' => 'status',
                'options' => ['style' => 'width: 100px;'],
                'filter' => \app\helpers\Constant::postStatus(),
                'value' => function($item) {
                    $text = isset($item->status) ? \app\helpers\Constant::postStatus($item->status) : '';
                    
                    if (\app\helpers\Helper::isAdmin()) {
                        if ($item->status == \app\helpers\Constant::STATUS_PUBLISHED) {
                            $text .= '<div>' . Html::a(Yii::t('app', '[Unpublish]'), ['/post/unpublish', 'id'=>$item->id], []) . '</div>';
                        }
                        
                        if ($item->status == \app\helpers\Constant::STATUS_UNPUBLISHED) {
                            $text .= '<div>' . Html::a(Yii::t('app', '[Publish]'), ['/post/publish', 'id'=>$item->id], []) . '</div>';
                        }
                    }
                    
                    return $text;
                },
            ],
            [
                'attribute' => 'published_time',
                'value' => function($item) {
                    if ($item->status == \app\helpers\Constant::STATUS_PUBLISHED) {
                        $text = Yii::$app->formatter->asDatetime($item->published_time, 'yyyy-MM-dd HH:mm:ss');
                        
                        if ($item->published_time > time()) {
                            $text .= "\n(" . Yii::t('app', 'in {0} minutes', round(($item->published_time - time()) / 60)) . ')';
                        }
                        
                        return $text;
                    }
                    else {
                        return '';
                    }
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn', 
                //'template' => '{view} {schedule} {update} {delete}',
                'headerOptions' => ['style' => 'width:10%;'],
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                       return Html::a('<i class="fa fa-search"></i>', $url, ['target' => '_blank', 'data-pjax' => '0',]);
                    },
                            
                    'update' => function ($url, $model, $key) {
                        if (\app\helpers\Helper::isOwner($model->created_by) || \app\helpers\Helper::isAdmin($model->created_by)) {
                            return Html::a('<i class="fa fa-pencil"></i>', $url);
                        }
                        else {
                            return '';
                        }
                    },
                    'delete' => function ($url, $model, $key) {
                        if (\app\helpers\Helper::isOwner($model->created_by)) {
                            return Html::a('<i class="fa fa-trash"></i>', $url, [
                                'aria-label' => 'Delele',
                                'data-pjax' => '0',
                                'data-confirm' => Yii::t('app', 'Are you sure you want to delete this post?'),
                                'data-method' => 'post',
                            ]);
                        }
                        else {
                            return '';
                        }
                    },
                ],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
