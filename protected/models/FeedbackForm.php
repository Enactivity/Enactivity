<?

/**
 * FeedbackForm Class
 *
 */
class FeedbackForm extends CFormModel
{
	public $message;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// topic, email, message are required
			array('message,', 'required'),
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
		$mail = Yii::app()->mailer->constructMessage();
		$mail->view = 'feedback/feedback';
		$mail->setBody(array('feedbackForm' => $this, 'user' => Yii::app()->user->model,), 'text/html');
		$mail->subject = 'Feedback from ' . Yii::app()->user->model->email;	
		$mail->from = 'no-reply-feedback@' . CHttpRequest::getServerName();
		$mail->to = Yii::app()->params['feedbackEmail'];
		Yii::app()->mailer->send($mail);
		return true; 
	}

}

?>