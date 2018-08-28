<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * @property integer $id
 * @property string $username
 * @property string $access_token
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $is_admin
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements \yii\web\IdentityInterface {

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    public $password;
    public $re_password;

    public static function tableName() {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['username', 'email', 'password', 're_password'], 'required', 'on' => 'register'],
            ['re_password', 'compare', 'compareAttribute' => 'password', 'on' => 'register'],
            
            [['username', 'email'], 'unique'],
            ['email', 'email'],
            ['status', 'default', 'value' => self::STATUS_DELETED],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            ['is_admin', 'in', 'range' => [0, 1]],
                //[['auth_key', 'password_hash', 'access_token', 'password_reset_token',], 'safe'],
        ];
    }

    public function scenarios() {
        return [
            'create' => ['id', 'username', 'access_token', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'is_admin', 'status', 'created_at', 'updated_at'],
            'update' => ['id', 'username', 'access_token', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'is_admin', 'status', 'created_at', 'updated_at'],
            'register' => ['email', 'username', 'auth_key', 'password', 're_password']
        ];
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id) {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            $this->password_hash = \Yii::$app->security->generatePasswordHash($this->password);

            if ($this->isNewRecord) {
                $this->access_token = \Yii::$app->security->generateRandomString();
                $this->auth_key = \Yii::$app->security->generateRandomString();
                $this->created_at = time();
            }

            $this->updated_at = time();
            return true;
        }

        return false;
    }

    public function getPosts() {
        return $this->hasMany(Post::className(), ['created_by' => 'id'])->inverseOf('user');
    }

}
