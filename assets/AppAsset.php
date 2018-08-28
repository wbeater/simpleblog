<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;
use Yii;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        YII_DEBUG ? 'vendor/bootstrap/css/bootstrap.css' : 'vendor/bootstrap/css/bootstrap.min.css',
        YII_DEBUG ? 'css/clean-blog.css' : 'css/clean-blog.min.css',
        YII_DEBUG ? 'vendor/font-awesome/css/font-awesome.css' : 'vendor/font-awesome/css/font-awesome.min.css',
        '/css/custom.css',
    ];
    
    public $js = [
        YII_DEBUG ? 'vendor/bootstrap/js/bootstrap.js' : 'vendor/bootstrap/css/bootstrap.min.js',
        //YII_DEBUG ? 'js/clean-blog.js' : 'js/clean-blog.min.js',
    ];
    
    public $depends = [
        'yii\web\JqueryAsset'
    ];
    
    public function init() {
        parent::init();
        
        if (isset(Yii::$app->params['css_version'])) {
            for ($i=0; $i < count($this->css); $i++) {
                $this->css[$i] .= '?v=' . Yii::$app->params['css_version'];
            }
        }
    }
}
