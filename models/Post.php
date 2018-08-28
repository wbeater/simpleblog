<?php

namespace app\models;

use Yii;
use app\models\User;

/**
 * This is the model class for table "{{%post}}".
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $thumbnail_url
 * @property string $image_url
 * @property string $summary
 * @property string $content
 * @property int $status -2 : Admin unpublished -1 : Deleted 0: Unpublished 1: Published
 * @property int $published_time
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property User $createdBy
 * @property User $updatedBy
 */
class Post extends \yii\db\ActiveRecord
{

    public function init() {
        parent::init();
        $this->published_time = time();
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%post}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'status'], 'required'],
            [['summary', 'content'], 'string'],
            [['status', 'published_time', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['thumbnail_url', 'image_url',], 'url'],
            [['title', 'thumbnail_url', 'image_url'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }
    
    public function scenarios() {
        return [
            'default' => ['id', 'title', 'thumbnail_url', 'image_url', 'summary', 'content'],
            'create' => ['id', 'title', 'thumbnail_url', 'image_url', 'summary', 'content'],
            'update' => ['id', 'title', 'thumbnail_url', 'image_url', 'summary', 'content'],
            'admin' => ['id', 'title', 'thumbnail_url', 'image_url', 'summary', 'content', 'status', 'published_time'],
        ];
    }
    
    public function beforeValidate() {
        if (!is_numeric($this->published_time)) {
            $this->published_time = strtotime($this->published_time);
        }
        
        return parent::beforeValidate();
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'slug' => Yii::t('app', 'Slug'),
            'thumbnail_url' => Yii::t('app', 'Thumbnail'),
            'image_url' => Yii::t('app', 'Image'),
            'summary' => Yii::t('app', 'Summary'),
            'content' => Yii::t('app', 'Content'),
            'status' => Yii::t('app', 'Published'),
            'published_time' => Yii::t('app', 'Published Time'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

        
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'created_by'])->inverseOf('posts');
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * {@inheritdoc}
     * @return PostQuery the active query used by this AR class.
     */
    /*public static function find()
    {
        return new PostQuery(get_called_class());
    }*/
    
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            
            if(is_a(Yii::$app,'yii\web\Application')) {
                $identity = Yii::$app->getUser()->getIdentity();

                if ($this->getIsNewRecord()) {
                    $this->created_by = $identity->getId();
                }

                $this->updated_by = $identity->getId();
            }
            
            if ($this->getIsNewRecord()) {
                $this->created_at = time();
            }
            
            if (!$this->status) $this->status = 0;
            $this->updated_at = time();
            $this->slug = \app\helpers\StringHelper::slug($this->title);
            return true;
        }
        
        return false;
    }

}
