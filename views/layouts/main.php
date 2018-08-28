<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;
AppAsset::register($this);

$identity = Yii::$app->getUser()->getIdentity();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Custom fonts for this template -->
        <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="/"><?=Yii::t('app', 'Blog name')?></a>
                
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <?=Yii::t('app', 'Menu')?>
                    <i class="fa fa-bars"></i>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="<?=Url::toRoute(['/post/index'])?>"><?=Yii::t('app', 'Home')?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?=Url::toRoute(['/site/about'])?>"><?=Yii::t('app', 'About')?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?=Url::toRoute(['/site/contact'])?>"><?=Yii::t('app', 'Contact')?></a>
                        </li>
                        <?php if (Yii::$app->getUser()->getIsGuest()):?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?=Url::toRoute(['/site/login'])?>"><?=Yii::t('app', 'Login / Register')?></a>
                        </li>
                        <?php else:?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?=Url::toRoute(['/post/admin'])?>"><?=Yii::t('app', 'Manage posts')?></a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="<?=Url::toRoute(['/site/logout'])?>"><?=Yii::t('app', 'Logout') . ' (' . $identity->username . ')'?></a>
                        </li>
                        <?php endif?>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Page Header -->
        <?php if (isset($this->blocks['header'])):?>
            <?=$this->blocks['header']?>
        <?php else:?>
            <header class="masthead" style="background-image: url('/img/home-bg.jpg')">
                <div class="overlay"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-md-10 mx-auto">
                            <div class="site-heading">
                                <h1><?=Yii::t('app', 'Blog name')?></h1>
                                <span class="subheading"><?=Yii::t('app', 'Blog subtitle')?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
        <?php endif?>

        <div class="container">
            <?=
            Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ])
            ?>
        </div>
        
        <div class="container">
            <?= $content ?>
        </div>

        <hr>

        <!-- Footer -->
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-10 mx-auto">
                        <ul class="list-inline text-center">
                            <li class="list-inline-item">
                                <a href="#">
                                    <span class="fa-stack fa-lg">
                                        <i class="fa fa-circle fa-stack-2x"></i>
                                        <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#">
                                    <span class="fa-stack fa-lg">
                                        <i class="fa fa-circle fa-stack-2x"></i>
                                        <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#">
                                    <span class="fa-stack fa-lg">
                                        <i class="fa fa-circle fa-stack-2x"></i>
                                        <i class="fa fa-github fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                            </li>
                        </ul>
                        <p class="copyright text-muted"><?=Yii::t('app', 'Copyright &copy; {year}', ['year' => date('Y')])?></p>
                    </div>
                </div>
            </div>
        </footer>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
