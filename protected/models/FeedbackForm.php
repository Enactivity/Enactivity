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

	public function sendEmail($email, $message)
	{
		$mail = Yii::app()->mail->constructMessage();
		$mail->view = 'feedback/feedback';
		$mail->setBody($message, 'text/html');
		$mail->setSubject('Feedback from ' . $email);	
		$mail->from = $email;
		$mail->setTo('hvuong@poncla.com');
		Yii::app()->mail->send($mail); 
	}

}

?>