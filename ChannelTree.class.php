<?php

require_once 'Tree.class.php';

class ChannelTree extends Tree {

	protected $userList;
	
	public function __construct($content, $parent=NULL) {
		parent::__construct($content, $parent);
		$this->userList = array();
	}
	
	public function getUserList() {
		return $this->userList;
	}
	
	public function addUser($user) {
		$this->userList[] = $user;
	}
	
	// recursive search
	public function getNodeByChannelId($id) {
		if($this->content->id === $id) {
			return $this;
		}
		foreach($this->childs as $child) {
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
		$res .= "" . $this->content->name . "";
		$res .= "\n";
		
		foreach($this->userList as $user) {
			$line = '';
			$line .= str_pad($line, $level, "\t");
			$res .= $line;
			$res .= "  < " . $user . " >";
			$res .= "\n";
		}
		
		foreach($this->childs as $child) {
			$res .= $child->toDisplayString($level+1);;
		}
		return $res;
	}
	
	public function toJstreeObject($level=0) {
		if( count($this->childs>0) ) {
			$children = array();
			foreach($this->childs as $child) {
				$children[] = $child->toJstreeObject($level+1);
			}
		}
		else
			$children = FALSE;
		
		$res = stdClass::__set_state(array(
			'text' => $this->content->name,
			'icon' => '',
			'state' => 
				stdClass::__set_state(array(
				'opened' => true,
				'disabled' => true,
				'selected' => false,
			)),
			'children' => $children,
		));
		
		if(level===0) {
			$res = array($res);
		}
		
	}
	
	public function deleteEmptychannels() {
		foreach($this->childs as $child) {
			$child->deleteEmptychannels();
		}
		if(count($this->childs) === 0  &&  count($this->userList) === 0) {
			$this->deleteNode();
		}
	}
	
}

