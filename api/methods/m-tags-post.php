<?php
$route = '/tags/';
$app->post($route, function () use ($app){

	$Add = 1;
	$ReturnObject = array();

 	$request = $app->request();
 	$params = $request->params();

	if(isset($params['tag'])){ $tag = mysql_real_escape_string($params['tag']); } else { $tag = ''; }

  $Query = "SELECT * FROM tags WHERE tag = '" . $tag . "'";
	//echo $Query . "<br />";
	$Database = mysql_query($Query) or die('Query failed: ' . mysql_error());

	if($Database && mysql_num_rows($Database))
		{
		$Thistag = mysql_fetch_assoc($Database);
		$tag_id = $Thistag['tag_id'];
		}
	else
		{
		$Query = "INSERT INTO tags(tag)";
		$Query .= " VALUES(";
		$Query .= "'" . mysql_real_escape_string($tag) . "'";
		$Query .= ")";
		//echo $Query . "<br />";
		mysql_query($Query) or die('Query failed: ' . mysql_error());
		$tag_id = mysql_insert_id();
		}

	$tag_id = prepareIdOut($tag_id,$host);

	$ReturnObject['tag_id'] = $tag_id;

	$app->response()->header("Content-Type", "application/json");
	echo format_json(json_encode($ReturnObject));

	});
 ?>
