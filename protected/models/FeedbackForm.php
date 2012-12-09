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

	public function sendEmail($recipient, $email, $message)
	{
		$name='=?UTF-8?B?'.base64_encode($model->email).'?=';
		$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
		$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

		mail($recipient, $subject, $model->body, $headers);
	}

}

?>