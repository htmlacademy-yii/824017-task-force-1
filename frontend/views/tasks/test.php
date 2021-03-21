<?php //var_dump($task->responses[1]->user->reviews/*->rate*/) 
/*$reviews = $task->responses[1]->user::find()->select('AVG(rate) as rating')->innerJoinWith('reviews0')->where(['users.id' => 1])->groupBy('users.id')->asArray()->all();

var_dump($reviews);
echo '<br><br>';

$reviews2 = $task->responses[1]->user::findOne($task->responses[1]->user->id);
var_dump($reviews2);*/



var_dump($task);

/*var_dump($task->responses[1]->user);

echo '<br><br>';
$reviews = $task->responses[1]->user->reviews0;
$i = 0;
$ratesSum = 0;
foreach ($reviews as $review) {
	$i++;

	$ratesSum += $review->rate;
	$rating = round(($ratesSum / $i), 2);
	
}

echo '<br><br>';
	var_dump($rating);*/


 ?>