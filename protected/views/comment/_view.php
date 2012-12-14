<? 
/**
 * View for individual comments
 * @uses $data Comment model
 */
?>
<article id="comment-<?= PHtml::encode($data->id); ?>" class="<?= PHtml::commentClass($data); ?>">
	<div class="avatar comment-avatar">
		<?= PHtml::image($data->creator->pictureUrl); ?>
	</div>
	<div class="comment-body">
		<header>
			<h1 class="creator">
				<? //author 
					$this->widget('application.components.widgets.UserLink', array(
					'userModel' => $data->creator,
				));  ?>
			</h1>
			<span class="created">@
				<? if(isset($model)) : ?>
				<?= PHtml::encode(Yii::app()->format->formatDateTimeAsAgo(strtotime($data->created))); ?>
				<? else: ?>
				<?= PHtml::link(
					PHtml::encode(Yii::app()->format->formatDateTimeAsAgo(strtotime($data->created))),
					array(Yii::app()->request->pathInfo, 
						'#' => 'comment-' . $data->id,
					)
				); ?>
			<? endif; ?>
			</span>
		</header>

		<?= Yii::app()->format->formatStyledText($data->message); ?>
	</div>
	
</article>