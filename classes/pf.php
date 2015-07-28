<?php

/**
 * ����� ��� ������ � ����������� �� ������� � ������� "������ �����������"  
 */
class pf
{
    /**
     * �������� ������� ���� ����� ������ ��� ������
     * 
     * @var string 
     */
    private $tbl_name = "pf_docs";
    
    /**
     * �������� ���� primary key � �������
     * 
     * @var string 
     */
    private $pr_key = "id";
    
    /**
     * ������������ ������ ��� ������
     * 
     * @var array
     */
    private $post_data = array();
    /**
     * ��������� ����� ������ �� ������� 
     * 
     * @global object $DB  ����������� � �� @see DB.php
     * @param array $post  ������������ ������    
     */
    public function insert() {
        global $DB;
        if(empty($this->post_data) || $this->isError()) return false;
        return $DB->insert($this->tbl_name, $this->post_data);
    } 
    
    /**
     * ���������� �������
     * 
     * @global object $DB          ����������� � ��
     * @param integer $id          �� �������
     * @param array   $post_data   ����� ��� ����������
     * @return boolean
     */
    public function update($id, $post_data) {
        global $DB;
        
        return $DB->update($this->tbl_name, $post_data, $this->pr_key. " = ?", $id);
    }
    
    /**
     * ������� �������� 
     * 
     * @global object $DB
     * @param array $filter  ������ �������
     * @return array 
     */
    public function select($filter=false) {
        global $DB;
        
        $where = self::getFilterSQL($filter);
        
        $sql = "SELECT pf_docs.*, 
                    fsf.fname as sf_name, fsf.path as sf_path, fsf.size as sf_size, fsf.original_name as sf_orig_name,
                    fact.fname as act_name, fact.path as act_path, fact.size as act_size, fact.original_name as act_orig_name
                FROM 
                    pf_docs 
                    LEFT JOIN file_pf fsf ON fsf.id = pf_docs.file_sf
                    LEFT JOIN file_pf fact ON fact.id = pf_docs.file_act
                {$where}
                ORDER BY invoiced_time";
                
        $result = $DB->rows($sql);
        
        return $result;
    }
    
    /**
     * ������
     * 
     * @param type $filter ������
     * @return string 
     */
    public function getFilterSQL($filter) {
        $where = "";
        
        if($filter['created']) {
            $filter_sql[] = $GLOBALS['DB']->parse( ' (pf_docs.created_time >= DATE ? AND pf_docs.created_time <= DATE ?) ', $filter['from'], $filter['to'] );
            $time_filter  = true;
        }
        
        if($filter['invoiced']) {
            $filter_sql[] = $GLOBALS['DB']->parse( ' (pf_docs.invoiced_time >= DATE ? AND pf_docs.invoiced_time <= DATE ?) ', $filter['from'], $filter['to'] );
            $time_filter  = true;
        }
        
        if($filter['accepted']) {
            $filter_sql[] = $GLOBALS['DB']->parse( ' (pf_docs.accepted_time >= DATE ? AND pf_docs.accepted_time <= DATE ?) ', $filter['from'], $filter['to'] );
            $time_filter  = true;
        }
        
        if($filter['is_accepted'] == 1) {
            $_sql[] = "accepted = true";
        }
        
        if($filter['search'] != '') {
            $filter['search'] = pg_escape_string( strtolower($filter['search']) );
            $_sql[] = " ( lower(company) LIKE lower('%{$filter['search']}%') OR lower(bill_num) LIKE lower('%{$filter['search']}%') ) ";
        }
        
        if($filter) {
            if(!$time_filter) {
                $filter_sql[] = $GLOBALS['DB']->parse( ' (pf_docs.invoiced_time >= DATE ? AND pf_docs.invoiced_time <= DATE ?) ', $filter['from'], $filter['to'] );
                $filter_sql[] = $GLOBALS['DB']->parse( ' (pf_docs.accepted_time >= DATE ? AND pf_docs.accepted_time <= DATE ?) ', $filter['from'], $filter['to'] );
                $time_sql     = implode( ' OR ', $filter_sql );
            }
            else {
                $time_sql     = implode( ' AND ', $filter_sql );
            }
            
            $where = " WHERE ( $time_sql ) ";
            if($_sql) $where .= " AND ".implode(" AND ", $_sql);
        }
        
        return $where;
    }
    
