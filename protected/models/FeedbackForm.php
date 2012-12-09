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
		$admin = 'hvuong@poncla.com';
		$mail = Yii::app()->mail->constructMessage();
		$mail->view = 'feedback/feedback';
		$mail->setBody(array('message' => $message), 'text/html');
		$mail->setSubject('Feedback from ' . $email);	
		$mail->setFrom($email);
		$mail->setTo($admin);
		Yii::app()->mail->send($mail); 
	}

}

?>