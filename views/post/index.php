<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>

<div class="row">
    <div class="col-md-8 mx-auto">
        <?php foreach ($posts as &$post):?>
        <div class="post-preview">
            <a href="<?= Url::toRoute(['/post/view', 'id' => $post->id, 'slug'=>$post->slug]) ?>">
                <h2 class="post-title">
                    <?=Html::encode($post->title)?>
                </h2>
                <h3 class="post-subtitle">
                    <?php if (!empty($post->thumbnail_url)):?>
                        <img class="post-thumbnail" src="<?=$post->thumbnail_url?>"/>
                    <?php endif?>
                    <?=nl2br(Html::encode($post->summary))?>
                </h3>
            </a>
            <div class="post-meta">Posted by
                <a href="#"><?=($post->createdBy) ? $post->createdBy->username : null?></a>
                on <?=Yii::$app->formatter->asDate($post->published_time, 'medium')?></div>
        </div>
        <?php endforeach?>
        <hr>
        
        <?php if (!is_null($prevFrom) || !is_null($nextFrom)):?>
        <!-- Pager -->
        <div class="clearfix">
            <?php if (!is_null($prevFrom)):?>
            <a class="btn btn-primary float-left" href="<?=Url::toRoute(['/post/index', 'offset' => $prevFrom])?>">&larr; <?=Yii::t('app', 'Newer Posts')?></a>
            <?php endif?>
            <?php if (!is_null($nextFrom)):?>
            <a class="btn btn-primary float-right" href="<?=Url::toRoute(['/post/index', 'offset' => $nextFrom])?>"><?=Yii::t('app', 'Older Posts')?> &rarr;</a>
            <?php endif?>
        </div>
        <?php endif?>
    </div>
    
    <?php /* Right column
    <div class="col-md-4">
        
    </div> */?>
</div>