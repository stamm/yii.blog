<?php
$this->breadcrumbs=array(
	Yii::t('all','Posts')=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	Yii::t('all', 'Update'),
);

$this->menu=array(
	array('label'=>Yii::t('Post', 'List Post'), 'url'=>array('index')),
	array('label'=>Yii::t('Post', 'Create Post'), 'url'=>array('create')),
	array('label'=>Yii::t('Post', 'View Post'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('Post', 'Manage Post'), 'url'=>array('admin')),
);
?>

<h1>Update Post <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>