<?php

namespace League\Plates\Template;

use Exception;
use League\Plates\Engine;
use LogicException;
use Throwable;

/**
 * Container which holds template data and provides access to template functions.
 */
class Template
{
    /**
     * Instance of the template engine.
     * @var Engine
     */
    protected $engine;

    /**
     * The name of the template.
     * @var Name
     */
    protected $name;

    /**
     * The data assigned to the template.
     * @var array
     */
    protected $data = array();

    /**
     * An array of section content.
     * @var array
     */
    protected $sections = array();

    /**
     * The name of the section currently being rendered.
     * @var string
     */
    protected $sectionName;

    /**
     * Whether the section should be appended or not.
     * @var boolean
     */
    protected $appendSection;

    /**
     * The name of the template layout.
     * @var string
     */
    protected $layoutName;

    /**
     * The data assigned to the template layout.
     * @var array
     */
    protected $layoutData;

    /**
     * Create new Template instance.
     * @param Engine $engine
     * @param string $name
     */
    public function __construct(Engine $engine, $name)
    {
        $this->engine = $engine;
        $this->name = new Name($engine, $name);

        $this->data($this->engine->getData($name));

        $this->path = (!empty($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'];
        /**
         * Optimized code to work on local with virtualhosts or localhost or production server
         */
        $this->path = (!empty($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'];

        $app_name = "plate";
        switch( $this->path ) {
            case "http://localhost":
                $this->path .= "/".$app_name."/";
                break;

            case "http://fabricadesoluciones.info":
                $this->path .= "/".$app_name."/";
                break;

            default:
                $this->path .= "/";
                break;
        }
        // $this->path = $_SERVER['HTTP_HOST'] == 'localhost:8888' ? '/fabricadesoluciones.com/' : '';
    }

    /**
     * Magic method used to call extension functions.
     * @param  string $name
     * @param  array  $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return $this->engine->getFunction($name)->call($this, $arguments);
    }

    /**
     * Alias for render() method.
     * @throws \Throwable
     * @throws \Exception
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * Assign or get template data.
     * @param  array $data
     * @return mixed
     */
    public function data(array $data = null)
    {
        if (is_null($data)) {
            return $this->data;
        }

        $this->data = array_merge($this->data, $data);
    }

    /**
     * Check if the template exists.
     * @return boolean
     */
    public function exists()
    {
        return $this->name->doesPathExist();
    }

    /**
     * Get the template path.
     * @return string
     */
    public function path()
    {
        return $this->name->getPath();
    }

    /**
     * Render the template and layout.
     * @param  array  $data
     * @throws \Throwable
     * @throws \Exception
     * @return string
     */
    public function render(array $data = array())
    {
        $this->data($data);
        unset($data);
        extract($this->data);

        if (!$this->exists()) {
            throw new LogicException(
                'The template "' . $this->name->getName() . '" could not be found at "' . $this->path() . '".'
            );
        }

        try {
            $level = ob_get_level();
            ob_start();

            include $this->path();

            $content = ob_get_clean();

            if (isset($this->layoutName)) {
                $layout = $this->engine->make($this->layoutName);
                $layout->sections = array_merge($this->sections, array('content' => $content));
                $content = $layout->render($this->layoutData);
            }

            return $content;
        } catch (Throwable $e) {
            while (ob_get_level() > $level) {
                ob_end_clean();
            }

            throw $e;
        } catch (Exception $e) {
            while (ob_get_level() > $level) {
                ob_end_clean();
            }

            throw $e;
        }
    }

    /**
     * Set the template's layout.
     * @param  string $name
     * @param  array  $data
     * @return null
     */
    public function layout($name, array $data = array())
    {
        $this->layoutName = $name;
        $this->layoutData = $data;
    }

    /**
     * Start a new section block.
     * @param  string  $name
     * @return null
     */
    public function start($name)
    {
        if ($name === 'content') {
            throw new LogicException(
                'The section name "content" is reserved.'
            );
        }

        if ($this->sectionName) {
            throw new LogicException('You cannot nest sections within other sections.');
        }

        $this->sectionName = $name;

        ob_start();
    }

    /**
     * Start a new append section block.
     * @param  string $name
     * @return null
     */
    public function push($name)
    {
        $this->appendSection = true;

        $this->start($name);
    }

    /**
     * Stop the current section block.
     * @return null
     */
    public function stop()
    {
        if (is_null($this->sectionName)) {
            throw new LogicException(
                'You must start a section before you can stop it.'
            );
        }

        if (!isset($this->sections[$this->sectionName])) {
            $this->sections[$this->sectionName] = '';
        }

        $this->sections[$this->sectionName] = $this->appendSection ? $this->sections[$this->sectionName] . ob_get_clean() : ob_get_clean();
        $this->sectionName = null;
        $this->appendSection = false;
    }

    /**
     * Alias of stop().
     * @return null
     */
    public function end()
    {
        $this->stop();
    }

    /**
     * Returns the content for a section block.
     * @param  string      $name    Section name
     * @param  string      $default Default section content
     * @return string|null
     */
    public function section($name, $default = null)
    {
        if (!isset($this->sections[$name])) {
            return $default;
        }

        return $this->sections[$name];
    }

    /**
     * Fetch a rendered template.
     * @param  string $name
     * @param  array  $data
     * @return string
     */
    public function fetch($name, array $data = array())
    {
        return $this->engine->render($name, $data);
    }

    /**
     * Output a rendered template.
     * @param  string $name
     * @param  array  $data
     * @return null
     */
    public function insert($name, array $data = array())
    {
        echo $this->engine->render($name, $data);
    }

    /**
     * Apply multiple functions to variable.
     * @param  mixed  $var
     * @param  string $functions
     * @return mixed
     */
    public function batch($var, $functions)
    {
        foreach (explode('|', $functions) as $function) {
            if ($this->engine->doesFunctionExist($function)) {
                $var = call_user_func(array($this, $function), $var);
            } elseif (is_callable($function)) {
                $var = call_user_func($function, $var);
            } else {
                throw new LogicException(
                    'The batch function could not find the "' . $function . '" function.'
                );
            }
        }

        return $var;
    }

    /**
     * Escape string.
     * @param  string      $string
     * @param  null|string $functions
     * @return string
     */
    public function escape($string, $functions = null)
    {
        static $flags;

        if (!isset($flags)) {
            $flags = ENT_QUOTES | (defined('ENT_SUBSTITUTE') ? ENT_SUBSTITUTE : 0);
        }

        if ($functions) {
            $string = $this->batch($string, $functions);
        }

        return htmlspecialchars($string, $flags, 'UTF-8');
    }

    /**
     * Alias to escape function.
     * @param  string      $string
     * @param  null|string $functions
     * @return string
     */
    public function e($string, $functions = null)
    {
        return $this->escape($string, $functions);
    }

    /**
     * to make absoulute paths (example: http://www.domain-name.com/assets/css/custom.css?v=1234567890);
     * @param  string      $string
     * @param  null|string $functions
     * @return string
     */
    public function urlTo($file) {
        $file = ltrim($file, '/');
        return $this->validateUrl($file);
    }

    public function htmlStyle($file,$attributes=[]) {
        $file = ltrim($file, '/');
        $href = $this->validateUrl($file,"style");

        $defaults = ['media' => 'all', 'type' => 'text/css', 'rel' => 'stylesheet'];

        $attributes = $attributes + $defaults;
        $attributes["href"] = $this->validateUrl($href);


        $style_tag = '<link '.$this->attributes($attributes).'>'.PHP_EOL;
        
        return $style_tag;
    }

    public function htmlScript($file,$attributes=[]) {
        $file = ltrim($file, '/');
        $href = $this->validateUrl($file,"script");
        $attributes['src'] = $href;

        $style_tag = '<script' . $this->attributes($attributes) . '></script>'.PHP_EOL;
        
        return $style_tag;
    }


    /**
     * Build path
     *
     * @param array $attributes
     *
     * @return string
     */
    public function validateUrl($url,$type=null) {
        $explode_url = explode("://", $url);

        if( !array_key_exists(1,$explode_url) ) {
            if( $type=="style" || $type=="script" )
                $last_updated = "?v=".filemtime($url);
            else
                $last_updated = "";

            $url = $this->path.$url.$last_updated;
        }

        return $url;
    }

    /**
     * Build an HTML attribute string from an array.
     *
     * @param array $attributes
     *
     * @return string
     */
    public function attributes($attributes) {
        $html = [];

        foreach ((array) $attributes as $key => $value) {
            $element = $this->attributeElement($key, $value);

            if (! is_null($element)) {
                $html[] = $element;
            }
        }

        return count($html) > 0 ? ' ' . implode(' ', $html) : '';
    }

    /**
     * Build a single attribute element.
     *
     * @param string $key
     * @param string $value
     *
     * @return string
     */
    protected function attributeElement($key, $value) {
        // For numeric keys we will assume that the value is a boolean attribute
        // where the presence of the attribute represents a true value and the
        // absence represents a false value.
        // This will convert HTML attributes such as "required" to a correct
        // form instead of using incorrect numerics.
        if (is_numeric($key)) {
            return $value;
        }

        // Treat boolean attributes as HTML properties
        if (is_bool($value) && $key != 'value') {
            return $value ? $key : '';
        }

        if (! is_null($value)) {
            return $key . '="' . $value . '"';
        }
    }
}
