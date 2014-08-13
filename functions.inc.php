<?php

require_once 'ChannelTree.class.php';

function makeChannelTreeFromList($channels) {
	// recherche du channel racine
	foreach($channels as $channel) { // on parcours la liste des channels restant à traiter
		if($channel->parent === -1) { // trouvé un channel racine
			$res = new ChannelTree($channel);
			array_remove($channel, $channels);
			break;
		}
	}
	if(!isset($res)) {
		echo "pas trouvé le channel parent.";
		die;
	}

	// ajout des fils
	while(count($channels) > 0) { // tant qu'il en reste à traiter
//		echo "il en reste\n";
		foreach($channels as $channel) { // on parcours la liste des channels restant à traiter
//			echo "channel : " . $channel->name . "\n";
			$search = $res->getNodeByChannelId($channel->parent);
			if(isset($search)) {
//				echo "found parent :  " . $search->getContent()->name . "\n";
				$search->addChild($channel);
				array_remove($channel, $channels);
			}
		}
		break;
	}
	
	return($res);
}


function array_remove($value, &$array) {
	$key = array_search($value, $array);
	unset($array[$key]);
}

function addUsersToChannelTree(&$channelTree, $users) {
	foreach($users as $user) {
		$node = $channelTree->getNodeByChannelId($user->channel);
		if(isset($node))
			$node->addUser($user);
	}
}


function objectComparebyAttribute($attribute, $o1, $o2) {
	return strcasecmp($o1->$attribute, $o2->$attribute);
}
function objectCompareByName($o1, $o2) {
	return objectComparebyAttribute("name", $o1, $o2);
}
