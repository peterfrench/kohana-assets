<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Helps include assets in template view.
 *		
 *		$assets = assets::instance('core', 'assets/');
 *		$assets->add('js/jquery.js'); // adds file
 *		echo $assets; // renders all assets
 * 
 * Helper class
 * 
 * @package    EdSolio
 * @author     EdSolio Team
 * @copyright  (c) 2010-2012 EdSolio Team
 */
class Kohana_Assets {	
	
	public $base_path;
	
	public $files = array();
	
	protected static $default = 'default';
	protected static $instances = array();
	
	protected function __construct($base_path = null)
	{
		$this->base_path = $base_path;
		foreach(asset::$types as $type => $reg)
			$this->files[$type] = array();
	}
	
	
	/**
	 * Get a singleton asset instance. 
	 *
	 *     // Load the default assets for current request
	 *     $asset = assets::instance();
	 *
	 *     // Create a custom configured instance
	 *     $asset = assets::instance('custom', '/assets');
	 *
	 * @param	string	instance name
	 * @param   string  base path to files
	 * @return  asset
	 */
	public static function instance( $name = null, $base_path = null )
	{
		if($name === null) $name = assets::$default;
		if(!isset(assets::$instances[$name])) {
			assets::$instances[$name] = new Kohana_Assets( $base_path );
		}
		return assets::$instances[$name];
	}
	
	/**
	 * Add a file to the asset
	 * 
	 * @param string $path
	 *		path to file, relative to the root (minus the asset's base_path)
	 * @param string $type
	 *		type of file, ie: js, css, view, config
	 * @param array $attributes
	 *		attributes to be applied to tag on render
	 * @return Kohana_Asset this assest
	 */
	public function add($path, $type = null, array $attributes = array())
	{
		// add multiple assets
		if($type == 'config') {
			$config = kohana::$config->load($this->base_path.$path);
			foreach($config as $item) {
				$this->add($item->path, isset($item->type) ? $item->type : null, isset($item->attributes) ? $item->attributes : null);
			}
		
		// add single asset
		}else{			
			$asset = new asset(
				(!preg_match('/^http/', $path)) ? $this->base_path.$path : ''.$path,
				$type,
				$attributes
			);
			// check to see if it exists
			if(!$this->has_asset( $asset )) {
				$this->files[$asset->type][$asset->path] = $asset;
			}
		}
		return $this;
	}
	
	
	/**
	 * Checks to see if file has already been added to the asset.
	 * 
	 * @param string $path
	 *		Path to file
	 * @return boolean
	 *		True if asset already has file
	 */
	public function has_asset( asset $asset )
	{
		return isset($this->files[$asset->type][$asset->path]) && $asset->equals( $this->files[$asset->type][$asset->path] );
	}
	
	
	/**
	 * Returns the html for all the assets' files.
	 * 
	 * @param string $asset_type
	 *		type to filter for, 'js', 'css', etc.
	 * @return string
	 *		html for all the asset's files
	 */
	public function render($asset_type = null)
	{
		$html = '';
		
		// load group of assets
		if($asset_type) {
			foreach($this->files[$asset_type] as $asset) {
				$html .= $asset."\n";
			}			
		// load all assets
		}else{
			foreach($this->files as $type => $paths) {
				foreach($paths as $asset) {
					$html .= $asset."\n";
				}
			}			
		}
		
		return $html;	
	}
	
	public function __toString()
	{
		return $this->render();
	}
	
}