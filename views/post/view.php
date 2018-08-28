<?php
/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;
?>
<?php $this->beginBlock('header') ?>
<header class="masthead" style="background-image: url('<?=$model->image_url?>')">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="post-heading">
                    <h1><?=Html::encode($model->title)?></h1>
                    <h2 class="subheading"> <?= Html::encode($model->summary)?> </h2>
                    
                    <span class="meta">Posted by <a href="#"><?=Html::encode($model->createdBy->username)?></a>
                        on <?=Yii::$app->formatter->asDate($model->published_time, 'medium')?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</header>
<?php $this->endBlock() ?>

<article>
    <div class="container">
        <?php if ($model->status != \app\helpers\Constant::STATUS_PUBLISHED):?>
        <div class="p-3 mb-2 bg-warning text-dark"><?=Yii::t('app', 'This post was not published.')?> <strong><em><?=Html::a(Yii::t('app', 'Update now'), ['/post/update', 'id' => $model->id])?></em></strong></div>
        <?php endif?>
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <?=$model->content?>
            </div>
        </div>
    </div>
</article>

