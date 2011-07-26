<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/defaultlayout';
	
	/**
	 * @var array controller level context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu = array();
	
	/**
	 * override 
	 * @param string the view to be rendered
	 */
	protected function beforeRender($view)
	{
		if(parent::beforeRender($view)) {
			
			// set the menu to MenuDefinitions::<Controller>()
			if(empty($this->menu)) {
				$this->menu = call_user_func_array(
					array('MenuDefinitions', $this->getId()), 
					array()
				);
			}
			return true;
		}

		return false;
	}
}