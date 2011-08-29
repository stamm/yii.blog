<a name="addComment"></a>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'comment-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'action'=>'#addComment',
)); ?>

	<p class="note"><?php echo Yii::t('all', 'Fields with <span class="required">*</span> are required'); ?>.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'author'); ?>
		<?php echo $form->textField($model,'author',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'author'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'url'); ?>
		<?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'url'); ?>
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
		<?php echo $form->labelEx($model,'verifyCode'); ?>
		<div>
		<?php $this->widget('CCaptcha', array(
				'captchaAction'=>'site/captcha',
				'buttonLabel' => Yii::t('all', 'Refresh'),
				'buttonOptions' => array(
					'class' => 'dotted'
				)
			)); ?>
		<?php echo $form->textField($model,'verifyCode'); ?>
		</div>
		<div class="hint"><?php echo Yii::t('all', 'The code is case-sensitive');?></div>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('all', 'Create') : Yii::t('all', 'Save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->