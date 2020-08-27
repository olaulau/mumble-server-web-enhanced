<?php

header('Content-type: application/json');

require_once 'functions.inc.php';

if (Ice\intversion() >= 30400) {
	require 'Ice.php';
	require 'Murmur.php';
} else {
	Ice\loadProfile();
}


try {
	if (Ice\intversion() >= 30400) {
		$ICE = Ice\initialize();
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
		
		// getting raw informations
		$channels = $s->getChannels();
		$players = $s->getUsers();
		
		// sort datas by name
		usort($channels , "objectCompareByName");
		usort($players , "objectCompareByName");
		
		if(isset($_GET['displayType'])) {
			$displayType = $_GET['displayType'];
		}
		else {
			$displayType = 'ChannelTreeUsers';
		}
		
	
		if($displayType === 'ChannelTree' || $displayType === 'ChannelTreeUsers' || $displayType === 'ChannelTreeReduced') {
			$channelTree = makeChannelTreeFromList($channels);
			if($displayType !== 'ChannelTree') {
				addUsersToChannelTree($channelTree, $players);
			}
			if($displayType === 'ChannelTree' || $displayType === 'ChannelTreeUsers') {
				$treeToDisplay = $channelTree;
			}
			elseif($displayType === 'ChannelTreeReduced') {
				$reducedChannelTree = clone $channelTree;
				$reducedChannelTree->deleteEmptychannels();
				$treeToDisplay = $reducedChannelTree;
			}
			
			echo json_encode($treeToDisplay->toJstreeObject(0, $name));
			break;
		}

	}
}
catch (Ice\LocalException $ex) {
	echo "Exception occured : <br/>";
	print_r($ex);
}

?>
