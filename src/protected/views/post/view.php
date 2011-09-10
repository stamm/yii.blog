<?php
$this->breadcrumbs=array(
	Yii::t('Post', 'Posts')=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>Yii::t('Post', 'List Post'), 'url'=>array('index')),
	array('label'=>Yii::t('Post', 'Create Post'), 'url'=>array('create')),
	array('label'=>Yii::t('Post', 'Update Post'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('Post', 'Delete Post'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('Post', 'Manage Post'), 'url'=>array('admin')),
);

/*$cs = Yii::app()->getClientScript();
$cs->registerScriptFile('/static/js/fancybox/jquery.fancybox-1.3.4.pack.js', CClientScript::POS_HEAD)
    ->registerScriptFile('/static/js/fancybox/jquery.easing-1.3.pack.js', CClientScript::POS_HEAD)
    ->registerScriptFile('/static/js/fancybox/jquery.mousewheel-3.0.4.pack.js', CClientScript::POS_HEAD)
    ->registerCssFile('/static/js/fancybox/jquery.fancybox-1.3.4.css')
    ->registerScriptFile('http://userapi.com/js/api/openapi.js?31', CClientScript::POS_HEAD);*/

?>


<h1 class="inline"><?php echo CHtml::link(CHtml::encode($model->title), array('view', 'id'=>$model->id, 'title'=>$model->title)); ?></h1>
<span class="hint"><?php echo Yii::app()->dateFormatter->format('d MMMM', $model->post_time); ?></span>

<div class="article">
	<?php echo $model->content_display; ?>
</div>

<b><?php echo CHtml::encode($model->getAttributeLabel('tags')); ?>:</b>
<?php echo $model->tagsLink(); ?>


<div id="social-buttons">
</div>

<div id="comments">
	<?php if ( ! empty($model->commentCount) && $model->commentCount >= 1): ?>
		<h3>
			<?php echo Yii::t('Comment', '{n} comment|{n} comments', $model->commentCount); ?>:
		</h3>
		<a name="comments"></a>
		<?php $this->renderPartial('_comments',array(
			'post'=>$model,
			'comments'=>$aComments,
		)); ?>
	<?php endif; ?>


	<h3 style="padding-top:20px;"><?php echo Yii::t('Post', 'Leave comment');?></h3>
	<?php if (Yii::app()->user->hasFlash('commentSubmitted')) { ?>
		<div class="flash-success">
			<?php echo Yii::app()->user->getFlash('commentSubmitted'); ?>
		</div>
	<?php } else { ?>
		<?php $this->renderPartial('/comment/_form',array(
			'model'=>$comment,
		)); ?>
	<?php } ?>
</div>

<script type="text/javascript">
jQuery(document).ready(function() {
	//$("a.images").fancybox();
	$("a.images").fancybox({
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'speedIn'		:	600,
		'speedOut'		:	200,
		'overlayShow'	:	true,
		'overlayOpacity'	: 0.9,
		'overlayColor': 'black'
	});
});
</script>
<script type="text/javascript">
VK.Widgets.Like("vk_like", {type: "mini", pageTitle: "<?php echo str_replace('"', '\\"', $model->title); ?>"}, <?php echo $model->id; ?>);
</script>

<!-- Place this tag just before your close body tag -->
<script>
(function(d, t) {
var g = d.createElement(t),
s = d.getElementsByTagName(t)[0];
g.async = true;
g.src = 'https://apis.google.com/js/plusone.js';
s.parentNode.insertBefore(g, s);
})(document, 'script');
</script>