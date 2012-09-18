<?
/**
 * Lists user's upcoming tasks
 * @uses calendar
 * @uses newTask
 */

$this->pageTitle = 'Next';
?>

<?= PHtml::beginContentHeader(); ?>
	<div class="menu toolbox">
		<ul>
			<li>
				<?
				echo PHtml::link(
					PHtml::encode('Recent Activity'), 
					array('feed/index'),
					array(
						'id'=>'feed-index-menu-item',
						'class'=>'neutral feed-index-menu-item',
						'title'=>'View recent history in your group',
					)
				);
				?>
			</li>
		</ul>
	</div>
	<h1><?= PHtml::encode($this->pageTitle);?></h1>
<?= PHtml::endContentHeader(); ?>

<div class="novel">
	<section class="tasks">
		<?
		if($calendar->itemCount > 0) {
			echo $this->renderPartial('_agenda', array(
				'calendar'=>$calendar,
				'showParent'=>true,
			));
		}
		else {
			//TODO: make more user-friendly
			echo PHtml::openTag('p', array('class'=>'no-results-message blurb'));
			echo 'You haven\'t signed up for any tasks.  Why not check out the ';
			echo PHtml::link('calendar', array('task/calendar'));
			echo ' to see what is listed or ';
			echo PHtml::link('create a new task', array('task/create'));
			echo '?'; 
			echo PHtml::closeTag('p');
		}
		?>		
	</section>
</div>