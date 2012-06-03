<?php 
/**
* Factory used to quickly generate model
* @author ajsharma
*/
class CartItemFactory extends AbstractFactory {
	
	/**
	 * Returns a new CartItem
	 * @param attributes, overloads default attributes
	 * @return CartItem unsaved CartItem
	*/
	public static function make($attributes = array()) {
		$cartItem = new CartItem();
		
		// overload attributes
		$cartItem->attributes = $attributes;
		
		return $cartItem;
	}
	
	/**
	 * Returns a task generated via {@link CartItemFactory::make()}
	 * @param attributes, overloads default attributes
	 * @return CartItem saved task
	 */
	public static function insert($attributes = array()) {
		$cartItem = self::make($attributes);
		
		$cartItem->insertCartItem($attributes);
		
		return CartItem::model()->findByPk($cartItem->id);
	}
}