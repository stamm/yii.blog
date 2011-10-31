<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property string $email
 * @property string $profile
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, email', 'required'),
			array('username, password, salt, email', 'length', 'max'=>128),
			array('profile', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, password, salt, email, profile', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => Yii::t(__CLASS__, 'Username'),
			'password' => Yii::t(__CLASS__, 'Password'),
			'salt' => Yii::t(__CLASS__, 'Salt'),
			'email' => Yii::t(__CLASS__, 'Email'),
			'profile' => Yii::t(__CLASS__, 'Profile'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('salt',$this->salt,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('profile',$this->profile,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function validatePassword($password)
	{
		return $this->hashPassword($password) === $this->password;
	}

	public function hashPassword($password)
	{
		// secure hashing of passwords using bcrypt, needs PHP 5.3+
		// see http://codahale.com/how-to-safely-store-a-password/

		// 2a is the bcrypt algorithm selector, see http://php.net/crypt
		// 12 is the workload factor (around 300ms on my Core i7 machine), see http://php.net/crypt
		return crypt($password, '$2a$12$' . $this->salt);
	}

	protected function beforeSave()
	{
		// Generate salt if needing
		if ($this->isNewRecord || ! $this->salt)
		{
			$this->salt = substr(str_replace('+', '.', base64_encode(sha1(microtime(true), true))), 0, 22);
		}
		if ($this->password == '')
		{
			unset($this->password);
		}
		// Dont change password on login
		elseif ($this->scenario != 'login')
		{
			$this->password = $this->hashPassword($this->password);
		}
		return parent::beforeSave();
	}
}