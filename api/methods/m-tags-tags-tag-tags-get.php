<?php
$route = '/tags/tags/:tag/tags/';
$app->get($route, function ($tag)  use ($app){

	$ReturnObject = array();

 	$request = $app->request();
 	$params = $request->params();

	if(isset($_REQUEST['week'])){ $week = $params['week']; } else { $week = date('W'); }
	if(isset($_REQUEST['year'])){ $year = $params['year']; } else { $year = date('Y'); }

	$Query = "SELECT b.* from tags t";
	$Query .= " JOIN tag_tag_pivot btp ON t.Tag_ID = btp.Tag_ID";
	$Query .= " JOIN tags b ON btp.tag_ID = b.ID";
	$Query .= " WHERE WEEK(b.Post_Date) = " . $week . " AND YEAR(b.Post_Date) = " . $year . " AND Tag = '" . $tag . "'";

	$DatabaseResult = mysql_query($Query) or die('Query failed: ' . mysql_error());

	while ($Database = mysql_fetch_assoc($DatabaseResult))
		{

		$tag_id = $Database['tag_id'];
		$tag = $Database['tag'];
		$description = $Database['description'];
		$url = $Database['url'];

		// manipulation zone

		$host = $_SERVER['HTTP_HOST'];
		$tag_id = prepareIdOut($tag_id,$hos

		$F = array();
		$F['tag_id'] = $tag_id;
		$F['tag'] = $tag;

		array_push($ReturnObject, $F);
		}

		$app->response()->header("Content-Type", "application/json");
		echo format_json(json_encode($ReturnObject));
	});
 ?>
