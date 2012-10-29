<?php
/**
 * Story class file.
 *
 * @author ajsharma
 */

/**
 * Story provides a set of methods that can help to standardize the creation
 * of complex lists of content or 'stories'
 *
 * The 'beginWidget' and 'endWidget' call of Story widget will render
 * the open and close article tags. Most other methods of Story are wrappers
 * of the corresponding methods in {@link PHtml}. Calling them in between
 * the 'beginWidget' and 'endWidget' calls will render text labels, input fields,
 * etc.
 *
 *
 * The following is a piece of sample view code showing how to use Story:
 *
 * <pre>
 * <?php $form = $this->beginWidget('Story', array(
 *     'htmlOptions'=>array(),
 * )); ?>
 *
 * <?php $this->endWidget(); ?>
 * </pre>
 */
class Story extends CWidget
{
	/**
	 * @var array additional HTML attributes that should be rendered for the form tag.
	 */
	public $htmlOptions=array();

	/**
	 * Initializes the widget.
	 * This renders the article open tag.
	 */
	public function init()
	{
		$this->htmlOptions['class'] .= " view story";

		echo PHtml::openTag('article', $this->htmlOptions);
	}

	/**
	 * Runs the widget.
	 * This renders the article end tag.
	 */
	public function run()
	{
		echo PHtml::closeTag('article');
	}

	/**
	 * Starts the story's content section
	 * This renders the div start tag
	 */
	public function beginAvatar() {
		echo PHtml::openTag('div', array(
			'class'=>'story-avatar avatar',
		));
	}

	/**
	 * End the story's content section
	 */
	public function endAvatar() {
		echo PHtml::closeTag('div');
	}

	/**
	 * Starts the story's content section
	 * This renders the div start tag
	 */
	public function beginStoryContent() {
		// echo PHtml::openTag('div', array(
		// 	'class'=>'story-content',
		// ));
	}

	/**
	 * End the story's content section
	 */
	public function endStoryContent() {
		// echo PHtml::closeTag('div');
	}

	/**
	 * Starts the story's controls section
	 * This renders the div start tag
	 */
	public function beginControls() {
		echo PHtml::openTag('div', array(
			'class'=>'story-controls controls menu',
		));
		echo PHtml::openTag('ul');
	}

	/**
	 * End the story's controls section
	 */
	public function endControls() {
		echo PHtml::closeTag('ul');
		echo PHtml::closeTag('div');
	}
	
	
}