    /**
     * �������� ���� �� ������ ��� ������ �������
     * 
     * @return boolean
     */
    public function isError() {
        return (count($this->error) > 0);
    }
    
    /**
     * ������� ��� ������ ��������� ��� ������ �������
     * 
     * @return array
     */
    public function getErrors() {
        return $this->error;
    }
    
    /**
     * ��������� ������ ��� ������� �������
     * 
     * @param array $post ������ ��� ���������
     */
    public function setPostData($post) {
        if( is_empty_html($post['company']) ) {
            $this->error['company'] = '������� �������� ��������';
        }
        
        if((int) $post['sum'] <= 0) {
            $this->error['sum'] = '����� ������ ���� ������ ����';
        } 
        
        if(is_empty_html($post['bill_num'])) {
            $this->error['bill_num'] = '������� ����� �����';
        }
        
        if(is_empty_html($post['invoiced_time'])) {
            $this->error['invoiced_time'] = '��������� ���� ������� �����';
        }
        
        $post['sum'] = (float) round($post['sum'], 2);
        
        $post['invoiced_hour'] = $this->checkHour($post['invoiced_hour'], 'invoiced_hour', '������� �����');
        $post['accepted_hour']  = $this->checkHour($post['accepted_hour'], 'accepted_hour', '������� �����');
        
        if($post['invoiced_time'] != '') {
            if($post['invoiced_hour'] != '') $post['invoiced_time'] .= " {$post['invoiced_hour']}";
            $post['invoiced_time'] = date('Y-m-d H:i:s', strtotime($post['invoiced_time']));
        } else {
            $post['invoiced_time'] = null;
        }
        
        if($post['accepted_time'] != '') {
            if($post['accepted_hour'] != '') $post['accepted_time'] .= " {$post['accepted_hour']}";
            $post['accepted_time'] = date('Y-m-d H:i:s', strtotime($post['accepted_time']));
            $post['accepted'] = true;
        } else {
            $post['accepted_time'] = null;
            $post['accepted'] = false;
        }
        
        if((int) $post['docsend'] == 1) {
            $post['docsend'] = true;
            $post['docsend_time'] = "NOW()";
        } else {
            $post['docsend'] = false;
            $post['docsend_time'] = null;
        }
        
        if((int) $post['docback'] == 1) {
            $post['docback'] = true;
            $post['docback_time'] = "NOW()";
        } else {
            $post['docback'] = false;
            $post['docback_time'] = null;
        }
        unset($post['invoiced_hour'], $post['accepted_hour']);
        $this->post_data = $post;
    }
    
    /**
     * �������� ������������ �������� ������ � ���� ������� 
     * 
     * @param string $time    ��������� �����
     * @param string $name    �������� ����
     * @param string $title   �������� ����
     * @return string 
     */
    public function checkHour($time, $name, $title = '') {
        if($time != '') {
            $ex = explode(":", $time);
            
            if(count($ex) !== 2) {
                $time = "";
                $this->error[$name] = "����� {$title} ������� �� ���������";
            } else {
                $h = (int) $ex[0];
                $m = (int) $ex[1];
                if($h > 24 || $h < 0) {
                    $this->error[$name] = "����� {$title} ������� �� ���������";
                }
                
                if($m > 60 || $m < 0) {
                    $this->error[$name] = "����� {$title} ������� �� ���������";
                }
                
                if(!$this->error[$name]) {
                    $time = "{$h}:{$m}:00";
                } else {
                    $time = "";
                }
            }
        }
        
        return $time;
    }
    
