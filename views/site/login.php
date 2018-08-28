<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use app\widgets\Alert;

$this->title = 'Login';
$this->params['breadcrumbs'] = null;
$this->blocks['header'] = '';
?>

<div class="row justify-content-md-center h-100 mt-5">
    <div class="card-wrapper">

        <div class="card" style="min-width: 400px;">
            <div class="card-body">
                <?php if (Yii::$app->session->hasFlash('success')):?>
                <div class="p-3 mb-2 bg-success text-white"><?=Yii::$app->session->getFlash('success')?></div>
                <?php endif?>
                <h4 class="card-title"><?=Yii::t('app', 'Login')?></h4>
                <?php
                    $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'layout' => 'horizontal',
                        'enableClientScript' => false,
                        'fieldConfig' => [
                            'template' => "{label}{input} {error}",
                            'labelOptions' => ['class' => 'control-label'],
                            'errorOptions' => ['class' => 'text-danger']
                        ],
                    ]);
                    ?>
                    
                    <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class'=>'form-control', 'required'=>true,]) ?>
                    <?= $form->field($model, 'password')->passwordInput(['class'=>'form-control', 'required'=>true,]) ?>
                    <?= $form->field($model, 'rememberMe')->checkbox([
                        'template' => "<div>{input} {label}</div> <div>{error}</div>",
                    ])?>

                    
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>

                    <div class="">
                        <div><a href="<?=Url::toRoute(['/site/register'])?>"><?=Yii::t('app', 'Create new account')?></a></div>
                        <div><a href="<?=Url::toRoute(['/post/index'])?>"><?=Yii::t('app', 'Go home')?></a></div>
                        <!--<div><a href="<?=Url::toRoute(['/site/forgotpass'])?>">Forgot Password?</a></div>-->
                    </div>
                    
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
