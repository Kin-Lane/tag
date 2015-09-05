<?php
$route = '/tags/:tag_id/';
$app->put($route, function ($tag_id) use ($app){

	$host = $_SERVER['HTTP_HOST'];
	$tag_id = prepareIdIn($tag_id,$host);

	$ReturnObject = array();

 	$request = $app->request();
 	$params = $request->params();

	if(isset($params['tag'])){ $tag = mysql_real_escape_string($params['tag']); } else { $tag = ''; }

  $Query = "SELECT * FROM tags WHERE tag_id = " . $tag_id;
	//echo $Query . "<br />";
	$Database = mysql_query($Query) or die('Query failed: ' . mysql_error());

	if($Database && mysql_num_rows($Database))
		{
		$query = "UPDATE tags SET";

		$query .= " tag = '" . mysql_real_escape_string($title) . "'";

		$query .= " WHERE tag_id = '" . $tag_id . "'";

		//echo $query . "<br />";
		mysql_query($query) or die('Query failed: ' . mysql_error());
		}

	$host = $_SERVER['HTTP_HOST'];
	$tag_id = prepareIdOut($tag_id,$host);

	$F = array();
	$F['tag_id'] = $tag_id;
	$F['tag'] = $tag;

	array_push($ReturnObject, $F);

	$app->response()->header("Content-Type", "application/json");
	echo stripslashes(format_json(json_encode($ReturnObject)));

	});
 ?>
