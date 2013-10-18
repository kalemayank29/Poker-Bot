<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title>PhpFiddle Initial Code</title>

<script type="text/javascript" src="/js/jquery/1.7.2/jquery.min.js"></script>

<script type="text/javascript">
$(function(){

});
</script>

<style type="text/css">
	
</style>
</head>
<body>
<?php

//All Functions written under this heading.

function toRaise($confidence)
{
		$raise=20+$confidence*7;
		$url = "http://nolimitcodeem.com/api/players/68b1f6cf-e465-4f9b-becf-a549d36a32e1/action";
	    $data = array("action_name"=>"raise","amount"=>$raise);
	    $data_string = json_encode($data);
	    $ch=curl_init($url);
	    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	    curl_setopt($ch, CURLOPT_HEADER, true);
	    curl_setopt($ch, CURLOPT_HTTPHEADER,
	               array('Content-Type:application/json',
	                      'Content-Length: ' . strlen($data_string))
	               );

	    $result = curl_exec($ch);
	    curl_close($ch);
}

function toCall()
{
$url = "http://nolimitcodeem.com/api/players/68b1f6cf-e465-4f9b-becf-a549d36a32e1/action";
	    $data = array("action_name"=>"call");
	    $data_string = json_encode($data);
	    $ch=curl_init($url);
	    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	    curl_setopt($ch, CURLOPT_HEADER, true);
	    curl_setopt($ch, CURLOPT_HTTPHEADER,
	               array('Content-Type:application/json',
	                      'Content-Length: ' . strlen($data_string))
	               );

	    $result = curl_exec($ch);
	    curl_close($ch);
}

function toCheck()
{
$url = "http://nolimitcodeem.com/api/players/68b1f6cf-e465-4f9b-becf-a549d36a32e1/action";
	    $data = array("action_name"=>"check");
	    $data_string = json_encode($data);
	    $ch=curl_init($url);
	    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	    curl_setopt($ch, CURLOPT_HEADER, true);
	    curl_setopt($ch, CURLOPT_HTTPHEADER,
	               array('Content-Type:application/json',
	                      'Content-Length: ' . strlen($data_string))
	               );

	    $result = curl_exec($ch);
	    curl_close($ch);
}

function toFold()
{
$url = "http://nolimitcodeem.com/api/players/68b1f6cf-e465-4f9b-becf-a549d36a32e1/action";
	    $data = array("action_name"=>"fold");
	    $data_string = json_encode($data);
	    $ch=curl_init($url);
	    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	    curl_setopt($ch, CURLOPT_HEADER, true);
	    curl_setopt($ch, CURLOPT_HTTPHEADER,
	               array('Content-Type:application/json',
	                      'Content-Length: ' . strlen($data_string))
	               );

	    $result = curl_exec($ch);
	    curl_close($ch);
}

function isConnected($data, &$confidence) {
	$nums_connected = 0;
	for($i = 0; $i < sizeof($data->hand); $i = $i +1) {
		for($j = 0; $j < sizeof($data->community_cards); $j = $j + 1) {
			$a = 0;
			$b = 0;
			$hand = substr($data->hand[$i], 0, 1);
			$community = substr($data->community_cards[$j], 0, 1);
			if ('2' <= $hand && $hand <= '9') $a = (int) ($hand - 49);
			else if ($hand == 'T') $a = 9;
			else if ($hand == 'J') $a = 10;
			else if ($hand == 'Q') $a = 11;
			else if ($hand == 'K') $a = 12;
			else if ($hand == 'A') $a = 13;
			else;
			
			if ('2' <= $community && $community <= '9') $b = (int) ($hand - 49);
			else if ($community == 'T') $b = 9;
			else if ($community == 'J') $b = 10;
			else if ($community == 'Q') $b = 11;
			else if ($community == 'K') $b = 12;
			else if ($community == 'A') $b = 13;
			else;
			
			if (abs(a - b) <= 1) $count++;
			if (a == b) $count++;
		}
	}
	$count = $count - 4;
	if ($count > 0) {
		$confidence = $confidence + $count;
	}
}


