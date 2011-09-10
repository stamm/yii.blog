<?php

class PostController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow admin user
				'actions'=>array('create','update', 'admin', 'delete'),
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id=0, $url='')
	{
		CMarkdown::registerCssFile();
		if ($url)
		{
			$oPost = Post::model()->scopePublished()->find(array(
				'condition' => 'url = :url',
				'params' => array(
					':url' => $url,
				)
			));
		}
		else
		{
			$oPost = $this->loadModel($id);
			//$this->redirect('/' . $oPost->url);
		}
		if ( ! $oPost)
		{
			throw new CHttpException(404);
		}

		// rss for comments
		Yii::app()->clientScript->registerLinkTag(
			'alternate',
			'application/rss+xml',
			Yii::app()->createAbsoluteUrl($oPost->getLink(true)) . '/rss/',
			null,
			array(
				'title' => 'Комментарии к статье: ' . $oPost->title,
			)
		);
		$this->pageTitle = $oPost->title;
		$aComments = $oPost->comments;
		$oComment = $this->newComment($oPost);
		$this->render('view',array(
			'model'=>$oPost,
			'comment' => $oComment,
			'aComments' => $aComments,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Post;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Post']))
		{
			$model->attributes=$_POST['Post'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}
		elseif ( ! $model->post_time)
		{
			$model->post_time = date('Y-m-d');
		}


		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$aTags = array();
		if(isset($_POST['Post']))
		{
			$model->attributes=$_POST['Post'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}
		else
		{
			if ($model->tags)
			{
				foreach ($model->tags as $oTag)
				{
					$aTags[] = $oTag->name;
				}
			}
			//Set post time field default to today
			if ( ! $model->post_time)
			{
				$model->post_time = date('Y-m-d');
			}
			else
			{
				$model->post_time = date('Y-m-d', $model->post_time);
			}
		}

		$model->tags_string = Tag::array2string($aTags);


		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all posts
	 * @throws CHttpException
	 * @param null $tag
	 * @return void
	 */
	public function actionIndex($tag=null)
	{
		CMarkdown::registerCssFile();
		// Get last update_time of post for cache dependency
		$iDependencyPost = Post::model()->find(array(
			'select' => 'MAX(update_time) AS update_time',
		));
		$iDependencyPost = $iDependencyPost ? $iDependencyPost->update_time : 0;
		Yii::app()->setGlobalState('post.update_time', $iDependencyPost);
		$dependencyPost = new CGlobalStateCacheDependency('post.update_time');

		$dependencyTag = new CDbCacheDependency('SELECT MAX(id) FROM {{tag}}');


		$criteria=new CDbCriteria(array(
			'order'=>'create_time DESC',
			'scopes' => 'scopePublished',
		));
		// If use tag
		if (isset($tag))
		{
			if ($oTag = Tag::model()->cache(Yii::app()->params['cacheTime'], $dependencyTag)->findByAttributes(array(
				'name' => $tag,
			)))
			{
				$aPostIds = Yii::app()->db->cache(Yii::app()->params['cacheTime'], $dependencyPost)->createCommand()
					->select('post_id')
					->from('{{post_tag}}')
					->where('tag_id = :tagId', array(
						'tagId' => $oTag->id,
					))
					->queryColumn();
				$criteria->addInCondition('t.id', $aPostIds);
			}
			else
			{
				$criteria->addCondition('id = 0');
				throw new CHttpException(404, Yii::t('all', 'No such tag'));
			}
		}

		$dataProvider = new CActiveDataProvider(Post::model()->cache(Yii::app()->params['cacheTime'], $dependencyPost, 2), array(
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['postsPerPage'],
				'pageVar' => 'page',
				'params' => array(),
			),
			'criteria'=>$criteria,
		));

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Post('search');
		$model->unsetAttributes();  // clear any default values
		// By default sort by id
		$model->getDbCriteria()->mergeWith(array(
			'order' => 'id DESC',
		));
		if(isset($_GET['Post']))
			$model->attributes=$_GET['Post'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Post::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='post-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	protected function newComment($post)
	{
		$oComment = new Comment;

		$cookie_keys = array('author', 'email', 'url');

		if (isset($_POST['Comment']))
		{
			$oComment->attributes=$_POST['Comment'];
			if (isset($_POST['ajax']) && $_POST['ajax'] == 'comment-form')
			{
				echo CActiveForm::validate($oComment);
				Yii::app()->end();
			}
			if ($post->addComment($oComment))
			{
				foreach($cookie_keys as $field)
				{
					$field_cookie = 'form_' . $field;
					$cookie=new CHttpCookie($field_cookie, $oComment->{$field});
					$cookie->expire = strtotime('+1 year');
					Yii::app()->request->cookies[$field_cookie]=$cookie;
				}
				if ($oComment->status == Comment::STATUS_PENDING)
				{
					Yii::app()->user->setFlash('commentSubmitted', 'Спасибо за комментарий! Сейчас он находится на модерации, но скоро появится ;)');
				}
				$this->refresh(true, '#c' . $oComment->id);
			}
		}
		else
		{
			foreach($cookie_keys as $field)
			{
				$field_cookie = 'form_' . $field;
				if (Yii::app()->request->cookies[$field_cookie])
				{
					$oComment->{$field} = Yii::app()->request->cookies[$field_cookie]->value;
				}
			}
		}
		return $oComment;
	}
}