    /**
     * ����� ������ �� ����������� �������
     * 
     * @global object $DB   ����������� � ��
     * @param integer $id      �� �������
     * @return array ������ �� ������� 
     */
    public function getOrderer($id) {
        global $DB;
        
        $sql = "SELECT pf_docs.* FROM  pf_docs WHERE id = ?i";
        $result = $DB->row($sql, $id);
        
        return $result;
    }
    
    /**
     * ���������� �������� �� ����� (�������� ��������� ����������� ���� accepted = true)
     * ��������� �� ���� ������� �����
     * 
     * @global object $DB   ����������� � ��
     * @param string $from_date   � ����
     * @param string $to_date     �� ����
     * @return array 
     */
    public function getStatOp($from_date = '2000-01-01', $to_date = 'now()') {
        global $DB;
        
        $sql = "SELECT SUM(sum) as sum, COUNT(*) as cnt FROM pf_docs
                WHERE 
                invoiced_time >= DATE '$from_date' AND invoiced_time < DATE '$to_date' + interval '1day' 
                AND accepted = true";
        $result = $DB->row($sql);
        return $result;
    }
    
    /**
     * ���������� �� ���� ��� ������� (�����, ���, ��� ����)
     * 
     * @global object $DB   ����������� � ��
     * @param string  $from_date    � ����
     * @param string  $to_date      �� ����
     * @param boolean $bYear        �� ������������ ���
     * @param boolean $bYearAll     �� ��� ����
     * @return array 
     */
    public function getOp($from_date, $to_date, $bYear = false, $bYearAll = false) {
        global $DB;
         
        if ($bYear) {
            $to_char = 'MM';
            if ($bYearAll) $to_char = 'YYYY';
            $group = "to_char(invoiced_time,'{$to_char}') as _day";
            $group_by = "GROUP BY to_char(invoiced_time, '{$to_char}') ORDER BY to_char(invoiced_time, '{$to_char}')";
        } else {
            $group = "extract(day from invoiced_time) as _day";
            $group_by = "GROUP BY _day ORDER BY  _day";
        }
        
        $sql = "SELECT SUM(sum) as sum, COUNT(*) as ammount, {$group}
                FROM pf_docs
                WHERE 
                invoiced_time >= DATE '$from_date' AND invoiced_time < DATE '$to_date' + interval '1day' 
                AND accepted = true
                {$group_by}";
        
        $result = $DB->rows($sql);
        return $result;
    }
    
    /**
     * �������� ���� � ������� d-m-Y �� ���������� 
     * 
     * @param  string $sDate ���� 
     * @param  string $sErrMsg ��������� �� ������ 
     * @return string ��������� �� ������ ��� ������ ������ 
     */
    public function validateDate( $sDate = '', $sErrMsg = '' ) {
        if ( $sDate ) {
            $aDate = explode('-', $sDate);
            
            if ( count($aDate) == 3 ) {
                $nDay  = intval( $aDate[0] );
                $nMon  = intval( $aDate[1] );
                $nYear = intval( $aDate[2] );
                
                if ( !$nDay || $nDay != $aDate[0] 
                    || !$nMon || $nMon != $aDate[1] || $nMon < 0 || $nMon > 12 
                    || !$nYear || $nYear != $aDate[2] || $nYear < 0 
                ) {
                    return $sErrMsg;
                }
                
                $aDaysNum = array( 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 );
                
                if ( $nMon == 2 ) {
                    if ( $nYear % 400 == 0 || ( $nYear % 100!=0 && $nYear % 4 == 0 ) ) {
                       $aDaysNum[1] = 29;
                    }
                }
                
                if ( $nDay > $aDaysNum[$nMon-1] ) {
                    return $sErrMsg;
                }
            }
            else {
                return $sErrMsg;
            }
        }
        else {
            return $sErrMsg;
        }
        
        return '';
    }
}

?>