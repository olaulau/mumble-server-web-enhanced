<?php

require_once 'Tree.class.php';

class ChannelTree extends Tree {

	protected $userList;
	
	public function __construct($content, $parent=NULL) {
		parent::__construct($content, $parent);
		$this->userList = array();
	}
	
	public function getChannel() {
		return $this->getContent();
	}
	
	public function getUserList() {
		return $this->userList;
	}
	
	public function getUserCount() {
		return count($this->userList);
	}
	
	public function getTotalUserCount() {
		$res = $this->getUserCount();
		foreach ($this->getChilds() as $child) {
			$res += $child->getTotalUserCount();
		}
		return $res;
	}
	
	
	public function addUser($user) {
		$this->userList[] = $user;
	}
	
	// recursive search
	public function getNodeByChannelId($id) {
		if($this->getChannel()->id === $id) {
			return $this;
		}
		foreach($this->getChilds() as $child) {
			$res = $child->getNodeByChannelId($id);
			if(isset($res)) {
				return $res;
			}
		}
		return NULL;
	}
	
	
	public function toDisplayString($level=0) {
		$res = '';
		$res = str_pad($res, $level, "\t");
		$res .= "" . $this->getChannel()->name . "";
		$res .= "\n";
		
		foreach($this->getUserList() as $user) {
			$line = '';
			$line .= str_pad($line, $level, "\t");
			$res .= $line;
			$res .= "  < " . $user->name . " >";
			$res .= "\n";
		}
		
		foreach($this->getChilds() as $child) {
			$res .= $child->toDisplayString($level+1);
		}
		return $res;
	}
	
	private static function generate_icon($svg) { // this form instead of img, the text stays aligned
		return '<i style="background-image: url(&quot;img/' . $svg . '.svg&quot;); background-position: center center; background-size: auto auto;" class="jstree-icon jstree-themeicon jstree-themeicon-custom"></i>';
	}
	public function toJstreeObject($level=0, $serverName="Root") {
		$children = array();
		
		// users
		foreach($this->getUserList() as $user) {
			if($user->idlesecs === 0)
				$icon = 'img/talking_on.svg';
			else
				$icon = 'img/talking_off.svg';

			$text = '<b>' . $user->name . '</b>';
			
			// status icons
			$text .= '<span class="status-icons">';
			if($user->recording)
				$text .= ' ' . self::generate_icon('media-record');
			if($user->suppress)
				$text .= ' ' . self::generate_icon('muted_suppressed');
			if($user->mute)
				$text .= ' ' . self::generate_icon('muted_server');
			if($user->deaf)
				$text .= ' ' . self::generate_icon('deafened_server');
			if($user->selfMute)
				$text .= ' ' . self::generate_icon('muted_self');
			if($user->selfDeaf)
				$text .= ' ' . self::generate_icon('deafened_self');
			if($user->userid != -1)
				$text .= ' ' . self::generate_icon('authenticated');
			$text .= '</span>';

			$children[] = array(
				'text' => $text,
				'icon' => $icon,
				'state' =>
				array(
					'opened' => false,
					'disabled' => false,
					'selected' => false,
				),
				'children' => FALSE,
			);
		}
		
		// sub-channels
		foreach($this->getChilds() as $child) {
			$children[] = $child->toJstreeObject($level+1);
		}
		
		// JSON array integration
		if( empty($children) )
			$children = FALSE;
		$nbUsers = $this->getTotalUserCount();
		$userNumberDisplay = ($nbUsers > 0 ? " ($nbUsers)" : "");
		$res = array(
			'text' => ( $level==0 ? $serverName : $this->getContent()->name ) . $userNumberDisplay,
			'icon' => 'img/channel.svg',
			'state' =>
			array(
				'opened' => true,
				'disabled' => false,
				'selected' => false,
			),
			'children' => $children,
		);
		
		
		if($level === 0) {
			$res = array($res);
		}
		
		return $res;
		
	}
	
	
	public function deleteEmptychannels() {
		foreach($this->getChilds() as $child) {
			$child->deleteEmptychannels();
		}
		if(count($this->getChilds()) === 0  &&  count($this->getUserList()) === 0) {
			$this->deleteNode();
		}
	}
	
}

