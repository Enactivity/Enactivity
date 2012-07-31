<?php
/**
 * ActiveRecord is the customized base active record class.
 * All model classes for this application should extend from this base class.
 **/
abstract class ActiveRecord extends CActiveRecord {

	/**
	 * @see ActiveRecord::scenarioLabels()
	 **/
	public function scenarioLabels() {
		throw new Exception("Needs implementation");
	}

	/**
	 * Returns the text label for the specified scenario.
	 * In particular, if the attribute name is in the form of "post.author.name",
	 * then this method will derive the label from the "author" relation's "name" attribute.
	 * @param string $attribute the attribute name
	 * @return string the attribute label
	 */
	public function getScenarioLabel($scenario)
	{
		$labels = $this->Owner->scenarioLabels();
		if(isset($labels[$scenario])) {
			return $labels[$scenario];
		}
		else if(strpos($scenario, '.') !== false)
		{
			$segs=explode('.',$scenario);
			$name=array_pop($segs);
			$model=$this;
			foreach($segs as $seg)
			{
				$relations=$model->getMetaData()->relations;
				if(isset($relations[$seg]))
					$model=CActiveRecord::model($relations[$seg]->className);
				else
					break;
			}
			return $model->getScenarioLabel($name);
		}
		else
			return $this->Owner->generateAttributeLabel($scenario);
	}
	
}