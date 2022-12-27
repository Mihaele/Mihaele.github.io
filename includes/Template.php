<?php

/**
 *  Handles various parts of templating:
 *    - Ensures only one template is open at once.
 *    - Buffers and stores output if requested by the template.
 *    - Manages the page depth so relative URLs can be generated.
 *    - Manages the page type, which is used for page differentiation in CSS.
 */
class Template {
    
    private static $g_instance = null;
    
    public static function Get() {
        if (self::$g_instance === null) {
            throw new \Exception('No template is currently open.');
        }
        
        return self::$g_instance;
    }
    
    private $m_type;
    private $m_relativePrefix;
    private $m_buffer;
    private $m_contents;
    
    public function __construct($type, $depth = 0, $buffer = false) {
        $this->m_type = $type;
        $this->m_relativePrefix = '';
        for ($i = 0; $i < $depth; $i += 1) {
            $this->m_relativePrefix .= '../';
        }
        $this->m_buffer = $buffer;
        $this->m_contents = null;
    }
    
    public function contents() {
        return $this->m_contents;
    }
    
    public function type() {
        return $this->m_type;
    }
    
    public function url($url) {
        return $this->m_relativePrefix . $url;
    }
    
    public function open() {
        if (self::$g_instance !== null) {
            throw new \Exception('Another template is currently open.');
        }
        self::$g_instance = $this;
        
        if ($this->m_buffer) {
            ob_start();
        }
        
        include('Template_Header.php');
    }

    public function close() {
        if (self::$g_instance !== $this) {
            throw new \Exception('Another template is currently open.');
        }
        
        include('Template_Footer.php');
        
        if ($this->m_buffer) {
            $this->m_contents = ob_get_contents();
            ob_end_clean();
        }
        
        self::$g_instance = null;
    }

}
