<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'post-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('all', 'Fields with <span class="required">*</span> are required'); ?>.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
		<?php $this->widget('ext.markitup-widget.EMarkitupWidget', array(
			'model' => $model,
			'attribute' => 'content',
			'settingsUrl' => '/static/markitup',
			'settings' => 'comment',
		))?>
		<?php echo $form->error($model,'content'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status');?>
		<?php echo $form->dropDownList($model,'status', Lookup::items('PostStatus')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'post_time'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model' => $model,
			'attribute'=>'post_time',
			//'name'=>'post_time',
			'value' => $model->post_time,
			'language' => 'ru',
			'options'=>array(
				'showAnim'=>'fold',
				'dateFormat' => 'yy-mm-dd',
			),
			'htmlOptions'=>array(
				'style'=>'height:20px;'
			),
		));
		?>
		<?php echo $form->error($model,'post_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'url'); ?>
		<?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'url'); ?>
		<?php
			$cs=Yii::app()->clientScript;
			$cs->registerCoreScript('synctranslit');
			$cs->registerScript('url-translit', '$("#Post_title").syncTranslit({destination: "Post_url"});', CClientScript::POS_READY);
		?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tags_string'); ?>
		<?php
			$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
				'model'=>$model,
				'attribute'=>'tags_string',
				'value'=>$model->tags_string,
				'source' =>'js:function(request, response) {
					jQuery.getJSON("'.$this->createUrl('tools/tagsautocomplete').'", {
						query: request.term.split(/,s*/).pop()
					}, response);
				}',
				'options' => array(
					'minLength' => '2',
					'showAnim' => 'fold',
					'search' =>'js: function() {
						var term = this.value.split(/,s*/).pop();
						if(term.length < 2)
							return false;
					 }',
					'focus' =>'js: function() {
						return false;
					 }',
					'select' =>'js: function(event, ui) {
						var terms =  this.value.split(/,s*/);
						terms.pop();
						terms.push(ui.item.value);
						terms.push("");
						this.value = terms.join(", ");
						return false;
					}',
				),
				'htmlOptions'=>array(
					'style'=>'height:20px;'
				),
			));
		?>
		<?php echo $form->error($model,'tags_string'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('all', 'Create') : Yii::t('all', 'Save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->