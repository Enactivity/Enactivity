<?

/*
 * View used to return a description string
 * for facebook group feed post when deleting post
 * @author Harrison Vuong
 */

echo "Aww no. " . '"' . PHtml::encode($data->name) . '"' . " was deleted on " . Yii::app()->name . ".";	


?>