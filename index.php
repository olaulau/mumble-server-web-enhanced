<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="refresh" content="120">
	<link rel="stylesheet" type="text/css" href="index.css" media="screen" />
	<title>Userlist</title>
</head>
<body>

<?php

require_once 'functions.inc.php';

if (Ice_intversion() >= 30400) {
	require 'Ice.php';
	require 'Murmur.php';
} else {
	Ice_loadProfile();
}

$decoration = TRUE;
if(isset($_GET['decoration']) && $_GET['decoration'] === "0") {
	$decoration = FALSE;
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
		if($decoration)
			echo "<h1>" . $name . "</h1>\n";
		
		// getting raw informations
		$channels = $s->getChannels();
		$players = $s->getUsers();
		
		// display type
		$page = basename($_SERVER['PHP_SELF']);
		if($decoration) {
			?>
			<a href="<?= $page ?>?displayType=ChannelUserList">ChannelUserList</a>
			<a href="<?= $page ?>?displayType=ChannelList">ChannelList</a>
			<a href="<?= $page ?>?displayType=ChannelTree">ChannelTree</a>
			<a href="<?= $page ?>?displayType=ChannelTreeUsers">ChannelTreeUsers</a>
			<a href="<?= $page ?>?displayType=ChannelTreeReduced">ChannelTreeReduced</a>
			<br/>
			<?php
		}
		
		if(isset($_GET['displayType'])) {
			$displayType = $_GET['displayType'];
		}
		else {
			$displayType = 'ChannelTreeUsers';
		}
		
		
		if($displayType === 'ChannelUserList') {
			// sorting users by channelName
			$infos = array();
			$infos['channelName'] = array();
			$infos['nickname'] = array();
			foreach($players as $state) {
				$chan = $channels[$state->channel];
				//$infos[] = array('channelName' => $chan->name, 'nickname' => $state->name);
			
				$infos['channelName'][] = $chan->name;
				$infos['nickname'][] = $state->name;
			}
			array_multisort($infos['channelName'], $infos['nickname']);
		
		
			// display sorted users
			if($decoration) {
				?>
				<h3>connected users</h3>
				<?php
			}
			?>
			<table><tr><th>Channel</th><th>Name</th></tr>
			<?php
			for($i=0; $i<count($infos['channelName']); $i++) {
				echo "<tr>";
				echo "<td>".$infos['channelName'][$i]."</td>";
				echo "<td>".$infos['nickname'][$i]."</td>";
				echo "</tr>\n";
			}
			echo "</table>\n";
		}
		
		
		if($displayType === 'ChannelList') {
			// display channel list
			if($decoration) {
				?>
				<h3>channel list</h3>
				<?php
			}
			?>
			<table><tr><th>Channel</th></tr>
			<?php
			foreach($channels as $channel) {
				echo "<tr>";
				echo "<td>".$channel->name."</td>";
				echo "</tr>\n";
			}
			echo "</table>\n";
		}
		
	
		if($displayType === 'ChannelTree' || $displayType === 'ChannelTreeUsers' || $displayType === 'ChannelTreeReduced') {
			$channelTree = makeChannelTreeFromList($channels);
			if($displayType !== 'ChannelTree') {
				addUsersToChannelTree($channelTree, $players);
			}
			if($displayType === 'ChannelTree' || $displayType === 'ChannelTreeUsers') {
				if($decoration) {
					?>
					<h3>Full channel tree</h3>
					<?php
				}
				?><pre><?php
				echo $channelTree->toDisplayString();
				?></pre><?php
			}
			
			if($displayType === 'ChannelTreeReduced') {
				if($decoration) {
					?>
					<h3>Reduced channel tree</h3>
					<?php
				}
				?><pre><?php
				$reducerChannelTree = clone $channelTree;
				$reducerChannelTree->deleteEmptychannels();
				echo $reducerChannelTree->toDisplayString();
				?></pre><?php
			}
			
		}

	}
}
catch (Ice_LocalException $ex) {
	echo "Exception occured : <br/>";
	print_r($ex);
}

?>
</body>
</html>
