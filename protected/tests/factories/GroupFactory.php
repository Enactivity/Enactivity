<?php
/* factory to generate models quickly. */

class GroupFactory extends AbstractFactory {
	/**
	 * Generate a group
	 */
	
	static function make($attributes = array()) {
		$group = new Group();
		$name = StringUtils::UniqueString();
		$slug = StringUtils::UniqueString();
		$group->name = $name;
		$group->slug = $slug;
		$group->attributes = $attributes;
	    
	    return $group;
	}
	
	/**
	 * Creates a new group using make(), saves the group
	 * then return the group.
	 */
	
	static function insert($attributes = array()) {
		$group = self::make($attributes);
		$group->save();
		$insertedGroup = Group::model()->findByPk($group->id);
		return $insertedGroup;
		
	}
}