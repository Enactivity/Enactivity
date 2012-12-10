<?

/**
 * FeedbackForm Class
 *
 */
class FeedbackForm extends CFormModel
{
	public $email;
	public $message;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// topic, email, message are required
			array('email, message,', 'required'),
			// email has to be a valid email address
			array('email', 'email'),
		);
	}

	public function sendFeedback($attributes) {
		$this->attributes = $attributes;
		if($this->validate()) {
			return $this->sendEmail($model->email, $model->message);	
		} 
		return false;
	}

	public function sendEmail($email, $message)
	{
		$admin = 'hvuong@poncla.com';
		$mail = Yii::app()->mail->constructMessage();
		$mail->view = 'feedback/feedback';
		$mail->setBody(array('message' => $message), 'text/html');
		$mail->subject = 'Feedback of Enactivity from' . $email;	
		$mail->from = $email;
		$mail->to = $admin;
		// var_dump($mail);
		Yii::app()->mail->send($mail);
		return true; 
	}

}

?>