<?php
$route = '/tags/:tag_id/';
$app->get($route, function ($tag_id)  use ($app){

	$host = $_SERVER['HTTP_HOST'];
	$tag_id = prepareIdIn($tag_id,$host);

	$ReturnObject = array();

	$Query = "SELECT * FROM tags WHERE tag_id = " . $tag_id;

	$DatabaseResult = mysql_query($Query) or die('Query failed: ' . mysql_error());

	while ($Database = mysql_fetch_assoc($DatabaseResult))
		{

		$tag_id = $Database['tag_id'];
		$tag = $Database['tag'];

		// manipulation zone

		$tag_id = prepareIdOut($tag_id,$host);

		$F = array();
		$F['tag_id'] = $tag_id;
		$F['tag'] = $tag;

		$ReturnObject = $F;
		}

		$app->response()->header("Content-Type", "application/json");
		echo format_json(json_encode($ReturnObject));
	});
 ?>
