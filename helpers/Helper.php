<?php

namespace app\helpers;

use Yii;

class Helper {
    public static function isOwner($editorId) {
        $identity = Yii::$app->getUser()->getIdentity();
        return ($identity && $identity->id == $editorId);
    }
    
    public static function isAdmin() {
        $identity = Yii::$app->getUser()->getIdentity();
        return $identity && $identity->is_admin;
    }
}