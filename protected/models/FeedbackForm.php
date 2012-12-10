<?

/**
 * FeedbackForm Class
 *
 */
class FeedbackForm extends CFormModel
{
	public $email;
	public $userId;
	public $fullName;
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
		$this->email = Yii::app()->user->model->email;
		$this->userId = Yii::app()->user->model->id;
		$this->fullName = Yii::app()->user->model->fullName;

		$mail = Yii::app()->mail->constructMessage();
		$mail->view = 'feedback/feedback';
		$mail->setBody(array('feedbackForm' => $this), 'text/html');
		$mail->subject = 'Feedback from ' . $this->email;	
		$mail->from = 'no-reply-feedback@' . CHttpRequest::getServerName();
		$mail->to = Yii::app()->params['feedbackEmail'];
		Yii::app()->mail->send($mail);
		return true; 
	}

}

?>