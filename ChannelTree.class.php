<?php

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
	
	public function deleteEmptychannels() {
		foreach($this->childs as $child) {
			$child->deleteEmptychannels();
		}
		if(count($this->childs) === 0  &&  count($this->userList) === 0) {
			$this->deleteNode();
		}
	}
	
}




class Tree {

	protected $content;
	protected $childs = array();
	protected $parent;
	
	public function getContent(){
		return $this->content;
	}
	
	public function getChilds(){
		return $this->childs;
	}
	
	public function getParent() {
		return $this->parent;
	}

	public function __construct($content, $parent=NULL) {
		$this->content = $content;
		$this->childs = array();
		$this->parent = $parent;
	}
	
	public function addChild($content) {
		$tmp =  new $this($content, $this);
		$this->childs[] = $tmp;
		return $tmp;
	}
	
	public function deleteNode() {
		if(isset($this->parent)) {
			$childs = &$this->parent->childs;
			foreach($childs as $id => $child) {
				if($this->content == $child->content) {
					unset($childs[$id]);
				}
			}
		}
		else {
			unset($this);
		}
	}
	
	public function toDisplayString($level=0) {
		$res = '';
		$res = str_pad($res, $level, "\t");
		$res .= $this->content;
		$res .= "\n";
		
		foreach($this->childs as $child) {
			$res .= $child->toDisplayString($level+1);;
		}
		return $res;
	}
	
}
