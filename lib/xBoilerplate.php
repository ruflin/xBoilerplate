<?php
/**
 * xBoilerplate: Xodoa Boilerplate package
 *
 * @category Xodoa
 * @package  xBoilerplate
 * @copyright Copyright (c) 2007-2012 Xodoa (http://xodoa.com)
 * @author   Nicolas Ruflin <ruflin@xodoa.com>
 **/

class xBoilerplate {

	/**
	 * @var string Page title
	 */
	public $title = null;

	/**
	 * @var string Page description
	 */
	public $description = null;

	/**
	 * @var string Page keywords
	 */
	public $keywords = null;

	protected $_params = array();

	/**
	 * @var string Base path to load content files
	 */
	protected $_basePath = '';

	/**
	 * @var array Config array
	 */
	protected $_config = null;

	/**
	 * @param string $page Page path
	 * @param array $params OPTIONAL Params list
	 */
	public function __construct($page, array $params = array()) {

		// Remove first slash
		$page = substr($page, 1);

		// Removes slash at the end
		if (substr($page, -1, 1) == '/') {
			$page = substr($page, 0, strlen($page) - 1);
		}

		// Default page is always index
		if (empty($page)) {
			$page = 'index';
		}

		$this->_page = $page;
		$this->_params = $params;

		// Content is loaded from httpdocs
		$this->_basePath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'httpdocs' . DIRECTORY_SEPARATOR;
	}

	/**
	 * @return string Image path
	 */
	public function img() {
		return $this->_getSourcePath('img', $this->getConfig()->cdn['img']);
	}

	/**
	 * @return string Css source path
	 */
	public function css() {
		return $this->_getSourcePath('css', $this->getConfig()->cdn['css']);
	}

	/**
	 * @return string JS Source path
	 */
	public function js() {
		return $this->_getSourcePath('js', $this->getConfig()->cdn['js']);
	}

    /**
     * @return string Font Source path
     */
    public function font() {
        return $this->_getSourcePath('font', $this->getConfig()->cdn['font']);
    }

	/**
	 * @param string $type
	 * @param string $url
	 * @return string Path with version and cdn inside
	 */
	protected function _getSourcePath($type, $cdn = null) {
		$version = $this->getConfig()->version;

		$url = $type . '/';

		if ($version) {
			$url .= $version . '/';
		}

		if ($cdn) {
			$url = $cdn . $url;
		} else {
			$url = '/' . $url;
		}

		return $url;
	}

	/**
	 * Renders the page template
	 *
	 * @return string Returns the rendered page
	 */
	public function render() {

		try {
			$body = $this->loadLayout('template.php');
		} catch(UnexpectedValueException $e) {
			// Clean ouput first
			ob_clean();
			$this->_page = 'page-not-found';
			$body = $this->loadLayout('template.php');
		}

		// Only loads raw page
		if ($this->getConfig()->raw) {
			$page = $this->loadPage();
		} else {
			// Template has be loaded first to set title, description, keywords first
			$header = $this->loadLayout('header.php');
			$footer = $this->loadLayout('footer.php');

			$page = $header . $body . $footer;
		}


		return $page;
	}

	/**
	 * @param string $cssFile
	 * @return string Css content
	 */
	public function loadCss($cssFile) {
		$file = 'css/' . $cssFile;
		return $this->_loadFile($file);
	}

	/**
	 * @param string $jsFile
	 * @return string Js content
	 */
	public function loadJs($jsFile) {
		$file = 'js/' . $jsFile;
		return $this->_loadFile($file);
	}

	/**
	 * Loads the content of the given component. Component path without .php
	 *
	 * @param string $component Component path / name
	 * @return string
	 */
	public function loadComponent($component) {
		$file = 'component/' . $component . '.php';
		return $this->_loadFile($file);
	}

	/**
	 * Dynamically loads a css file based on the page
	 *
	 * @return string CSS HTML include
	 */
	public function loadPageCss() {
		$file = 'css/page/' . $this->_page . '.css';
		$content = '';

		if (file_exists($this->_basePath . $file)) {
			$content = '<link type="text/css" rel="stylesheet" href="/' . $file . '">';
		}
		return $content;
	}

