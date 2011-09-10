<?php

/**
 * This is the model class for table "{{post}}".
 *
 * The followings are the available columns in table '{{post}}':
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $content_display
 * @property integer $status
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $post_time
 * @property integer $author_id
 * @property string $url
 * @property string $short_url
 */
class Post extends CActiveRecord
{
	const STATUS_DRAFT=1;
	const STATUS_PUBLISHED=2;
	const STATUS_ARCHIVED=3;

	/** @var string Tags separated comma*/
	public $tags_string;

	/** @var array Disabled title for sets pages */
	static public $aDisabledTitle = array(
		'login', 'logout', 'post', 'posts', 'pages', 'gii', 'tag', 'about', 'find', 'gii', 'sitemap.xml', 'rss',
	);

	/**
	 * Returns the static model of the specified AR class.
	 * @return Post the static model class
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
		return '{{post}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, content, status, url, post_time, tags_string', 'required'),
			array('url', 'unique'),
			array('status, create_time, update_time, author_id', 'numerical', 'integerOnly'=>true),
			array('url', 'in', 'range' => self::$aDisabledTitle, 'not'=>true, 'message' => 'Not allowed to use this url'),
			array('title', 'length', 'max'=>128),
			array('url', 'length', 'max'=>255),
			array('status', 'in', 'range'=>array(1,2,3)),
			array('tags_string', 'match', 'pattern'=>'~^[\w\S\s,]+$~is', 'message'=>'В тегах можно использовать только буквы.'),
			array('short_url', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, content, content_display, status, create_time, update_time, post_time, author_id, url, short_url', 'safe', 'on'=>'search'),
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
			'author' => array(self::BELONGS_TO, 'User', 'author_id'),
			'comments' => array(self::HAS_MANY, 'Comment', 'post_id',
				'condition'=>'comments.status='.Comment::STATUS_APPROVED,
				'order'=>'comments.create_time ASC'),
			'commentCount' => array(self::STAT, 'Comment', 'post_id',
				'condition'=>'status='.Comment::STATUS_APPROVED),
			'tags' => array(
				self::MANY_MANY,
				'Tag',
				'{{post_tag}}(post_id, tag_id)'
			),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => Yii::t(__CLASS__, 'Title'),
			'content' => Yii::t(__CLASS__, 'Content'),
			'content_display' => Yii::t(__CLASS__, 'Content Display'),
			'status' => Yii::t(__CLASS__, 'Status'),
			'create_time' => Yii::t(__CLASS__, 'Create Time'),
			'update_time' => Yii::t(__CLASS__, 'Update Time'),
			'post_time' => Yii::t(__CLASS__, 'Post Time'),
			'author_id' => Yii::t(__CLASS__, 'Author'),
			'url' => Yii::t(__CLASS__, 'Url'),
			'short_url' => Yii::t(__CLASS__, 'Short Url'),
			'tags' => Yii::t(__CLASS__, 'Tags'),
			'tags_string' => Yii::t(__CLASS__, 'Tags'),
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('content_display',$this->content_display,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('update_time',$this->update_time);
		$criteria->compare('post_time',$this->post_time);
		$criteria->compare('author_id',$this->author_id);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('short_url',$this->short_url,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Return url to post
	 * @param bool $absoluteUrl
	 * @return string
	 */
	public function getLink($absoluteUrl=false)
	{
		$url = '/' . $this->url;
		if ($absoluteUrl)
		{
			$url = Yii::app()->request->getBaseUrl(true) . $url;
		}
		return $url;
	}

	/**
	 * Set needing fields
	 * @return bool
	 */
	protected function beforeSave()
	{
		if (parent::beforeSave())
		{
			$this->content_display = self::render($this->content);
			if ($this->isNewRecord)
			{
				if (empty($this->create_time))
				{
					$this->create_time = time();
				}
				if (empty($this->update_time))
				{
					$this->update_time = time();
				}

				$this->author_id = isset(Yii::app()->user->id) ? Yii::app()->user->id : 0;
			}
			else
			{
				$this->update_time = time();
			}
			$this->post_time = strtotime($this->post_time);
			return true;
		}
		else
		{
			return false;
		}
	}

