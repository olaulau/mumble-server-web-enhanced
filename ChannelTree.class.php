<?php

class ChannelTree extends Tree {
	
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
		$res .= $this->content->name;
		$res .= "\n";
		
		foreach($this->childs as $child) {
			$res .= $child->toDisplayString($level+1);;
		}
		return $res;
	}
	
}




class Tree {

	protected $content;
	protected $childs = array();
	
	public function getContent(){
		return $this->content;
	}
	
	public function getChilds(){
		return $this->childs;
	}

	public function __construct($content) {
		$this->content = $content;
		$this->childs = array();
	}
	
	public function addChild($content) {
		$this->childs[] = new $this($content);
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
