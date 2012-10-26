<? 
/**
 * View for individual feed models
 * 
 * @uses ActiveRecordLog $data model
 */

$story = $this->beginWidget('application.components.widgets.Story', array(
	'htmlOptions'=>array(
		'id'=>"feed-" . PHtml::encode($data->id),
		'class'=>PHtml::feedClass($data),
	),
));?>
	
	<? $story->beginStoryContent(); ?>
		<p class="story-title">
			<?
			$this->widget('application.components.widgets.UserLink', array(
				'userModel' => $data->user,
			)); 
			echo ' ';
			echo PHtml::encode(strtolower($data->modelLabel));
			echo ' ';
			if(isset($data->modelObject)):
			echo PHtml::link(
				StringUtils::truncate(PHtml::encode($data->focalModelName), 80),
				array(strtolower($data->focalModel) . '/view', 'id'=>$data->focalModelId)
			);
			else:
			echo StringUtils::truncate(PHtml::encode($data->focalModelName), 80);
			endif;
			?>
		</p>
			
		<? if($data->action == ActiveRecordLog::ACTION_UPDATED): ?>
		<p>Changed
		<? // if the referred to model was actually deleted then avoid the null pointer exception
		if(isset($data->modelObject)) {
			echo PHtml::openTag('span', array(
				'class' => 'feed-model-attribute'
			));
			echo PHtml::encode(strtolower($data->modelObject->getAttributeLabel($data->modelAttribute)));
			echo PHtml::closeTag('span');
		}
		else {
			echo PHtml::encode($data->modelAttribute);
		}
		echo ' from ';
		echo PHtml::openTag('em');
		if(is_null($data->oldAttributeValue)) {
			echo 'nothing';
		}
		elseif($data->modelObject->metadata->columns[$data->modelAttribute]->dbType == 'datetime') {
			echo Yii::app()->format->formatDateTime(strtotime($data->oldAttributeValue));
		}
		else {
			echo PHtml::encode($data->oldAttributeValue);
		}
		echo PHtml::closeTag('em');
		echo PHtml::encode(' to ');
		echo PHtml::openTag('em');
	 	if(is_null($data->newAttributeValue)) {
			echo 'nothing';
		}
		elseif($data->modelObject->metadata->columns[$data->modelAttribute]->dbType == 'datetime') {
			echo Yii::app()->format->formatDateTime(strtotime($data->newAttributeValue));
		}
		else {
			echo PHtml::encode($data->newAttributeValue);
		}
		echo PHtml::closeTag('em');
		echo PHtml::closeTag('p');
		endif; 
		?>

		<span class="created">
			<?= PHtml::link(
				PHtml::encode(Yii::app()->format->formatDateTimeAsAgo(strtotime($data->created))),
				array('feed/view', 'id'=>$data->id)
			); ?>
		</span>
	<? $story->endStoryContent(); ?>
<? $this->endWidget(); ?>