function probability($data,&$confidence) {
	$count = array(0,0,0,0);
	//S H C D
	for ($i = 0; $i <= 1; $i ++) {
		$x = substr($data->hand[$i],1);
		if ($x == 'S') $count[0]=$count[0]+1;
		else if ($x == 'H') $count[1]=$count[1]+1;
		else if ($x == 'C') $count[2]=$count[2]+1;
		else $count[3]=$count[3]+1;
	}
	for ($i = 0; $i <= sizeof($data->community_cards); $i ++) {
		$x = substr($data->community_cards[$i],1);
		if ($x == 'S') $count[0] = $count[0]+1;
		else if ($x == 'H') $count[1]=$count[1]+1;
		else if ($x == 'C') $count[2]=$count[2]+1;
		else $count[3]=$count[3]+1;
	}
	$sum = sizeof($data->community_cards) + 2;
	for ($i = 0; $i < 4; $i++)
		{if ($count[i]/$sum > .6)
			{$confidence++;}
		}
}


$json = file_get_contents('http://nolimitcodeem.com/api/players/68b1f6cf-e465-4f9b-becf-a549d36a32e1'); // this WILL do an http request for you
$data = json_decode($json);


$confidence=0;
$previous_round=0;
while($data->lost_at==null)
{

$json = file_get_contents('http://nolimitcodeem.com/api/players/68b1f6cf-e465-4f9b-becf-a549d36a32e1'); // this WILL do an http request for you
$data = json_decode($json);


	if($data->your_turn)
	{	
		if($data->round_id>$previous_round) //first hand dealt
		{	$a = 0;
			$b = 0;
			$confidence=0;
			$x = substr($data->hand[0], 0, 1);
			$y = substr($data->hand[1], 0, 1);

			if ('2' <= $x && $x <= '9') $a = (int) ($x - 49);
			else if ($x == 'T') $a = 9;
			else if ($x == 'J') $a = 10;
			else if ($x == 'Q') $a = 11;
			else if ($x == 'K') $a = 12;
			else if ($x == 'A') $a = 13;
			else;
		
		if ('2' <= $y && $y <= '9') $b = (int) ($y - 49);
			else if ($y == 'T') $b= 9;
			else if ($y == 'J') $b = 10;
			else if ($y == 'Q') $b = 11;
			else if ($y == 'K') $b = 12;
			else if ($y == 'A') $b = 13;
			else;
		
		if (abs($a - $b) <= 1) $confidence++;
		if ($a == $b) $confidence++;
		//return check

		if($x == 'T'|| $x == 'J'|| $x == 'Q' || $x == 'K' || $x == 'A')
		{
			$confidence++;
		}
		}

		if($data->betting_phase=="deal")
		{
			if($data->call_amount==0)
			{
				toCheck();
			}
			else if($data->call_amount<=0.3*$data->stack)
			{	toCall();
			}
			else
			{
				toFold();
			}
		}
		else if($data->betting_phase=="flop")
		{
			probability($data,$confidence);
			isConnected($data,$confidence);
			if($confidence<2)
			{
				toFold();
			}
			else if($confidence>=4)
			{
				toRaise($confidence);
			}
			else
			{
				toCall();
			}
		}
			else if($data->betting_phase=="turn")
		{
			probability($data,$confidence);
			isConnected($data,$confidence);

			if($confidence<3)
			{
				toFold();
			}
			else if($confidence>=6)
			{
				toRaise($confidence);
			}
			else
			{
				toCall();
			}
		}
			else if($data->betting_phase=="river")
		{
			probability($data,$confidence);
			isConnected($data,$confidence);

			if($confidence<4)
			{
				toFold();
			}
			else if($confidence>=7)
			{
				toRaise($confidence);
			}
			else
			{
				toCall();
			}
		}

	}

	$previous=$data->round_id;

}

?>

</body>
</html>






		
		
		

