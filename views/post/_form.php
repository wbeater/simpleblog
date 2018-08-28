<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->registerJsFile('https://unpkg.com/stackedit-js@1.0.7/docs/lib/stackedit.min.js');
$this->registerJsFile('http://js.nicedit.com/nicEdit-latest.js');
/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $form yii\widgets\ActiveForm */

$js = <<<JS
    new nicEditor({fullPanel : true}).panelInstance('content_editor');

    const _editor = document.querySelector('#content_editor');
    const stackedit = new Stackedit();
    // Listen to StackEdit events and apply the changes to the textarea.
        
    stackedit.on('fileChange', (file) => {
      //_editor.value = file.content.html;
      nicEditors.findEditor('content_editor').setContent(file.content.html);
    });        
        
    $('#edit_markdown').on('click', function(e) {
        e.preventDefault;
        e.stopPropagation();
        
        // Open the iframe
        stackedit.openFile({
          name: 'Filename', // with an optional filename
          content: {
            //text: _editor.value // and the Markdown content.
            text: nicEditors.findEditor('content_editor').getContent()
          }
        });
    });
JS;
$this->registerJs($js, 4, 'content_editor');
?>

<div class="post-form">

    <?php $form = ActiveForm::begin([
        'enableClientScript' => false
    ]); ?>
    
    <?= $form->errorSummary([$model]);?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'thumbnail_url')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'image_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'summary')->textarea(['rows' => 3]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6, 'id'=>'content_editor']) ?>
    <?= Html::a(Yii::t('app', 'Edit as markdown'), '#', ['id'=>'edit_markdown', 'class' => 'pull-right text text-danger'])?>
    <br/>
    
    <?php if (\app\helpers\Helper::isAdmin()):?>
    <?= $form->field($model, 'published_time')->textInput(['type' => 'datetime-local', 'value' => substr(date('c', $model->published_time), 0, 19)]) ?>
    
    <?= $form->field($model, 'status')->checkbox()?>
    <?php endif?>
    
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
