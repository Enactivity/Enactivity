<?php
/**
 * Tests related to the initial insertion of a TaskComment model
 * @author ajsharma
 */
class InsertTaskCommentTest extends DbTestCase
{
	public $task;

	public function setUp() {
		parent::setUp();

		$this->task = new Task();
		$this->task->setAttributes(array(
			'content' => "test testing",
		));
		$this->task->saveNode();
		$this->task->scenario = Task::SCENARIO_UPDATE;
	}

	/**
	 * Insert a valid task
	 */
	public function testInsertTaskCommentValidScenarioDefault() {

		// test parameters
		$id = 42;
		$groupId = 69;
		$creatorId = 101;
		$model = "Fake";
		$modelId = 121;
		$content = "test comment";
		$created = date ("Y-m-d H:i:s", strtotime("-1 hours"));
		$modified = date ("Y-m-d H:i:s", strtotime("-1 hours"));

		// run test
		$taskComment = new TaskComment();

		$this->assertEquals(TaskComment::SCENARIO_INSERT,
		$taskComment->scenario,
			"TaskComment's default scenario is not " . TaskComment::SCENARIO_INSERT
		);

		$taskComment->attributes = array(
			'id' => $id,
			'groupId' => $groupId,
			'creatorId' => $creatorId,
			'model' => $model,
			'modelId' => $modelId,
			'content' => $content,
			'created' => $created,
			'modified' => $modified,
		);

		// confirm attribute assigned properly
		$this->assertNull($taskComment->id, 'taskComment id attribute was assigned in [' . $taskComment->getScenario() . ']');
		$this->assertNull($taskComment->groupId, 'taskComment groupId attribute was assigned in [' . $taskComment->getScenario() . ']');
		$this->assertNull($taskComment->creatorId, 'taskComment creatorId attribute was assigned in [' . $taskComment->getScenario() . ']');
		$this->assertNull($taskComment->model, 'taskComment id model was assigned in [' . $taskComment->getScenario() . ']');
		$this->assertNull($taskComment->modelId, 'taskComment id modelId was assigned in [' . $taskComment->getScenario() . ']');
		$this->assertNotNull($taskComment->content, 'taskComment content attribute was not assigned in [' . $taskComment->getScenario() . ']');

		$taskComment->task = $this->task;

		// confirm datetimes are not set
		$this->assertNull($taskComment->created, 'taskComment created attribute was assigned in [' . $taskComment->getScenario() . ']');
		$this->assertNull($taskComment->modified, 'taskComment modified attribute was assigned in [' . $taskComment->getScenario() . ']');

		// confirm validation & save works
		$this->assertTrue($taskComment->validate(), 'valid taskComment was not validated: ' . print_r($taskComment->getErrors(null), true));
		$this->assertTrue($taskComment->save(), 'valid taskComment was not saved');
	}

	/**
	 * Insert a valid task and test if content is null
	 */
	public function testInsertTaskCommentWithNullcontent() {

		$content = null;

		$taskComment = new TaskComment();
		$taskComment->setAttributes(array(
			'content' => $content,
		));

		$this->assertNull($taskComment->content, 'save content is not null');
		$this->assertFalse($taskComment->validate(), 'task without content was validated: ' . print_r($taskComment->getErrors(null), true));
		$this->assertFalse($taskComment->save(), 'task without content was saved: ' . print_r($taskComment->getErrors(null), true));
	}

	/**
	 * Insert a valid task and ensure entries are trimmed
	 */
	public function testInsertTaskCommentTrimSpaces() {

		$content = "Test Task";
		$paddedcontent = ' ' . $content . ' ';

		$taskComment = new TaskComment();
		$taskComment->task = $this->task;
		$taskComment->setAttributes(array(
			'content' => $paddedcontent,
		));

		$this->assertTrue($taskComment->save(), 'valid task was not saved: ' . print_r($taskComment->getErrors(null), true));

		$this->assertNotNull($taskComment->created, 'task created was not set');
		$this->assertNotNull($taskComment->modified, 'task modified was not set');
	}

	/**
	 * Set content input over the acceptable lengths
	 */
	public function testInsertTaskCommentExceedMaximumcontentInput() {

		$content = StringUtils::createRandomString(4000 + 1);

		$taskComment = new TaskComment();
		$taskComment->setAttributes(array(
			'content' => $content,
		));

		$this->assertFalse($taskComment->validate(), 'task with content of 256 characters was validated: ' . print_r($taskComment->getErrors(null), true));
		$this->assertFalse($taskComment->save(), 'task with content of 256 characters was saved');
	}

	/**
	 * Test task create when no content, starts and ends are set
	 */
	public function testInsertTaskCommentNoInput() {

		$content = null;

		$taskComment = new TaskComment();
		$taskComment->setAttributes(array(
			'content' => $content,
		));

		$this->assertNull($taskComment->content, 'unsaved task has a content');
		$this->assertFalse($taskComment->validate(), 'task with no inputs was validated');
		$this->assertFalse($taskComment->save(), 'task with no inputs was saved');
	}

}