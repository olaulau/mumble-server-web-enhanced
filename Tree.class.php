<?php

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
	
	//deep clone
	public function __clone() {
		if(is_object($this->content)) {
			$this->content = clone $this->content;
		}
			
		$oldChilds = $this->childs;
		$this->childs = array();
		foreach($oldChilds as $id => $child) {
			$this->childs[$id] = clone($child);
			$this->childs[$id]->parent = $this;
		}
    }
	
}
