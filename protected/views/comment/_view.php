<? 
/**
 * View for individual comments
 * @uses $data Comment model
 */
?>
<article id="comment-<?= PHtml::encode($data->id); ?>" class="<?= PHtml::commentClass($data); ?>">
	<div class="avatar">
		<?= PHtml::image($data->creator->pictureUrl); ?>
	</div>
	<header>
		<h1 class="creator">
			<? //author 
				$this->widget('application.components.widgets.UserLink', array(
				'userModel' => $data->creator,
			));  ?>
		</h1>
		@
		<? if(isset($model)) : ?>
		<span class="created">
			<?= PHtml::encode(Yii::app()->format->formatDateTimeAsAgo(strtotime($data->created))); ?></span>
			<? else: ?>
			<?= PHtml::link(
				PHtml::encode(Yii::app()->format->formatDateTimeAsAgo(strtotime($data->created))),
				array(Yii::app()->request->pathInfo, 
					'#' => 'comment-' . $data->id,
				)
			); ?>
		</span>
		<? endif; ?>
	</header>

	<?= Yii::app()->format->formatStyledText($data->content); ?>
	
</article>