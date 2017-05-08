<?php
/**
 * Abstract wrapper for core class functionality.
 * 
 * @since 1.0.0
 * 
 * @package    Nav Menu Manager
 * @subpackage Wrapper
 */

if (!defined('ABSPATH')) exit;

if (!class_exists('Noakes_Menu_Manager_Wrapper'))
{
	abstract class Noakes_Menu_Manager_Wrapper
	{
		/**
		 * Base plugin object.
		 * 
		 * @since 1.2.0
		 * 
		 * @access public
		 * @var    Noakes_Menu_Manager
		 */
		public $_base = null;

		/**
		 * Global cache object.
		 * 
		 * @since 1.2.0
		 * 
		 * @access public
		 * @var    Noakes_Menu_Manager_Cache
		 */
		public $_cache = null;

		/**
		 * The stored properties.
		 * 
		 * @since 1.0.0
		 * 
		 * @access protected
		 * @var    array
		 */
		protected $_properties = array();

		/**
		 * Constructor function.
		 * 
		 * @since 1.0.0
		 * 
		 * @access public
		 * @param  Noakes_Menu_Manager $base Base plugin object.
		 * @return void
		 */
		public function __construct(Noakes_Menu_Manager $base)
		{
			$this->_base = $base;
			$this->_cache = $this->_base->_cache;
		}

		/**
		 * Get a property based on the provided name.
		 * 
		 * @since 1.0.0
		 * 
		 * @access public
		 * @param  string $name Name of the property to return.
		 * @return string       Property if it is found, otherwise an empty string.
		 */
		public function __get($name)
		{
			if (!isset($this->_properties[$name]) || $this->_properties[$name] == '')
			{
				return $this->_properties[$name] = $this->_default($name);
			}

			return $this->_properties[$name];
		}

		/**
		 * Check to see if a property exists with the provided name.
		 * 
		 * @since 1.0.0
		 * 
		 * @access public
		 * @param  string  $name Name of the property to check.
		 * @return boolean       True if the property is set, otherwise false.
		 */
		public function __isset($name)
		{
			return isset($this->_properties[$name]);
		}

		/**
		 * Set the property with the provided name to the provided value.
		 * 
		 * @since 1.4.0 Added URL protection.
		 * @since 1.0.0
		 * 
		 * @access public
		 * @param  string $name  Name of the property to set.
		 * @param  string $value Value of the property to set.
		 * @return void
		 */
		public function __set($name, $value)
		{
			switch ($name)
			{
				case 'assets_url':
				case 'review_url':
				case 'support_url':
				
					$value = esc_url($value);
			}
			
			$this->_properties[$name] = $value;
		}

		/**
		 * Unset the property with the provided name.
		 * 
		 * @since 1.0.0
		 * 
		 * @access public
		 * @param  string $name Name of the property to unset.
		 * @return void
		 */
		public function __unset($name)
		{
			unset($this->_properties[$name]);
		}

		/**
		 * Get a default property based on the provided name.
		 * 
		 * @since 1.0.0
		 * 
		 * @access protected
		 * @param  string $name Name of the property to return.
		 * @return string       Empty string.
		 */
		protected function _default($name)
		{
			return '';
		}

		/**
		 * Push a value into a property array.
		 * 
		 * @since 1.0.0
		 * 
		 * @access public
		 * @param  string $name  Name of the property array to push the value into.
		 * @param  string $value Value to push into the property array.
		 * @return void
		 */
		public function _push($name, $value)
		{
			$property = $this->$name;

			if (is_array($property))
			{
				$property[] = $value;
			}

			$this->$name = $property;
		}
	}
}
