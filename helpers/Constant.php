<?php

namespace app\helpers;
use Yii;

class Constant {
    /**
     * Admin published a post
     */
    const STATUS_PUBLISHED = 1;
    
    /**
     * Inactive post
     */
    const STATUS_UNPUBLISHED = 0;
    
    /**
     * User deleted a post
     */
    const STATUS_DELETED = -1;
    
    /**
     * Admin unpublished a post
     */
    const STATUS_ADMIN_UNPUBLISHED = -2;
    
    public static function postStatus($status=null) {
        $statuses = [
            self::STATUS_ADMIN_UNPUBLISHED => Yii::t('app', 'Unpublished by Admin'),
            self::STATUS_DELETED => Yii::t('app', 'Deleted by user'),
            self::STATUS_UNPUBLISHED => Yii::t('app', 'Draft'),
            self::STATUS_PUBLISHED => Yii::t('app', 'Published'),
        ];
        
        return !is_null($status) ? (isset($statuses[$status]) ? $statuses[$status] : null) : $statuses;
                
    }
}