	/**
	 * Dynamically loads a js file based on the page
	 *
	 * @return string CSS HTML include
	 */
	public function loadPageJs() {
		$file = 'js/page/' . $this->_page . '.js';
		$content = '';

		if (file_exists($this->_basePath . $file)) {
			$content = '<script src="/' . $file . '"></script>';
		}
		return $content;
	}

	/**
	 * Loads layout files
	 *
	 * @param string $name Loads a layout file
	 * @return string Layout content
	 */
	public function loadLayout($name) {
		return $this->_loadFile('layout/' . $name);
	}


	/**
	 * Loads dynamically a menu. If no menu name is set, the menu is loaded
	 * based on the category from the menu folder
	 *
	 * @param string $name OPTIONAL Menu name to load
	 * @return string
	 */
	public function loadMenu($name = null, $level = null) {

		$page = $this->_page;

		// Automaticaly loads the menu on the defined level
		if (is_null($name) && !is_null($level)) {
			$levels = explode('/', $page);

			if (count($levels) >= $level) {
				$levels = array_slice($levels, 0, $level + 1);
				$name = implode('/', $levels);
			}
		}

		$file = 'menu/' . $name . '.php';

		try {
			$content = $this->_loadFile($file);
		} catch(UnexpectedValueException $e) {
			$content = '';
		}

		return $content;
	}

	/**
	 * Loads the content for a specific page
	 *
	 * If the page is not found, content of page page-not-found is returned
	 *
	 * @return string Page content
	 */
	public function loadPage() {
		$file = 'page/' . $this->_page . '.php';
		return $this->_loadFile($file);
	}

	/**
	 * Loads a file relative to the base path
	 *
	 * @param strin $file Path to file
	 * @return string
	 * @throws Exception If invalid file
	 */
	protected function _loadFile($file) {
		// TODO: add more security checks
		if (strpos($file, '..') !== false || substr($file, 0, 1) == '/') {
			throw new UnexpectedValueException('Invalid file path:' . $file);
		}

		$file = $this->_basePath . $file;

		if (!file_exists($file)) {
			throw new UnexpectedValueException('File does not exist: ' . $file);
		}

		ob_start();
		include($file);
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}

	/**
	 * @param string $name Param to read out
	 * @return mixed|null|string
	 */
	protected function _getParam($name) {
		$param = null;
		if (isset($this->_params[$name])) {
			$param = $this->_params[$name];
		}
		$param = $this->_filterParam($param);
		return $param;
	}

	/**
	 * Filters a param for security reason
	 *
	 * @param string $param Param content
	 * @return string Filtered param
	 */
	protected function _filterParam($param) {
		// For security reasons
		$param = stripslashes(strip_tags($param));

		$notAllowed = array('\'', '*', '/', ' ',);
		$param = str_replace($notAllowed, '', $param);

		return $param;
	}

	/**
	 * Checks if the given category / page is active
	 *
	 * @param string $c
	 * @param string $p
	 * @return string Returns 'active' if is active
	 */
	public function getActive($page) {
		if (empty($page)) {
			$page = '/index';
		}

		if ($page == '/' . $this->_page) {
			return 'active';
		}
		return '';
	}

	/**
	 * Returns the config object
	 *
	 * This is the merged array of config.php and local.php (if exists)
	 * The config is only loaded once and also can be modified during runtime
	 *
	 * @return object
	 */
	public function getConfig() {

		// Only loads config once
		if (!$this->_config) {
			// Load default config file
			$configDir = dirname($this->_basePath) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR;
			include $configDir . 'config.php';

			$localFile = $configDir . 'local.php';

			// Include local config file if exists
			if (file_exists($localFile)) {
				// Store current config
				$baseConfig = $config;
				include $localFile;
				$config = array_merge($baseConfig, $config);
			}
			$this->_config = (object) $config;
		}

		return $this->_config;
	}
}
