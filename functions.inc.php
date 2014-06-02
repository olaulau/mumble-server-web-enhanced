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
		$channelTree->getNodeByChannelId($user->channel)->addUser($user->name);
	}
}


/*
Murmur_User Object
(
    [session] => 201
    [userid] => 125
    [mute] => 
    [deaf] => 
    [suppress] => 
    [prioritySpeaker] => 
    [selfMute] => 
    [selfDeaf] => 
    [recording] => 
    [channel] => 58
    [name] => laulau
    [onlinesecs] => 3525
    [bytespersec] => 1873
    [version] => 66052
    [release] => 1.2.4-0.2ubuntu1
    [os] => X11
    [osversion] => Ubuntu 14.04 LTS
    [identity] => 
    [context] => 
    [comment] => 
    [address] => Array
        (
            [0] => 0
            [1] => 0
            [2] => 0
            [3] => 0
            [4] => 0
            [5] => 0
            [6] => 0
            [7] => 0
            [8] => 0
            [9] => 0
            [10] => 255
            [11] => 255
            [12] => 88
            [13] => 181
            [14] => 167
            [15] => 222
        )

    [tcponly] => 1
    [idlesecs] => 0
)
*/
