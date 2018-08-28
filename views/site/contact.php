<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = Yii::t('app', 'Contact');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginBlock('header') ?>
<header class="masthead" style="background-image: url('/img/contact-bg.jpg')">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="page-heading">
                    <h1>Contact Me</h1>
                    <span class="subheading">Have questions? I have answers.</span>
                </div>
            </div>
        </div>
    </div>
</header>
<?php $this->endBlock() ?>

<div class="row">
    <div class="col-lg-10 col-md-12 mx-auto">
        <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

            <div class="alert alert-success">
                Thank you for contacting us. We will respond to you as soon as possible.
            </div>

            <p>
                Note that if you turn on the Yii debugger, you should be able
                to view the mail message on the mail panel of the debugger.
                <?php if (Yii::$app->mailer->useFileTransport): ?>
                    Because the application is in development mode, the email is not sent but saved as
                    a file under <code><?= Yii::getAlias(Yii::$app->mailer->fileTransportPath) ?></code>.
                    Please configure the <code>useFileTransport</code> property of the <code>mail</code>
                    application component to be false to enable email sending.
                <?php endif; ?>
            </p>

        <?php else: ?>
            <p>Want to get in touch? Fill out the form below to send me a message and I will get back to you as soon as possible!</p>
            <!-- Contact Form - Enter your email address on line 19 of the mail/contact_me.php file to make this form work. -->
            <!-- WARNING: Some web hosts do not allow emails to be sent through forms to common mail hosts like Gmail or Yahoo. It's recommended that you use a private domain email address! -->
            <!-- To use the contact form, your site must be on a live web host with PHP! The form will not work locally! -->
            <?php $form = ActiveForm::begin(['id' => 'contactForm', 'enableClientScript' => false, 'options' => ['name' => 'sentMessage']]); ?>
            <div class="control-group">
                <div class="form-group floating-label-form-group controls">
                    <label>Name</label>
                    <?= $form->field($model, 'name')->textInput(['id' => 'name', 'autofocus' => true, 'class' => 'form-control', 'placeholder' => 'Your name'])->label(false)->error(false) ?>
                    <div class="help-block text-danger"><?= Html::error($model, 'name') ?></div>
                </div>
            </div>
            <div class="control-group">
                <div class="form-group floating-label-form-group controls">
                    <label>Email Address</label>
                    <?= $form->field($model, 'email')->textInput(['id' => 'email', 'class' => 'form-control', 'placeholder' => 'Email address'])->label(false)->error(false) ?>
                    <div class="help-block text-danger"><?= Html::error($model, 'email') ?></div>
                </div>
            </div>
            <div class="control-group">
                <div class="form-group col-xs-12 floating-label-form-group controls">
                    <label>Subject</label>
                    <?= $form->field($model, 'subject')->textInput(['id' => 'phone', 'class' => 'form-control', 'placeholder' => 'Subject'])->label(false)->error(false) ?>
                    <div class="help-block text-danger"><?= Html::error($model, 'subject') ?></div>
                </div>
            </div>
            <div class="control-group">
                <div class="form-group floating-label-form-group controls">
                    <label>Message</label>
                    <?= $form->field($model, 'body')->textarea(['rows' => 6, 'class' => 'form-control', 'id' => 'message', 'placeholder' => 'Message'])->label(false)->error(false) ?>
                    <div class="help-block text-danger"><?= Html::error($model, 'body') ?></div>
                </div>
            </div>

            <?php /*<div class="control-group">
                <div class="form-group controls">
                    <label>Verification code</label>
                    <?=$form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                    ])->label(false)->error(false)?>
                    <div class="help-block text-danger"><?= Html::error($model, 'verifyCode') ?></div>
                </div>
            </div>*/?>

            <br>
            <div id="success"></div>
            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'id' => 'sendMessageButton']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        <?php endif; ?>
    </div>
</div>