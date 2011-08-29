<ol class="comments">
<?php $first = false; ?>
<?php foreach($comments as $comment): ?>
	<li class="comment<?php echo ! $first ? ' first' : '' ?>" id="c<?php echo $comment->id; ?>">
		<?php $first = true; ?>
		<div class="head">
			<span class="link">
				<?php echo $comment->authorLink; ?>
				<?php echo CHtml::link("#", $comment->getUrl($post), array(
				'class'=>'cid',
				'title'=>'Ссылка на комментарий',
			)); ?>
			</span>
			<div class="avatar">
				<img src="http://www.gravatar.com/avatar/<?php echo md5($comment->email);?>/?s=36" alt="<?php echo $comment->author; ?>" />
			</div>
			<span class="date">[<?php echo date('Y-m-d H:i',$comment->create_time); ?>]</span>
		</div>

		<div class="content">
			<?php echo Escape::escapeHtml($comment->content); ?>
		</div>

	</li><!-- comment -->
<?php endforeach; ?>
</ol>