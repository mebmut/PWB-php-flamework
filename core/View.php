<?php
namespace Core;

  class View {
    protected $_siteTitle,  $layout = 'custom';
    protected $_content=[], $_currentBuffer;

    /**
     * used to render the layout and view
     * @method render
     * @param  string $viewName path to view
     */
    public function page($viewName) {
      $viewString = self::viewString($viewName);
      if(file_exists(ROOT.'app'.DS.'themes'.DS.'default'.DS.$viewString.'.php')) {
        include(ROOT.'app'.DS.'themes'.DS.'default'.DS.$viewString.'.php');
        include(ROOT.'app'.DS.'views'.DS.'layouts'.DS.$this->layout.'.php');
      } else {
        die('The view \"' . $viewName . '\" does not exist.');
      }
    }

    public function settings($viewName) {
      $viewString = self::viewString($viewName);
      if(file_exists(ROOT.'app'.DS.'views'.DS.$viewString.'.php')) {
        include(ROOT.'app'.DS.'views'.DS.$viewString.'.php');
        include(ROOT.'app'.DS.'views'.DS.'layouts'.DS.$this->layout.'.php');
      } else {
        die('The view \"' . $viewName . '\" does not exist.');
      }
    }

    public static function viewString($viewName){
      $viewAry = explode('/', $viewName);
      $viewString = implode(DS, $viewAry);
      return $viewString;
    }
    /**
     * Used in the layouts to embed the head and body
     * @method content
     * @param  string  $type can be head or body
     * @return string       returns the output buffer of head and body
     */
    public function content($type) {
      if(array_key_exists($type,$this->_content)){
        return $this->_content[$type];
      } else {
        return false;
      }
    }

    /**
     * starts the output buffer for the head or body
     * @method start
     * @param  string $type can be head or body
     */
    public function start($type) {
      if(empty($type)) die('you must define a type');
      $this->_currentBuffer = $type;
      ob_start();
    }

    /**
     * echos the output buffer in the layout
     * @method end
     * @return string rendered html for head or body
     */
    public function end() {
      if(!empty($this->_currentBuffer)){
        $this->_content[$this->_currentBuffer] = ob_get_clean();
        $this->_currentBuffer = null;
      } else {
        die('You must first run the start method.');
      }
    }

    /**
     * Getter for the site title
     * @method siteTitle
     * @return string    site title set in the view object
     */
    public function siteTitle() {
      return $this->_siteTitle;
    }

    /**
     * Sets the page title
     * @method setSiteTitle
     * @param  string   $title used for the title
     */
    public function setSiteTitle($title) {
      $this->_siteTitle = $title;
    }

    /**
     * sets the layout to be loaded
     * @method setLayout
     * @param  string    $path name of layout
     */
    public function setLayout($path) {
      $this->layout = $path;
    }

  }
