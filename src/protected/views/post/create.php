<?php

$this->pageTitle = Yii::t('Post', 'Create Post');

$this->breadcrumbs=array(
	Yii::t('Post', 'Posts')=>array('index'),
	Yii::t('All', 'Create'),
);

$this->menu=array(
	array('label'=>Yii::t('Post', 'List Post'), 'url'=>array('index')),
	array('label'=>Yii::t('Post', 'Manage Post'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('Post', 'Create Post');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>