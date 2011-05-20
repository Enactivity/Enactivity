<?php
/**
 * AutoExpandableTextArea class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2010 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * AutoExpandableTextArea displays a list of data items in terms of a list.
 *
 * Unlike {@link CGridView} which displays the data items in a table, AutoExpandableTextArea allows one to use
 * a view template to render each data item. As a result, AutoExpandableTextArea could generate more flexible
 * rendering result.
 *
 * AutoExpandableTextArea supports both sorting and pagination of the data items. The sorting
 * and pagination can be done in AJAX mode or normal page request. A benefit of using AutoExpandableTextArea is that
 * when the user browser disables JavaScript, the sorting and pagination automatically degenerate
 * to normal page requests and are still functioning as expected.
 *
 * AutoExpandableTextArea should be used together with a {@link IDataProvider data provider}, preferrably a
 * {@link CActiveDataProvider}.
 *
 * The minimal code needed to use AutoExpandableTextArea is as follows:
 *
 * <pre>
 * $dataProvider=new CActiveDataProvider('Post');
 *
 * $this->widget('zii.widgets.AutoExpandableTextArea', array(
 *     'dataProvider'=>$dataProvider,
 *     'itemView'=>'_post',   // refers to the partial view named '_post'
 *     'sortableAttributes'=>array(
 *         'title',
 *         'create_time'=>'Post Time',
 *     ),
 * ));
 * </pre>
 *
 * The above code first creates a data provider for the <code>Post</code> ActiveRecord class.
 * It then uses AutoExpandableTextArea to display every data item as returned by the data provider.
 * The display is done via the partial view named '_post'. This partial view will be rendered
 * once for every data item. In the view, one can access the current data item via variable <code>$data</code>.
 * For more details, see {@link itemView}.
 *
 * In order to support sorting, one has to specify the {@link sortableAttributes} property.
 * By doing so, a list of hyperlinks that can sort the data will be displayed.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @version $Id: AutoExpandableTextArea.php 2516 2010-09-29 21:22:13Z qiang.xue $
 * @package zii.widgets
 * @since 1.1
 */
class AutoExpandableTextArea extends CWidget
{
	/**
	 * @var unknown_type
	 */
	public $model;
	
	public $attribute = '';
	
	public $htmlOptions = array();
	
	/**
	 * @var string the base script URL for all resources (e.g. javascript, CSS file, images).
	 * Defaults to null, meaning using the integrated resources (which are published as assets).
	 */
	public $baseScriptUrl;
	
	/**
	 * Initializes the list view.
	 * This method will initialize required property values and instantiate {@link columns} objects.
	 */
	public function init()
	{
		parent::init();

		if($this->baseScriptUrl === null) {
			$this->baseScriptUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.components.widgets.assets')) . '/autoexpandabletextarea';
		}
	}
	
	/**
	 * Renders the view.
	 */
	public function run()
	{
		$this->registerClientScript();
		$this->renderTextArea();
	}

	/**
	 * Registers necessary client scripts.
	 */
	public function registerClientScript()
	{
		// get text area id
		PHtml::resolveNameID($this->model, $this->attribute, $this->htmlOptions);
		$textAreaId = $this->htmlOptions['id'];

		// set javascript function options
		$options=array(
//			'ajaxUpdate'=>$ajaxUpdate,
//			'ajaxVar'=>$this->ajaxVar,
//			'pagerClass'=>$this->pagerCssClass,
//			'loadingClass'=>$this->loadingCssClass,
//			'sorterClass'=>$this->sorterCssClass,
		);

		$options = CJavaScript::encode($options);
		$clientScript = Yii::app()->getClientScript();
		$clientScript->registerCoreScript('jquery');
		$clientScript->registerScriptFile($this->baseScriptUrl . '/jquery.autoexpandabletextarea.js', CClientScript::POS_END);
		$clientScript->registerScript(__CLASS__ . '#' . $this->getId(), 
			"jQuery('#$textAreaId').autoExpandableTextArea($options);");
	}

	/**
	 * Renders the text area.
	 */
	public function renderTextArea()
	{
		echo PHtml::activeTextArea($this->model, $this->attribute, $this->htmlOptions);
	}
}