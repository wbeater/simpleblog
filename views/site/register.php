<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use app\widgets\Alert;

$this->title = 'Register';
$this->blocks['header'] = '';
$this->params['breadcrumbs'] = null;
?>

<div class="row justify-content-md-center h-100 mt-5">
    <div class="card-wrapper">
        <?= Alert::widget() ?>
        <div class="card" style="min-width: 400px;">
            <div class="card-body">
                <h4 class="card-title"><?=Yii::t('app', 'Register')?></h4>
                <?php
                    $form = ActiveForm::begin([
                        'id' => 'register-form',
                        'layout' => 'horizontal',
                        'enableClientScript' => false,
                        'fieldConfig' => [
                            'template' => "{label}{input} {error}",
                            'labelOptions' => ['class' => 'control-label'],
                            'errorOptions' => ['class' => 'text-danger']
                        ],
                    ]);
                    ?>
                    
                    <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'class'=>'form-control', 'required'=>true,]) ?>
                    <?= $form->field($model, 'username')->textInput(['class'=>'form-control', 'required'=>true,]) ?>
                    <?= $form->field($model, 'password')->passwordInput(['class'=>'form-control', 'required'=>true,]) ?>
                    <?= $form->field($model, 're_password')->passwordInput(['class'=>'form-control', 'required'=>true,]) ?>
                    
                    <?= Html::submitButton('Register', ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>

                    <div class="">
                        <div><a href="<?=Url::toRoute(['/site/login'])?>"><?=Yii::t('app', 'Already have account ?')?></a></div>
                        <div><a href="<?=Url::toRoute(['/post/index'])?>"><?=Yii::t('app', 'Go home')?></a></div>
                        <!--<div><a href="<?=Url::toRoute(['/site/forgotpass'])?>">Forgot Password?</a></div>-->
                    </div>
                    
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
