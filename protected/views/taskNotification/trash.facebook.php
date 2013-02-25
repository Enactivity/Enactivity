<?

/*
 * View used to return a description string
 * for facebook group feed post when trashing post
 * @author Harrison Vuong
 */

echo "Aww. " . '"' . PHtml::encode($data->name) . '"' . " was trashed on " . Yii::app()->name . ".";	

?>