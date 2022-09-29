<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string $auth_key
 * @property string $access_token
 * @property string $tipo
 *
 * @property Cliente[] $clientes
 * @property Restaurante[] $restaurantes
 */
class User extends ActiveRecord implements IdentityInterface
{
    public $rememberMe = true;
    private $_user = false;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'password', 'auth_key', 'access_token', 'tipo'], 'required'],
            [['email'], 'string', 'max' => 250],
            [['password', 'auth_key', 'access_token'], 'string', 'max' => 500],
            [['tipo'], 'string', 'max' => 10],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
            'tipo' => 'Tipo',
        ];
    }

    /**
     * Gets query for [[Clientes]].
     *
     * @return \yii\db\ActiveQuery|ClienteQuery
     */
    public function getClientes()
    {
        return $this->hasMany(Cliente::class, ['usuario_id' => 'id']);
    }

    /**
     * Gets query for [[Restaurantes]].
     *
     * @return \yii\db\ActiveQuery|RestauranteQuery
     */
    public function getRestaurantes()
    {
        return $this->hasMany(Restaurante::class, ['usuario_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    
    ////////////////////////////
    public static function findByUsername($email)
    {
      return static::find()->where(['email' => $email])->one();
    }

        /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }
        /**
     * {@inheritdoc}
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

        /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password);

       // return $this->password === $password;
    }

    
  /**
   * Finds an identity by the given ID.
   * @param string|int $id the ID to be looked for
   * @return IdentityInterface the identity object that matches the given ID.
   * Null should be returned if such an identity cannot be found
   * or the identity is not in an active state (disabled, deleted, etc.)
   */
  public static function findIdentity($id)
  {
    return static::findOne($id);
  }

    /**
   * Finds an identity by the given token.
   * @param mixed $token the token to be looked for
   * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
   * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
   * @return Usuario the identity object that matches the given token.
   * Null should be returned if such an identity cannot be found
   * or the identity is not in an active state (disabled, deleted, etc.)
   */
  public static function findIdentityByAccessToken($token, $type = null)
  {
    return static::findOne(['access_token' => $token]);
  }

  public function generateKey()
  {
    $this->auth_key = \Yii::$app->security->generateRandomString();
    $this->access_token = \Yii::$app->security->generateRandomString();
  }

      /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }
    
    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->email);
        }

        return $this->_user;
    }

    public function encriptarPassword($password)
    {
      $this->password = \Yii::$app->security->generatePasswordHash($password);
    }
}
