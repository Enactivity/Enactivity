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
		$to = Yii::app()->params['application.models.FeedbackForm.to'];
		$from = Yii::app()->params['application.models.FeedbackForm.from'];

		$subject = 'Feedback from ' . Yii::app()->user->model->email;	
		
		$viewPath = 'feedback/feedback';
		$viewData = array(
			'feedbackForm' => $this, 
			'user' => Yii::app()->user->model
		);
		
		return Yii::app()->mailer->batchSend($to, $subject, $viewPath, $viewData, $from);
	}
}

?>