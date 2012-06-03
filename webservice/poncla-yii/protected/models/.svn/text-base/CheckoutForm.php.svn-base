<?php

/**
 * CheckoutForm class.
 * CheckoutForm is the data structure for keeping
 * contact form data.
 */
class CheckoutForm extends CFormModel
{
	public $phone;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// phone is required
			array('phone', 'required'),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'phone' => 'Phone Number',
		);
	}
}