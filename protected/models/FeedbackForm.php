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
			return $this->sendEmail();	
		} 
		return false;
	}

	protected function sendEmail()
	{
		$mail = Yii::app()->mail->constructMessage();
		$mail->view = 'feedback/feedback';
		$mail->setBody(array('feedbackForm' => $this), 'text/html');
		$mail->subject = 'Feedback of Enactivity from' . $this->email;	
		$mail->from = 'no-reply@' . CHttpRequest::getServerName();
		$mail->to = Yii::app()->params['feedbackEmail'];
		Yii::app()->mail->send($mail);
		return true; 
	}

}

?>