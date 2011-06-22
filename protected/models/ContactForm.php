<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data.
 */
class ContactForm extends CFormModel
{
	public $email;
	public $subject = 'Contact form';
	public $body = 'New interest from: ';

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('email', 'required'),
			// email has to be a valid email address
			array('email', 'email'),
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
		);
	}
	
	/**
	 * Send a contact email
	 */
	public function sendEmail() {
		$headers = "From: {$this->email}\r\nReply-To: {$this->email}";
		$mailed = mail(
			Yii::app()->params['adminEmail'], 
			$this->subject, 
			$this->body . $this->email, 
			$headers
		);
		Yii::app()->user->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
	}
}