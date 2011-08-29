<?php

/**
 * This is the model class for table "{{comment}}".
 *
 * The followings are the available columns in table '{{comment}}':
 * @property string $id
 * @property string $content
 * @property string $status
 * @property string $create_time
 * @property string $author
 * @property string $email
 * @property string $url
 * @property string $post_id
 * @property string $ip
 */
class Comment extends CActiveRecord
{
	const STATUS_PENDING=1;
	const STATUS_APPROVED=2;
	const STATUS_SPAM=3;


	public $verifyCode;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Comment the static model class
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
		return '{{comment}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('content, status, author, email, post_id, ip', 'required'),
			array('status, create_time, post_id', 'length', 'max'=>11),
			array('author, email, url', 'length', 'max'=>128),
			array('ip', 'length', 'max'=>15),
			array('verifyCode', 'captcha', 'allowEmpty' => !extension_loaded('gd'), 'captchaAction' => 'site/captcha'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, content, status, create_time, author, email, url, post_id, ip', 'safe', 'on'=>'search'),
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
			'post' => array(self::BELONGS_TO, 'Post', 'post_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'content' => Yii::t(__CLASS__, 'Content'),
			'status' => Yii::t(__CLASS__, 'Status'),
			'create_time' => Yii::t(__CLASS__, 'Create Time'),
			'author' => Yii::t(__CLASS__, 'Author'),
			'email' => Yii::t(__CLASS__, 'Email'),
			'url' => Yii::t(__CLASS__, 'Url'),
			'post_id' => Yii::t(__CLASS__, 'Post'),
			'ip' => Yii::t(__CLASS__, 'Ip'),
			'verifyCode' => Yii::t('all', 'Verify code'),
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('author',$this->author,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('post_id',$this->post_id,true);
		$criteria->compare('ip',$this->ip,true);

		if ( ! $criteria->order)
		{
			$criteria->order = 'create_time DESC';
		}
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	protected function  beforeSave()
	{
		if (parent::beforeSave())
		{
			if ($this->isNewRecord && ! isset($this->create_time))
			{
				$this->create_time = time();
			}
			return true;
		}
		else
			return false;
	}


	/**
	 * Approves a comment
	 */
	public function approve()
	{
		$this->status = Comment::STATUS_APPROVED;
		$this->update(array('status'));
	}

	/**
	 * Mark as spam
	 * @return void
	 */
	public function spam()
	{
		$this->status = Comment::STATUS_SPAM;
		$this->update(array('status'));
	}

	/**
	 * Return url to the comment
	 * @param Post The post that this comment belongs to. If null, the method will query for the post.
	 * @return string the permalink URL for this comment
	 */
	public function getUrl($oPost=null)
	{
		if($oPost===null)
		{
			$oPost = $this->post;
		}
		return $oPost->getLink() . '#c' . $this->id;
	}

	/**
	 * The hyperlink display for the current comment's author
	 * @return string
	 */
	public function getAuthorLink()
	{
		if ( ! empty($this->url))
		{
			return CHtml::link(CHtml::encode($this->author), $this->url);
		}
		else
		{
			return CHtml::encode($this->author);
		}
	}

	/**
	 * The number of comments that are pending approval
	 * @return integer
	 */
	public function getPendingCommentCount()
	{
		return $this->count('status=' . self::STATUS_PENDING);
	}

	/**
	 * Return the most recently added comments
	 * @param integer the maximum number of comments that should be returned
	 * @return array
	 */
	public function findRecentComments($limit=10)
	{
		return $this->with('post')->findAll(array(
			'condition'=>'t.status='.self::STATUS_APPROVED,
			'order'=>'t.create_time DESC',
			'limit'=>$limit,
		));
	}
}