	protected function afterSave()
	{
		if ( ! empty($this->tags_string))
		{
			// Delete old tags
			PostTag::model()->deleteAll('post_id = :postId', array(':postId' => $this->id));
			$aNewTags = Tag::string2array($this->tags_string);
			// Set tags
			foreach ($aNewTags as $sTag)
			{
				$oPostTag = new PostTag;
				$oPostTag->post_id = $this->id;
				if ($oTag = Tag::model()->findByAttributes(array('name'=> $sTag)))
				{
					$oPostTag->tag_id = $oTag->id;
				}
				else
				{
					$oTag = new Tag;
					$oTag->name = $sTag;
					$oTag->save();
					$oPostTag->tag_id = $oTag->id;
				}
				$oPostTag->save();
			}
		}
		parent::afterSave();
	}

	protected function afterDelete()
	{
		parent::afterDelete();
		PostTag::model()->deleteAll(array('post_id = :postId'), array(':postId' => $this->id));
		Comment::model()->deleteAll(array('post_id = :postId'), array(':postId' => $this->id));
		//Tag::model()->updateFrequency($this->tags, '');
	}


	/**
	 * Adds a new comment to this post.
	 * This method will set status and post_id of the comment accordingly.
	 * @param Comment the comment to be added
	 * @return boolean whether the comment is saved successfully
	 */
	public function addComment($comment)
	{
		if ( ! empty(Yii::app()->params['commentNeedApproval']))
		{
			$comment->status = Comment::STATUS_PENDING;
		}
		else
		{
			$comment->status = Comment::STATUS_APPROVED;
		}
		$comment->post_id = $this->id;
		$comment->ip = Yii::app()->request->userHostAddress;
		if ($comment->save())
		{

			return true;
		}
		else
		{
			return false;
		}
	}




	/**
	 * Получить Id
	 * @param string $sSearch
	 * @param bool $bOrderByDate
	 * @return array
	 */
	public function findByText($sSearch, $bOrderByDate = false)
	{
		$bSphinx = true;
		if ($bOrderByDate)
		{
			$sOrder = 'time_publish DESC';
		}
		else
		{
			$sOrder = '@weight DESC';
		}
		$sSql = "SELECT post_id
				FROM main
				WHERE
					MATCH(" . Yii::app()->db->quoteValue($sSearch) . ")
					AND iscomment = 0
				ORDER BY " . $sOrder. '
			OPTION field_weights=(title=10,content=1)';
		try
		{
			$dataReader = Yii::app()->sphinx
				->createCommand($sSql)
				->query();
		}
		catch (CDbException $e)
		{
			$bSphinx = false;
			$sSql = "SELECT id AS post_id
				FROM " . Yii::app()->db->quoteTableName(Post::model()->tableName()) . "
				WHERE
					content LIKE " . Yii::app()->db->quoteValue('%' . $sSearch . '%') . "
				ORDER BY post_time DESC";
			$dataReader = Yii::app()->db
				->createCommand($sSql)
				->query();
		}
		$aIds = array();
		while(($row=$dataReader->read()) !== false)
		{
			$aIds[] = $row['post_id'];
		}
		return array(
			$bSphinx,
			$aIds,
		);
	}


	/**
	 * Scope for published posts
	 * @return Post
	 */
	public function scopePublished()
	{
		$this->getDbCriteria()->mergeWith(array(
			'condition' => 'status=' . self::STATUS_PUBLISHED,
		));
		return $this;
	}


	/**
	 * Render content
	 * @static
	 * @param $content
	 * @return string
	 */
	static function render($content)
	{
		$oMarkdown = new CMarkdown;
		$content_display = $content;
		$content_display = $oMarkdown->transform($content_display);
		return $content_display;
	}

	/**
	 * Generate links
	 * @return string
	 */
	public function tagsLink()
	{
		$aTags = $this->tags;
		if (is_array($aTags))
		{
			foreach ($aTags as $i=>$oTag)
			{
				$aTags[$i] = CHtml::link(
					$oTag->name,
					Yii::app()->createUrl('tag/' . $oTag->name),
					array(
						'class' => 'tags',
					)
				);
			}
			return implode(', ', $aTags);
		}
	}
}