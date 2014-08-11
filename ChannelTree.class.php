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
	
	public function toJstreeObject($level=0) {
		if( count($this->getChilds() > 0) ) {
			$children = array();
			foreach($this->getUserList() as $user) {
				$children[] = array(
						'text' => $user->name,
						'icon' => '',
						'state' =>
						array(
								'opened' => false,
								'disabled' => false,
								'selected' => false,
						),
						'children' => FALSE,
				);
			}
			foreach($this->getChilds() as $child) {
				$children[] = $child->toJstreeObject($level+1);
			}
		}
		else
			$children = FALSE;
		
		$res = array(
				'text' => $this->content->name,
				'icon' => '',
				'state' =>
				array(
						'opened' => true,
						'disabled' => true,
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

