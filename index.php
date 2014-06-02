<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="index.css" media="screen" />
	<title>Userlist</title>
</head>
<body>

<div class="head-bar">
	<p><a href="weblist.old.php">OLD</a></p>
</div>

<?php

require_once 'ChannelTree.class.php';
require_once 'functions.inc.php';

#
# Murmur.php is generated by calling
# slice2php /path/to/Murmur.ice
# in this directory
#

if (Ice_intversion() >= 30400) {
	require 'Ice.php';
	require 'Murmur.php';
} else {
	Ice_loadProfile();
}

try {
	if (Ice_intversion() >= 30400) {
		$ICE = Ice_initialize();
	}

	$base = $ICE->stringToProxy("Meta:tcp -h 127.0.0.1 -p 6502");
	$meta = $base->ice_checkedCast("::Murmur::Meta");

	$servers = $meta->getBootedServers();
	$default = $meta->getDefaultConf();
	foreach($servers as $s) {
		$name = $s->getConf("registername");
		if (! $name) {
	  		$name =  $default["registername"];
		}
		echo "<h1>" . $name . "</h1>\n";
		
		// getting raw informations
		$channels = $s->getChannels();
		$players = $s->getUsers();
		
		
		// sorting users by channelName
		$infos = array();
		foreach($players as $state) {
			$chan = $channels[$state->channel];
			//$infos[] = array('channelName' => $chan->name, 'nickname' => $state->name);
			
			$infos['channelName'][] = $chan->name;
			$infos['nickname'][] = $state->name;
		}
		array_multisort($infos['channelName'], $infos['nickname']);
		
		/*
		// display sorted users
		?>
		<h3>connected users</h3>
		<table><tr><th>Channel</th><th>Name</th></tr>
		<?php
		for($i=0; $i<count($infos['channelName']); $i++) {
			echo "<tr>";
			echo "<td>".$infos['channelName'][$i]."</td>";
			echo "<td>".$infos['nickname'][$i]."</td>";
			echo "</tr>\n";
		}
		echo "</table>\n";
		*/
		
		?>
		<br/>
		<?php
		
		/*
		// display channel list
		?>
		<h3>channel list</h3>
		<table><tr><th>Channel</th></tr>
		<?php
		foreach($channels as $channel) {
			echo "<tr>";
			echo "<td>".$channel->name."</td>";
			echo "</tr>\n";
		}
		echo "</table>\n";
		*/
		
		$channelTree = makeChannelTreeFromList($channels);
		addUsersToChannelTree($channelTree, $players);
		$fullChannelTree = $channelTree->toDisplayString();
		$channelTree->deleteEmptychannels();
		?>
		
		<h3>Full channel tree</h3>
		<pre><?php
		echo $fullChannelTree;
		?>
		</pre>
		
		<br/>

		<h3>Reduced channel tree</h3>
		<pre><?php
		echo $channelTree->toDisplayString();
		?>
		</pre>
		<?php
	}
} catch (Ice_LocalException $ex) {
	echo "Exception occured : <br/>";
	print_r($ex);
}

?>
</body>
</html>
