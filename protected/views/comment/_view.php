{{! @uses $comment Comment model }}
<article id="comment-<?= PHtml::encode($comment->id); ?>" class="<?= PHtml::commentClass($comment); ?>">
	<div class="avatar">
		<?= PHtml::image($comment->creator->pictureUrl); ?>
	</div>
	<header>
		<h1 class="creator">
			<? //author 
				$this->widget('application.components.widgets.UserLink', array(
				'userModel' => $comment->creator,
			));  ?>
		</h1>
		<span class="created">@
			<? if(isset($model)) : ?>
			<?= PHtml::encode(Yii::app()->format->formatDateTimeAsAgo(strtotime($comment->created))); ?>
			<? else: ?>
			<?= PHtml::link(
				PHtml::encode(Yii::app()->format->formatDateTimeAsAgo(strtotime($comment->created))),
				array(Yii::app()->request->pathInfo, 
					'#' => 'comment-' . $comment->id,
				)
			); ?>
		<? endif; ?>
		</span>
	</header>

	<?= Yii::app()->format->formatStyledText($comment->content); ?>
	
</article>