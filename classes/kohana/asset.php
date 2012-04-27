<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Creates an asset to be rendered in a view.
 * 
 * Helper class
 * 
 * @package    EdSolio
 * @author     EdSolio Team
 * @copyright  (c) 2010-2012 EdSolio Team
 */
class Kohana_Asset {	
	
	public $path;
	
	public $type;
	
	public $attributes;
	
	protected static $types = array(
		'css'	=> '/\.css$/',
		'js'	=> '/\.js$/',
		'view'	=> '',
	);
	
	public function __construct( $path, $type = null, $attributes = array() )
	{
		$this->path = $path;
		$this->type = $type;
		$this->attributes = $attributes;
		
		// auto detect type
		if(!isset($this->type)) {
			$this->type = $this->find_type( $this->path );
			if(!$this->type)
				throw new Kohana_Exception('Could not determine the type of the ":path" asset.', array(':path' => $this->path)); 
		}else{
			if(!isset(self::$types[$this->type]))
				throw new Kohana_Exception('The type ":type" is not a valid Asset type. Accepted Asset types are :types.', array(':type' => $this->type, ':types' => implode(', ', self::$types)));
		}
		return $this;
	}
	
	protected function find_type( $path )
	{
		foreach(self::$types as $t => $regex) {
			if(strlen($regex) && preg_match($regex, $path)) {
				return $t;
			}
		}
		return false;
	}
	
	public function equals( asset $asset )
	{
		return ($this->type === $asset->type && $this->path === $asset->path);
	}
	
	/**
	 * Returns the html for the asset
	 * 
	 * @return string $html
	 */
	public function render()
	{		
		switch($type) {
			case 'css' :
				return html::style( $this->path, $this->attributes );
				break;
			
			case 'js' :
				return html::script( $this->path, $this->attributes );
				break;
			
			case 'view' :
				return view::factory($this->path)
					->bind('attributes', $this->attributes);
				break;
			
			default :
				return null;
		}	
	}
	
	public function __toString()
	{
		return $this->render();
	}
	
}