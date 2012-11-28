<? 
/**
 * View for membership model join scenario
 * @uses membership $data
 * @uses User $user
 */

// start article
echo PHtml::openTag('article', array(
	'class' => 'email'
));

// created date
echo PHtml::openTag('p');
echo PHtml::openTag('strong');
echo PHtml::openTag('time');
echo PHtml::encode(
	//FIXME: use actual event time
	Yii::app()->format->formatDateTime(time())
);
echo PHtml::closeTag('time');
echo PHtml::closeTag('strong');
echo PHtml::closeTag('p');
echo PHtml::openTag('p');

//Great news! [firstName][lastName] joined [groupName].
echo "Great news! " . PHtml::encode($user->fullName) . " joined " . PHtml::link(PHtml::encode($data->group->name), PHtml::groupUrl($data->group)) . ".";

echo PHtml::closeTag('article');
?>