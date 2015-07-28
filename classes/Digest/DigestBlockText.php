<?php

require_once 'DigestBlock.php';

/**
 * ����� ��� ������ � ������ "������ ����"
 */
class DigestBlockText extends DigestBlock {
    
    /**
     * @see parent::$title
     */
    public $title   = '������� ����';
    
    /**
     * @see parent::$created
     */
    const IS_CREATED = true;
    
    /**
     * ������������ ������� ��� ���
     */
    const IS_WYSIWYG = true;
    
    /**
     * ��������
     * @var string 
     */
    public $name;
    
    /**
     * ������
     * 
     * @var string 
     */
    public $link;
    
    /**
     * ��������
     * 
     * @var string
     */
    public $text;
    
    /**
     * ����������� ������
     * 
     * @param string $name    @see self::$name
     * @param string $link    @see self::$link
     * @param string $text    @see self::$text
     */
    public function __construct($name = null, $link = null, $text = null) {
        if($name !== null && $link !== null && $text !== null) {
            $this->initBlock($name, $link, $text);
        }
    }
    
    /**
     * ������������� �����
     * 
     * @param string $name    @see self::$name
     * @param string $link    @see self::$name
     * @param string $text    @see self::$name
     */
    public function initBlock($name = null, $link = null, $text = null) {
        $this->name = stripcslashes(__paramValue('string', $name));
        $this->link = stripslashes(__paramValue('string', $link));
        $this->text = stripcslashes(__paramValue($this->isWysiwyg() ? 'ckeditor' : 'html', $text));
        
        if(!$this->validateLink()) {
            $this->_error['link'] = true;
        }
    }
    
    /**
     * ��������� ��������� ������ �� ����������
     * 
     * @return boolean
     */
    public function validateLink() {
        if($this->link == '') return true;
        return url_validate($this->link, true);
    }
    
    /**
     * ����������� �����
     */
    public function displayBlock() {
        include ($_SERVER['DOCUMENT_ROOT'] . self::TEMPLATE_PATH . "/tpl.digest_text.php");
    }
    
    /**
     * ���� ������ ����� ���� ���������, ����� input ������ ���� ���������
     * ������ ����������� ����� input
     * 
     * @return string
     */
    public function isMore() {
        return $this->isCreated() ? "[]" : "";
    }
    
    /**
     * ������������� �����
     * 
     * @param array $data
     */
    public function initialize($data) {
        $class = $this->__toString();
        
        $this->setMain( $data[$class.'Main'][$this->getNum()] == 1 );
        $this->setPosition( $data['position'][$class][$this->getNum()] );
        $this->setCheck( isset($data[$class.'Check']) ? ($data[$class.'Check'][$this->getNum()] == 1) : false );
        $this->initBlock( $data[$class.'Name'][$this->getNum()], $data[$class.'Link'][$this->getNum()], $data[$class.'Descr'][$this->getNum()]);
    }
    
    /**
     * ������ HTML ����
     * 
     * @return string
     */
    public function htmlBlock() {
        $this->host = $GLOBALS['host'];
        $this->html_data = $this->name . $this->text;
        if(!$this->html_data) return ''; 
        include ($_SERVER['DOCUMENT_ROOT'] . self::TEMPLATE_PATH . "/tpl." . __CLASS__ . ".php");
    }
    
    /**
     * �������� �� ��������������� ������� ��������� ��� �������� �����
     * 
     * @return boolean
     */
    public function isWysiwyg() {
        return constant(get_class($this) . '::IS_WYSIWYG');
        //return $this::IS_WYSIWYG;//������� � ������ 5.3.0
    }
}