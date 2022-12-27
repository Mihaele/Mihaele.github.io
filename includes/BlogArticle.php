<?php

class BlogArticle {
    
    static function LoadFromJsonFile($it) {
        if (!($it instanceof \SplFileInfo)) {
            $it = new SplFileInfo($it);
        }
        
        if ($it->getExtension() != 'json') return null;
        if (!($it->isFile())) return null;
        
        $parentPath = $it->getPathInfo()->getPathname();
        if ($parentPath != '/') $parentPath .= '/';
        
        $baseName = $it->getBaseName(".json");
        
        $metadataPath =  $it->getPathname();
        if (!(file_exists($metadataPath))) return null;
        
        $contentsPath = $parentPath . $baseName . ".html";
        $contents = file_get_contents($contentsPath);
        if (!(is_string($contents))) {
            throw new \Exception('Expected contents to be a string.');
        }
        
        $metadata = json_decode(file_get_contents($metadataPath));
        if (!(is_object($metadata))) {
            throw new \Exception('Expected metadata to be an array.');
        }
        if (!(isset($metadata->link))) {
            $metadata->link = "articles/{$baseName}.html";
        }
        
        return new BlogArticle($metadata, $contents);
    }
    
    static function LoadAll() {
        $articles = [];
        
        $it = new DirectoryIterator('articles');
        foreach ($it as $file) {
            $article = self::LoadFromJsonFile($it);
            if ($article !== null) {
                $articles[] = $article;
            }
        }
        
        usort($articles, function ($a, $b) {
            return $a->compare($b);
        });
        
        return $articles;
    }
    
    public $title;
    public $subtitle;
    public $contents;
    public $tags;
    public $link;
    
    private $m_date;
    private $m_order;
    
    private function __construct($metadata, $contents) {
        if ((!(empty($metadata->title))) && (is_string($metadata->title))) {
            $this->title = $metadata->title;
        } else {
            throw new \Exception('Article title is required.');
        }
        
        if ((!(empty($metadata->subtitle))) && (is_string($metadata->subtitle))) {
            $this->subtitle = $metadata->subtitle;
        } else {
            $this->subtitle = null;
        }
        
        if ((!(empty($metadata->tags))) && (is_array($metadata->tags))) {
            $this->tags = $metadata->tags;
        } else {
            $this->tags = [];
        }
        
        if ((!(empty($metadata->link))) && (is_string($metadata->link))) {
            $this->link = $metadata->link;
        } else {
            throw new \Exception('Article link is required.');
        }
            
        if ((!(empty($metadata->date))) && (is_string($metadata->date))) {
            $this->m_date = $metadata->date;
        } else {
            throw new \Exception('Article date is required.');
        }
            
        if ((!(empty($metadata->order))) && (is_int($metadata->order))) {
            $this->m_order = $metadata->order;
        } else {
            $this->m_order = null;
        }
        
        if (is_string($contents)) {
            $this->contents = $contents;
        } else {
            throw new \Exception('Article contents is required.');
        }
    }
    
    public function hasDate() {
        return ($this->m_date !== null);
    }
    
    public function date($format = 'Y-m-d') {
        if ($this->m_date === null) {
            return null;
        }
        
        $date = DateTimeImmutable::createFromFormat('Y-m-d', $this->m_date);
        if ($format === null) {
            return $date;
        } else {
            return $date->format($format);
        }
    }
    
    public function order() {
        if ($this->m_order !== null) {
            return $this->m_order;
        } else {
            return 1;
        }
    }
    
    public function compare(BlogArticle $that) {
        $thisDate = $this->date(null);
        $thatDate = $that->date(null);
        if ($thisDate < $thatDate) {
            return 1;
        } elseif ($thisDate > $thatDate) {
            return -1;
        }
        
        $thisOrder = $this->order();
        $thatOrder = $that->order();
        if ($thisOrder < $thatOrder) {
            return 1;
        } elseif ($thisOrder > $thatOrder) {
            return -1;
        }
        
        return strcmp($this->title, $that->title);
    }
    
    public function printBody() {
        echo '<h1>' . htmlentities($this->title) . '</h1>';
        echo $this->contents;
    }
    
}
