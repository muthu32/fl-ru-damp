<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/users.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/project_exrates.php");
/**
 *
 * ����� ��� ������ � ������������.
 *
 */
class freelancer extends users {

    const CATALOG_MEM_TAG               = 'freelancer_getCatalog';
    const CATALOG_GROUP_MEM_TAG         = 'freelancer_getCatalog_GroupId_%s';
    const CATALOG_PROFF_MEM_TAG         = 'freelancer_getCatalog_ProfId%s';
    const CATALOG_MEM_LIFE              = 1800;
    const CATALOG_PORTFOLIO_MEM_LIFE    = 600;

    const CATALOG_PROFI_MEM_TAG         = 'freelancer_getProfiCatalog';
    const CATALOG_PROFI_MEM_LIFE        = 3600;//1 ���
    

    const USD = 0;
    const EUR = 1;
    const RUR = 2;
    const FM  = 3;

	/**
	 * ��������� �������� �� �������� ���������� (������� �����).
	 *
	 * @var string
	 */
	public $tabs;

	/**
	 * ���� �������� (���� � ������� postgres).
	 * 
	 * @var string
	 */
	public $birthday;

	/**
	 * ����.
	 * ���� �� ������� ���������, �� ����� ���������.
	 *
	 * @var string
	 */
	public $site;

	/**
	 * �������.
	 * ���� �� ������� ���������, �� ����� ���������.
	 *
	 * @var string
	 */
	public $phone;

	/**
	 * ��� � LiveJournal.
	 * ���� �� ������� ���������, �� ����� ���������.
	 *
	 * @var string
	 */
	public $ljuser;

	/**
	 * ������� �����, ���������� ����� ����� ���������� ���������� � ���������� �� ��� ��������.
	 *
	 * @var string
	 */
	public $blocks;

	/**
	 * �������� ������������� ���������� (� ������ mirrored).
	 *
	 * @var integer
	 */
	public $spec;
	
	/**
	 * ���� ���������� � ����� (������������ �����).
	 *
	 * @var string
	 */
	public $exp;
	
	/**
	 * ��� ����� � ������.
	 *
	 * @var string
	 */
	public $resume_file;

	/**
	 * ����� ������.
	 *
	 * @var string
	 */
	public $resume;
	
	/**
	 * ������� � ��������� � �������.
	 *
	 * @var string
	 */
	public $konk;

	/**
	 * ������� �������
	 *
	 * @var string
	 */
	public $clients;
	
	/**
	 * ��������� � �������.
	 *
	 * @var string
	 */
	public $spec_text;
	
	/**
	 * �� ������ ����� �������� �������� ���������.
	 * ������ �������� � ���� ����� pow(2, id_�������) ��������� ��������.
	 *
	 * @var integer
	 */
	public $mailer;

        /**
	 * �� ������ ����� �������� �������� ���������.
	 * ������ �������� � ���� ������ ���� "c23s87:c56:s89".
	 *
	 * @var string
	 */
	public $mailer_str;
	
	/**
	 * ��������� ��������� ����������� � ������� � ���������?
	 * ���������.
	 *
	 * @deprecated
	 * @var string
	 */
	public $portf_comments;
	
	/**
	 * ������ ���������.
	 * ���������.
	 *
	 * @deprecated
	 * @var integer
	 */
	public $design;
	
	/**
	 * ����������� � ������� ����������.
	 *
	 * @var string
	 */
	public $status_text;
	
	/**
	 * ������ ����������.
	 *
	 * $var integer
	 */
	public $status_type;

	/**
	 * ���� �� � ���������� ������ � ���������, ����������� � ��� ��������������.
	 *
	 * @var string
	 */
	public $has_porft_works;

	/**
	 * ��� ������������ �������.
	 *
	 * ����� ��������� ��� ��������:
	 * 0 - "���������"
	 * 1 - "������"
	 *
	 * @var smallint
	 */
	public $tab_name_id;

	/**
	 * ��������� ������ ���������� � ���.
	 *
	 * @var float
	 */
	public $cost_hour;

	/**
	 * ��������� ������ ���������� � �����.
	 *
	 * @var float
	 */
	public $cost_month;

	/**
	 * ��������� ������ ���������� � ��� (������).
	 *
	 * @var integer
	 */
	public $cost_type_hour;

	/**
	 * ��������� ������ ���������� � ����� (������).
	 *
	 * @var integer
	 */
	public $cost_type_month;
	
	/**
	 * �������� ������������� ���������� (� ������ mirrored)
	 *
	 * @var integer
	 */
	public $spec_orig;
	
	/**
	 * ��� ������ � �����
	 *
	 * @var boolean
	 */
	public $in_office;

	/**
	 * ����������� �������� ����� ���
	 *
	 * @var boolean
	 */
	public $prefer_sbr;
	
	/**
     * ������ - ���� ���������� ���������
     *
     * @var integer
     */
    public $resume_edit_date;

    /**
     * ���� ������ � ��������
     * @var string
     */
    public $cat_show;


    /**
    * ������� (View) �� ������� ����������� ����������
    * fu - ��� �������� ����������, fu_pro - ���������� ������ � ���
    */
    static private $fu_table = 'fu';

    public static function SetFuTable($table)
    {
    	self::$fu_table = $table;
    }
	
	/**
	 * ��������� ��������� ��������� �������� �� �������� ����������.
	 * @param    integer   $fid       uid ����������
	 * @param    boolean   $portf     ����������/������ ������� ���������
	 * @param    boolean   $serv      ����������/������ ������� ������ (�� ������������)
	 * @param    boolean   $info      ����������/������ ������� ����������
	 * @param    boolean   $jornal    ����������/������ ������� ����
	 * @param    boolean   $rating    ����������/������ ������� �������
	 * @param    boolean   $difile    ����������/������ ������� ������
	 * @param    boolean   $shop      ����������/������ ������� �������
         * @param    boolean   $tu        ����������/������ ������� ������� �����
	 * @return   string               ��������� ������
	 */
	function UpdateTabs($fid, $portf, $serv, $info, $jornal, $rating=1,$difile=0,$shop=0,$tu=1){
        $this->tabs = (int)$portf.(int)$serv.(int)$info.(int)$jornal.(int)$rating.(int)$difile.(int)$shop.(int)$tu;
		while (strlen($this->tabs) < $GLOBALS['tabsize'])
            $this->tabs .= '0';
    $this->tabs = substr($this->tabs, 0, $GLOBALS['tabsize']);
		$error = $this->Update($fid, $res);
		return ($error);
	}

    /**
     * ������ ����������� �������� �� ��������� ����� ��� �������� � XML webprof
     *
     * @param   array   $spec   ������ � ID �������������
     * @return  array           ������ �����������
     */
    function getListForWebprof($spec) {
        global $DB;

        $sql = "SELECT 
                    uid, 
                    uname, 
                    usurname, 
                    login, 
                    rating, 
                    status_type,
                    spec, 
                    cost_hour, 
                    cost_month, 
                    cost_type_hour, 
                    cost_type_month 
                FROM freelancer as f
                LEFT JOIN users_change c ON c.user_id = f.uid AND (ucolumn = 'uname' OR ucolumn = 'usurname')
                WHERE c.id IS NULL AND is_banned = '0' AND f.last_time > (NOW() - INTERVAL '1 month') AND spec IN (?l)
                ORDER BY f.rating DESC";
        $freelancers = $DB->rows($sql, $spec);

        return $freelancers;
    }
	
	/**
	 * ��������� ���� � ������
	 * @param    integer   $fid           uid ����������
	 * @param    CFile     $resume        ������ CFile � ������� � ����� � ������. ���� ������ ��� ����������, �� ��� ����� ������������
	 * @param    boolean   $del_resume    ������� ������? � ������ �������� ����� ������ �������� �� �����, � ������������� �� ���������� $resume
	 * @param    integer   $file_error    1 - ���� ��������� ������ ��� �������� �����
	 * @return   string                   ��������� ������
	 */
	function UpdateInform($fid, $resume, $del_resume, &$file_error){
        // ���� ���� ������ ���� ������ ���� ���������� ��� �� ������������� - ����� ������� ���������
        $aChange  = $GLOBALS['DB']->row( "SELECT id, old_val, new_val FROM users_change WHERE user_id = ?i AND ucolumn = 'resume_file'", $fid );
        $aDelFile = array(); // ����� ������� ����� ����� ������� �����
        
        while (strlen($this->blocks) < $GLOBALS['blockssize'])
			$this->blocks .= '1';
        
        $dir = get_login($fid);
        $err = '';
		$old = $this->GetField($fid, $err, "resume_file");
        
        $error .= $err;
        
		if ($del_resume){
			$this->resume_file = '';
			
		} elseif($resume->name) {
		    $resume->max_size = 5242880;
            $this->resume_file = $resume->MoveUploadedFile($dir."/resume");
            $error .= $resume->StrError('<br />');
            if ($error) $file_error = 1;
        }
        
		if ( !$error ) {
            $error .= $this->Update($fid, $res);
            
            // ������������ ����� ����� ����� �������
            if ( $del_resume == 1 ) { // ������� ���� ������
                if ( $aChange ) { // ���� ������� ������ ����� ������ �� ������ �������� - �� ������� ���
                    if ( $aChange['old_val'] ) {
                        $aDelFile[] = $aChange['old_val'];
                    }
                    
                    $aDelFile[] = $aChange['new_val'];
                }
                else { // ����� ������ ������� ���� ������
                    $aDelFile[] = $old;
                }
            }
            elseif ( $resume->name ) { // ������ ���� ������
                if ( $aChange && $aChange['new_val'] ) { // ������� ������ ������������� ������, ���� ����
                    $aDelFile[] = $aChange['new_val'];
                }
            }
        }
        
        // �������� �� ������ ������ (���� ��� ������ ��� ���������� ����������)
        if ( $aDelFile && !$error ) {
            foreach ( $aDelFile as $file ) {
                $resume->Delete(0, "users/".substr($dir, 0, 2)."/".$dir."/resume/", $file);
            }
        }
        
		return ($error);
	}

	
	/**
	 * �������������� ������ �� ������� ���������� � �� ���������.
	 * @param    integer   $fid                  uid ������������
	 * @param    string    $exp                  ���� � ����� (������������ �����)
	 * @param    string    $text                 ��������� � ������� � ���������
	 * @param    integer   $tab_name_id          �������� ������� ���������: 0 - ���������, 1 - ������
	 * @param    float     $cost_hour            ��������� ���� ������
	 * @param    float     $cost_month           ��������� ������ ������
	 * @param    integer   $cost_type_hour       ��� ������ (0 - USD, 1 - Euro, 2 - ���, 3 - FM)
	 * @param    integer   $cost_type_month      ��� ������ (0 - USD, 1 - Euro, 2 - ���, 3 - FM)
	 * @param    boolean   $in_office            ��� ������ � �����
	 * @param    boolean   $cat_show             ���������� � �������� ��� ���
	 * @param    boolean   $prefer_sbr           ����������� �������� ����� ���
	 * @return   string                          ��������� ������
	 */
	function UpdateServ($fid, $exp, $text, $tab_name_id, $cost_hour, $cost_month, $cost_type_hour, $cost_type_month, $in_office = false, $cat_show = true, $prefer_sbr = false)
	{
		$this->exp = $exp;
		$this->tab_name_id = $tab_name_id;
		$this->cost_hour = $cost_hour;
		$this->cost_month = $cost_month;
		$this->cost_type_hour = $cost_type_hour;
		$this->cost_type_month = $cost_type_month;
		$this->spec_text = $text;
		$this->in_office = $in_office;
		$this->prefer_sbr = $prefer_sbr;
                if(is_pro()) $this->cat_show =$cat_show ? 't' : 'f';
		$error = $this->Update($fid, $res);
		return ($error);
	}


    /**
     * ��������� SQL-������� �� ��������� �������.
     *
     * @param array $filter    ������, ��. �������.
     * @param $prof_id   ��. ������������� (���� ��������� � ���������� ������� ��������).
     * @return array   [where-�������, join-�������].
     */
    function createCatalogFilterSql($filter, $prof_id = 0) {
        if(!$filter) return NULL;

        require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/projects.php");
        require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/teams.php");
        require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/professions.php");
        require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/project_exrates.php");
        global $project_exRates, $DB;

        $filter_join = array();
        $filter_where = array();
        

        if($filter['prof'] && !$prof_id) {
            if(count($filter['prof'][0])  > 0) $p1 = professions::getProfIdForGroups(array_keys($filter['prof'][0]), true);
            if(count($filter['prof'][1])  > 0) $p2 = professions::GetProfessionOrigin(implode(",", array_keys($filter['prof'][1])));
            $in_sql = ($p2?$p2:"").(($p1 && $p2)?", ":"").($p1?$p1:"");
            if($in_sql) {
                $filter_where[] = "s.spec_orig IN ({$in_sql})";
                $has_prof_filter = true;
            }
        }
        
        if($filter['orig_kwords']) {
            if(!$has_prof_filter && !$prof_id) {
                if ($kprofs = professions::getProfsByKeywords($filter['orig_kwords'])) {
                    $kprofs = professions::GetProfessionOrigin($kprofs);
                    $kf[] = "s.spec_orig IN ({$kprofs})";
                }
                $m = array();
		        $e = explode(',', $filter['orig_kwords']);
        		foreach($e as $k=>$v) {
            		if($v = trim($v))
                		$m[] = strtolower($v);
        		}
        		if($m) {
        			$kf[] = $DB->parse('s.uid IN (SELECT portf_word.uid FROM words JOIN portf_word ON portf_word.wid=words.id JOIN users ON users.uid=portf_word.uid where lower(name) IN (?l))', $m);
        		}
            }

            if(!empty($filter['kword']) && is_array($filter['kword'])) {
                foreach($filter['kword'] as $k=>$v) {
                    $g[$v['group_id']] = $v['group_id'];
                    $w[$v['id']] = $v['id']; 
                }
                $kf[] = 's.uid IN (SELECT DISTINCT pw.uid FROM words w JOIN portf_word pw ON pw.wid = w.id WHERE w.group_id IN (' . implode(',', $g) . '))';
            }
            if($kf) {
                $filter_where[] = '('.implode(' OR ', $kf).') ';
            } else {
                return -1;
            }
        }
        
        if($filter['in_fav']) {
            $teams = new teams;
            if($tt = $teams->teamsFavorites($uid, $error)) {
                foreach ($tt as $t) {
                    $favs[] = $t['uid'];
                }
                if ($favs) {
                    $filter_where[] = $DB->parse('s.uid IN (?l)', $favs);
                }
            }
        }
        
        $jstr_rating = 'INNER JOIN rating r ON r.user_id = s.uid';

        if($filter['success_sbr'][0]==1) {
            $filter_join['rating'] = $jstr_rating;
            for($i=1;$i<4;$i++) {
                if($filter['success_sbr'][$i] == 1)
                    $s[] = $i;
            }
            if($s) {
                $filter_where[] = $DB->parse('r.rank IN (?l)', $s);
            }
            $filter_where[] = 'r.sbr_sum > 0';
        }
            
        if($filter['is_preview']) {
            $filter_join['rating'] = $jstr_rating;
            $filter_where[] = 'r.o_wrk_factor_a > 0';
        }
            
        if($filter['is_pro']) {
            $filter_where[] = 's.is_pro = true';    
        }
        if($filter['is_verify']) {
            $filter_where[] = 's.is_verify = true';    
        }

        if($filter['only_tu']) {
        	$filter_where[] = ' s.uid IN (SELECT tservices.user_id FROM tservices WHERE tservices.active=true AND tservices.deleted=false) ';
        }

            
        if($filter['sbr_is_positive']) {
            $filter_where[] = '(uc.paid_advices_cnt + uc.sbr_opi_plus + uc.tu_orders_plus + uc.projects_fb_plus) > 0';
        }
            
        if($filter['sbr_not_negative']) {
            $filter_where[] = '(uc.sbr_opi_minus + uc.tu_orders_minus + uc.projects_fb_minus) = 0';
        }
        
        if($filter['opi_is_positive']) {
            $filter_where[] = '(uc.ops_emp_plus + uc.ops_frl_plus) > 0';
        }
            
        if($filter['opi_not_negative']) {
            $filter_where[] = '(uc.ops_emp_minus + uc.ops_frl_minus) = 0';
        }
        
        if($filter['only_free']) {
            $filter_where[] = 's.status_type = 0';
        }
            
        if($filter['in_office']) {
            $filter_where[] = 's.in_office = true';   
        }
            
            
        if($filter['wo_cost']=='f') // hh
            $filter_where[] = 's.cost_month <> 0';

        if($filter['cost']) {
            foreach($filter['cost'] as $k=>$val) {
                if($val['cost_from'] || $val['cost_to']) {
                    switch($val['type_date']) {
                        default:
                        case 4: 
                            if($prof_id) {
                                $cf = 'pc.cost_hour'; $ct = 'pc.cost_type_hour';
                            } else {
                                $cf = 's.cost_hour'; $ct = 's.cost_type_hour'; 
                            }
                            break;
                        case 3: $cf = 'pc.cost_from'; $ct = 'pc.cost_type'; break;
                        case 1: $cf = 's.cost_month'; $ct = 's.cost_type_month'; break;
                        case 2: $cf = 'pc.cost_1000'; $ct = 'pc.cost_type'; break;
                    }
                    $cr = (int)$val['cost_type'];
                    $cex = array(freelancer::USD=>project_exrates::USD, freelancer::EUR=>project_exrates::EUR, freelancer::RUR=>project_exrates::RUR, freelancer::FM=>project_exrates::FM); 
                    if(($cost_from = (float)$val['cost_from']) < 0) $cost_from = 0;
                    if(($cost_to = (float)$val['cost_to']) < 0)     $cost_to = 0;
                    if($cost_to < $cost_from && $cost_to != 0)      $cost_to = $cost_from;
                    if($cost_to || $cost_from) {
                        $cost_sql = "";
                        for($i=0;$i<4;$i++) {
                            $exfr = round($cost_from * $project_exRates[$cex[$cr].$cex[$i]],4);
                            $exto = round($cost_to * $project_exRates[$cex[$cr].$cex[$i]],4);
                            $cost_sql .= ($i ? ' OR ' : '')."(COALESCE({$ct},0) = {$i} AND {$cf} >= {$exfr}".($cost_to ? " AND {$cf} <= {$exto}" : '').')';
                        }
                        if($filter['wo_cost']=='t') // hh
                            $cost_sql .= " OR {$cf} = 0";
                        $a_cost_sql[] = $cost_sql;
                    }
                }
            }
                
            if($a_cost_sql)
                $filter_where[] = '(' . implode(" OR ", $a_cost_sql) . ')'; 
        }
            
        if($filter['exp'][0] > 0 || $filter['exp'][1] > 0) {
            if($filter['exp'][1] == 0 && $filter['exp'][0] > 0) {
                $filter_where[] = $DB->parse("s.exp >= ?", $filter['exp'][0]);
            } else if($filter['exp'][1] > 0 && $filter['exp'][0] == 0) {
                $filter_where[] = $DB->parse("s.exp <= ?", $filter['exp'][1]);
            } else {
                $filter_where[] = $DB->parse("s.exp >= ? AND s.exp <= ?", $filter['exp'][0], $filter['exp'][1]);
            }
        }
            
        /* �� ������������?
        if($filter['login']) {
            $filter_where[] = "(s.uname ILIKE '" . trim($filter['login']) . "' OR s.usurname ILIKE '" . trim($filter['login']) . "' OR s.login ILIKE '" . trim($filter['login']) . "')";
        }*/
            
        if($filter['wo_age']=='f') // hh
            $filter_where[] = "COALESCE(s.birthday, 'epoch') > '1910-01-01'";
        if($filter['age'][1] > 0 || $filter['age'][0] > 0) {
            $age_from  = $filter['age'][0];
            $age_to    = $filter['age'][1];
            $ccond = "AND s.birthday > '1910-01-01'";
            if ($filter['wo_age']=='t') { // hh
                $ccond = "OR COALESCE(s.birthday, 'epoch') <= '1910-01-01'";
            }
            if ($age_to == 0 && $age_from > 0) {
                $filter_where[] = $DB->parse("extract('year' from age(s.birthday)) >= ?i {$ccond}", $age_from);
            } elseif ($age_to > 0 && $age_from == 0) {
                $filter_where[] = $DB->parse("extract('year' from age(s.birthday)) <= ?i {$ccond}", $age_to);
            } else {
                $filter_where[] = $DB->parse("(extract('year' from age(s.birthday)) BETWEEN ?i AND ?i) {$ccond}", $age_from, $age_to);
            }
        }            
            
        $userIsAuth = $_SESSION["uid"];

        if($cc = $filter['country']) {
        if(is_array($cc))
            $cc = implode(',', $cc);
        $filter_where[] = "s.country IN ({$cc})";
            if (!$userIsAuth) {
                $filter_where[] = "position ('\"country\"' IN s.info_for_reg) = 0"; /*������� � ��������������� ������� �����, ������� �� ���� ���������� ���������������, ���� �� ���� country*/
            }
        }
        if($cc = $filter['city']) {
            if(is_array($cc))
                $cc = implode(',', $cc);
            $filter_where[] = "s.city IN ({$cc})";
            if (!$userIsAuth) {
                $filter_where[] = "position ('\"city\"' IN s.info_for_reg) = 0";
            }
        }
        
            
            
        if($filter['sex']) {
            $fsex = $filter['sex'] == 2 ? 'TRUE' : 'FALSE';
            $filter_where[] = "s.sex = $fsex";
        }

        $filter_where = implode(' AND ', $filter_where);
        $filter_join  = implode(' ', $filter_join);

        return array($filter_where, $filter_join);
    }

    /**
     * C����� � ������� ������ �� ������� ���� ��������� ������ ��� �������������
     * 
     * @global object $DB
     * @param int $prof_id - �������������
     * @param bool $is_spec - ������ ��� �������������
     * @return boolean
     */
    public static function clearCacheFromProfId($prof_id = 0, $is_spec = true)
    {
        global $DB;
        $key = sprintf(($is_spec)?static::CATALOG_PROFF_MEM_TAG:static::CATALOG_GROUP_MEM_TAG, $prof_id);
        return $DB->query("SELECT pgq.insert_event('share', 'memcache_flush_group', 'key={$key}');");
    }
    
    /**
     * ������� ���� ��������� ������ ��� ������������� �������
     * 
     * @global object $DB
     * @param int $prof_id - �������������
     * @param bool $is_spec - ������ ��� �������������
     * @return boolean
     */
    public static function clearCacheFromProfIdNow($prof_id = 0, $is_spec = true)
    {
        $key = sprintf(($is_spec)?static::CATALOG_PROFF_MEM_TAG:static::CATALOG_GROUP_MEM_TAG, $prof_id);
        $memBuff = new memBuff;
        return $memBuff->flushGroup($key);
    }

    /**
     * ������� ���� ������ ��������
     * 
     * @global object $DB
     * @return type
     */
    public static function clearCacheCatalog()
    {
        global $DB;
        $key = static::CATALOG_MEM_TAG;
        return $DB->query("SELECT pgq.insert_event('share', 'memcache_flush_group', 'key={$key}');");
    }
    
    
    /**
     * �������� ������ ����� ��� ������� � ����
     * 
     * @param type $prof_id
     * @param type $is_spec
     * @return type
     */
    public static function getCatalogMemTags($prof_id = 0, $is_spec = true)
    {
        $key = sprintf(($is_spec)?static::CATALOG_PROFF_MEM_TAG:static::CATALOG_GROUP_MEM_TAG, $prof_id);
        return array(static::CATALOG_MEM_TAG, $key);
    }
            
    
    function getCatalog($prof_id, $uid, &$count, &$size, &$works, $limit, $offset, $order = "general", $direction = 0, $favorite = 0, $filter = NULL)
    {
        //return $this->old_getCatalog($prof_id, $uid, $count, $size, $works, $limit, $offset, $order, $direction, $favorite, $filter);
        return $this->new_getCatalog($prof_id, $uid, $count, $size, $works, $limit, $offset, $order, $direction, $favorite, $filter);
    }



    /**
     * ���������� �������� �������� ����������� �� ����� ������������ ������������.
     * 
     * ������� ���������������� ������ old_getCatalog
     * - �������������� �������, ����� ���������� ����������
     * - �������� ������ ����� ��������� �� �������� �������� (�� ����� �������� ������)
     * - ��� ������� ��������� ����������� ������
     * 
     * 
     * @param integer prof_id     ��. ��������� (������� ��������). ���� 0, �� ������� ����������� �� ������ ��������.
     * @param integer uid         ��. �����, ���������������� �������.
     * @param integer count       ���������� ����� ����������� � ������ ������� ��������.
     * @param integer size        ���������� ����������� �� ������ �������� ��������.
     * @param array   works       ������, ��������������� ��. �����������, ���������� ������ �� ���� ������ ����� ������� ���������� � ������ �������.
     * @param integer limit       ������� ����������� �� ����� ��������.
     * @param integer offset      OFFSET.
     * @param string  order       ��� ���������� (��. �������������).
     * @param int     direction   ������� ����������. 0 -- �� ���������, �� 0 -- �� ������������.
     * @param int     favorite    ���� -- ���������� �� ������ ���������.
     * @param array   filter      ������ � ����������� ������� ��� NULL -- ������ �� ��������.
     *
     * @return array  ������ � ������������.
     */
    function new_getCatalog($prof_id, $uid, &$count, &$size, &$works, $limit, $offset, $order = "general", $direction = 0, $favorite = 0, $filter = NULL)
    {
        require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/projects.php");
        global $DB;
        
        //������� ������ ��� �������������
        $current_categoty_id = 0;
        //������ ��� �������������
        $current_categoty_is_spec = ($prof_id > 0);
        
        $project_exRates = project_exrates::GetAll();

        $fu_table = self::$fu_table;

        //���������� ��� ��������� ������ ����� ���������
        //��� ��� ��� ������� �� ������������ ������
        //������ �������������� ���������� ������ (������)!
        if (isset($filter['prof'])) {
            $tmp_filter = $filter;
            $filter = array();
            $filter['prof'] = $tmp_filter['prof'];
        }
        
        $fprms = self::createCatalogFilterSql($filter, $prof_id);        
        
        if ($fprms==-1) {
            return null;
        }
        
        //@todo: ������ �������� ����� �� ���������� �� ��������� ���������
        //$filter_join �� ������������!
        //$filter_where ������ �� ��������
        list($filter_where, $filter_join) = $fprms;
        
        $filter_join = '';
        
        if ($filter_where) {
            $filter_where = ' AND '.$filter_where;
        }
        

        $size = 0;
        if ($prof_id) {
            $or_prof = professions::GetProfessionOrigin($prof_id);
            $ord_spec = ', s.its_his_main_spec DESC';
        }
        
        
        // ������ ������������� ��� ���������� � ���������
        $specs_list = '';
        
        $dir_sql = (!$direction ? 'DESC' : 'ASC');
        
        switch($order)
        {
            case "opinions":
                $uc_side = 'INNER';
                $order = ", osum {$dir_sql}, s.rating {$dir_sql}";
                break;
            case "sbr":
                $uc_side = 'INNER';
                $order = ", ssum {$dir_sql}, s.rating {$dir_sql}";
                break;
            case "cost_hour":
                $order = "{$ord_spec}, cost_hour_is_0, cost_fm {$dir_sql}, s.rating {$dir_sql}";
                $orderCf = 'pc.cost_hour';
                $orderCt = 'pc.cost_type_hour';
                break;
            case "cost_month":
                $order = "{$ord_spec}, COALESCE(s.cost_month,0)=0, cost_fm {$dir_sql}, s.rating {$dir_sql}";
                $orderCf = 's.cost_month';
                $orderCt = 's.cost_type_month';
                break;
            case "cost_proj":
                $order = "{$ord_spec}, COALESCE(cost_from,0)=0, cost_fm {$dir_sql}, s.rating {$dir_sql}";
                $orderCf = 'pc.cost_from';
                $orderCt = 'pc.cost_type';
                break;
            case "cost_1000":
                $order = "{$ord_spec}, COALESCE(cost_1000,0)=0, cost_fm {$dir_sql}, s.rating {$dir_sql}";
                $orderCf = 'pc.cost_1000';
                $orderCt = 'pc.cost_type';
                break;
            case "general":
            default:
                $order = "{$ord_spec}, rating_get(s.rating, s.is_pro, s.is_verify, s.is_profi) {$dir_sql}";
                break;
        }

        $cost_fm = '';
        if (isset($orderCf, $orderCt)) {
            $cost_fm = ",
            CASE WHEN COALESCE({$orderCt},0) = 0 THEN {$orderCf} * {$project_exRates[24]}
                 WHEN {$orderCt} = 1 THEN {$orderCf} * {$project_exRates[34]}
                 WHEN {$orderCt} = 2 THEN {$orderCf} * {$project_exRates[44]}
                 WHEN {$orderCt} = 3 THEN {$orderCf} * {$project_exRates[14]}
                 ELSE {$orderCf}
             END as cost_fm ";
        }
        
        
        
        if (!isset($uc_side)) {
            //@todo: ������ �������� ����� �� ���������� �� ��������� ���������
            $uc_side = strpos($filter_where, 'uc.') !== false ? 'INNER' : 'OUTER';
        }
        
        $uc_cols = $uc_join = array('INNER' => '', 'OUTER' => '');
        
        //� ����������� ������� ���������� ������� � ����������� ���������� �� ������ ��� �����
        $uc_cols[$uc_side] = ", 
          uc.ops_emp_plus + uc.ops_frl_plus as sg, 
          uc.ops_emp_minus + uc.ops_frl_minus as sl, 
          uc.ops_emp_null + uc.ops_frl_null as se,
          zin(uc.paid_advices_cnt + uc.sbr_opi_plus + uc.tu_orders_plus + uc.projects_fb_plus)-zin(uc.sbr_opi_minus + uc.tu_orders_minus + uc.projects_fb_minus) as ssum, 
          zin(uc.ops_emp_plus)-zin(uc.ops_emp_minus) as osum,
          (uc.paid_advices_cnt + uc.sbr_opi_plus + uc.tu_orders_plus + uc.projects_fb_plus) AS total_opi_plus,
          (uc.sbr_opi_null) AS total_opi_null,
          (uc.sbr_opi_minus + uc.tu_orders_minus + uc.projects_fb_minus) AS total_opi_minus,
          uc.*";
        $uc_join[$uc_side] = "LEFT JOIN users_counters uc ON uc.user_id = s.uid";
        
        //� �������� ������� ������������ ���� �� user_counters, ������� JOIN ����� ������ ������
        $uc_join['OUTER'] = "LEFT JOIN users_counters uc ON uc.user_id = s.uid";
        
        if( $prof_id ) {
            // ��������� � ���������� ������� (������ �������, ���������).
            
            $current_categoty_id = $or_prof;
            
            //���� ���� ���������� ��� ������ �� �������� ������ �������
            //@todo: ������ � �������� �� ������������ �� ��������� ���������
            $pc_side = strpos($filter_where, 'pc.') !== false || strpos($cost_fm, 'pc.') !== false  ? 'INNER' : 'OUTER';
            $pc_cols = $pc_join = array('INNER' => '', 'OUTER' => '');
            
            //� ����������� ������� ���������� ������� � ����������� ���������� �� ������ ��� �����
            $pc_cols[$pc_side] = ", 
              (COALESCE(pc.cost_hour, 0) = 0) as cost_hour_is_0, 
              pc.cost_hour, 
              pc.cost_type_hour, 
              pc.cost_from, 
              pc.cost_type, 
              pc.cost_1000";
            
            $pc_join[$pc_side] = "LEFT JOIN portf_choise pc ON pc.prof_id = '{$or_prof}' AND pc.user_id = s.uid";
            
            //�������� �������
            $fu = "(
              SELECT 
                s.*, 
                true AS its_his_main_spec 
              FROM {$fu_table} AS s
              WHERE spec_orig = '{$or_prof}'
                  
              UNION ALL
              
              SELECT 
                s.*, 
                false AS its_his_main_spec 
              FROM {$fu_table} AS s
              INNER JOIN spec_add_choise sp ON sp.user_id = s.uid AND sp.prof_id = '{$or_prof}' 
              WHERE s.is_pro = true 
            )";
            
            //�������� ����� ������  
              
            //@todo: ������������� ������� completed_cnt � users_counters ������� � � ��� �����������
            //��� �����, ��� � ��� ��� ���� ���-�� �� ����� �� reserves_completed_cnt
            //����� �������� ���� �� ������ �� � ����������� ����
              
            $sql = "
              SELECT s.*,
                     city.city_name as str_city, 
                     country.country_name as str_country, 
                     COALESCE(smeta.completed_cnt, 0) + COALESCE(uc.reserves_completed_cnt, 0) AS completed_cnt, -- ������ �� + ����� ��
                     rating_get(s.rating, s.is_pro, s.is_verify, s.is_profi) as t_rating
                     {$uc_cols['OUTER']}
                     {$pc_cols['OUTER']}
                FROM (
                  SELECT s.* 
                         {$cost_fm}, 
                         s.cost_hour as frl_cost_hour, 
                         s.cost_type_hour as frl_cost_type_hour,
                         
                         (fb.id > 0)::boolean AS is_binded,
                         fb.id AS fb_id,
                         fb.date_start AS fb_date_start 
                         
                         {$uc_cols['INNER']}
                         {$pc_cols['INNER']}
                  FROM {$fu} AS s 
                  {$uc_join['INNER']}
                  {$pc_join['INNER']}
                  {$filter_join}
                  LEFT JOIN freelancer_binds fb 
                    ON fb.user_id = s.uid 
                       AND fb.prof_id = '{$or_prof}' 
                       AND fb.status = true 
                       AND fb.date_stop > NOW() --���������� ������� ������ � ��������
                  WHERE 
                    s.is_banned = '0' 
                    AND s.last_time > now() - '6 months'::interval 
                    AND ( s.cat_show = 't' OR s.is_pro = 'f' ) --���������� ��������� �� ������
                    {$filter_where} 
                  ORDER BY (fb.id IS NULL)::boolean ASC, fb.date_start DESC, s.is_pro DESC {$order}, s.uid
                  LIMIT {$limit} OFFSET {$offset}                 
                ) as s 
              {$uc_join['OUTER']}
              {$pc_join['OUTER']}
              LEFT JOIN country  ON country.id = s.country
              LEFT JOIN city ON city.id = s.city
              LEFT JOIN sbr_meta AS smeta ON smeta.user_id = s.uid -- ������ ��
              ORDER BY (fb_id IS NULL)::boolean ASC, fb_date_start DESC, s.is_pro DESC {$order}, s.uid
            ";
            
             //������� ���������� 
             $countSql = "
                 SELECT 
                    COUNT(s.uid) AS count, 
                    SUM(s.is_pro::int) AS payed 
                 FROM {$fu} AS s {$filter_join} "
                 . ($filter_where ? $uc_join['INNER'].' '.$pc_join['INNER'] : '')
                 . " WHERE 
                     s.is_banned = '0' 
                     AND ( s.cat_show = 't' OR s.is_pro = 'f' ) --���������� ��������� �� ������
                     AND s.last_time > now() - '6 months'::interval 
                     {$filter_where}";
   
        } else {
            
            $join_add_spec = '';
            $prof_choise_condition = "pc.prof_id = s.spec_orig";
            $pattern = "#(s.spec_orig\s+(IN\s+\([\d,]+\)))#";
            $order_add_spec = "";
            $order_add_spec_field = "";
            if (preg_match($pattern, $filter_where, $m)) {
                $filter_where = preg_replace(
                        $pattern, 
                        "($1 OR (sa.prof_id $2 AND s.is_pro = 't' ))", 
                        $filter_where);

               $join_add_spec = "LEFT JOIN 
                   spec_add_choise sa
                     ON  sa.user_id = s.uid";
               
               $prof_choise_condition = "(
                    pc.prof_id = s.spec_orig
                      OR pc.prof_id = sa.prof_id
                      )";
               
               //$order_add_spec = "aso DESC, ";
               $order_add_spec_field = "CAST(s.spec_orig {$m[2]} AS integer) AS aso, ";
            }

            
            // ���������� ����������� ������ ������������ �������� ������ �� ����������
            $spec_case_order = '';
            if (isset($m[2]) && $m[2]) {
                $spec_case_order = ", CASE WHEN s.spec_orig {$m[2]} THEN 1 ELSE 2 END";
                $specs_list = "p.prof_id {$m[2]}";
            }
            
            // ��������� ��� ������������ �������
            $fb_on_prof = 0;
            if($filter['prof']) {
                if(count($filter['prof'][0]) > 0) {
                    $group_ids = array_keys($filter['prof'][0]);
                    $fb_on_prof = $group_ids[0];
                    $current_categoty_id = $fb_on_prof;
                }
            }
            
            $sql = "
                SELECT
                    s.*,
                    city.city_name as str_city, 
                    country.country_name as str_country, 
                    COALESCE(smeta.completed_cnt, 0) + COALESCE(uc.reserves_completed_cnt, 0) AS completed_cnt, -- ������ �� + ����� ��
                    p.name as profname, 
                    p.is_text,
                    rating_get(s.rating, s.is_pro, s.is_verify, s.is_profi) as t_rating
                    
                    {$uc_cols['OUTER']}
               FROM (
                    SELECT *
                    FROM (
                        SELECT 
                            DISTINCT ON (s.uid) 
                            s.*, 
                            s.cost_hour as frl_cost_hour, 
                            s.cost_type_hour as frl_cost_type_hour, 
                            {$order_add_spec_field} 

                            (COALESCE(pc.cost_hour, 0) = 0) as cost_hour_is_0, 
                            pc.cost_hour, 
                            pc.cost_from, 
                            pc.cost_type, 
                            pc.cost_1000, 
                            pc.cost_type_hour, 
                            
                            (fb.id > 0)::boolean as is_binded, 
                            fb.id AS fb_id,
                            fb.date_start AS fb_date_start
                            
                            {$cost_fm}
                            {$uc_cols['INNER']}
                        FROM {$fu_table} s 
                            {$join_add_spec} 
                            {$uc_join['INNER']}
                            LEFT JOIN portf_choise pc 
                                ON $prof_choise_condition 
                                   AND pc.user_id = s.uid 
                            LEFT JOIN freelancer_binds fb 
                                ON fb.user_id = s.uid 
                                   AND fb.prof_id = {$fb_on_prof} 
                                   AND fb.is_spec = FALSE
                                   AND fb.status = TRUE 
                                   AND fb.date_stop > NOW() --���������� ������� ������ � ��������
                            {$filter_join}
                            WHERE s.is_banned = '0' {$filter_where}  
                                  AND ( s.cat_show = 't' OR s.is_pro = 'f' ) --���������� ��������� �� ������
                                  AND s.last_time > now() - '6 months'::interval
                    ) AS s    
                    ORDER BY 
                        (fb_id IS NULL)::boolean ASC, fb_date_start DESC, 
                        s.is_pro DESC {$spec_case_order} {$order}, {$order_add_spec} s.uid
                    LIMIT {$limit} OFFSET {$offset}
               ) AS s
                {$uc_join['OUTER']}
                LEFT JOIN professions p ON p.id = s.spec 
                LEFT JOIN country ON country.id = s.country 
                LEFT JOIN sbr_meta AS smeta ON smeta.user_id = s.uid --������ ��
                LEFT JOIN city ON city.id = s.city
                ORDER BY
                    (fb_id IS NULL)::boolean ASC, fb_date_start DESC, 
                    s.is_pro DESC {$spec_case_order} {$order}, {$order_add_spec} s.uid";
                    
           $filter_where .= " AND s.last_time > now() - '6 months'::interval AND ( s.cat_show = 't' OR s.is_pro = 'f' )"; 
           $countSql = self::_createMainCountSql($filter_where, $filter_join, $join_add_spec);
        }
        
        $memBuff = new memBuff();
        //$DB->setTimeout(90);
        $frls = $memBuff->getSql(
                $error, 
                $sql, 
                self::CATALOG_MEM_LIFE, 
                true, 
                static::getCatalogMemTags($current_categoty_id, $current_categoty_is_spec));
        
        //@todo: ��������� ���������� ���������� -1
        //$DB->setTimeout(-1);
        if ($error || !$frls) {
            return NULL;
        }
        
        if (!$prof_id && !$offset && !$memBuff->getBWasMqUsed()) {
            professions::RecalcCatalogPositions();
        }

        //$DB->setTimeout(90);
        $count_arr = $memBuff->getSql(
                $error, 
                $countSql, 
                self::CATALOG_MEM_LIFE, 
                true, 
                static::getCatalogMemTags($current_categoty_id, $current_categoty_is_spec));
        //$DB->setTimeout();
        $count = $count_arr[0]['count'];
        $size = sizeof($frls);
        

        /*
         * @todo: ���� �� ���� �� ������������� getCatalog ��� �� ������������
        if ($prof_id && !$memBuff->getBWasMqUsed() && !$filter_where) {
            professions::UpdateProfessionCount($or_prof, $count, $count_arr[0]['payed']);
        }
        */
        
        $frl_ids = array();
        $frl_ids_map = array();
        $tu_frl_ids = array();
        
        foreach ($frls as $key => $row) {
            $frl_ids[$key] = $row['uid'];
            $frl_ids_map[$row['uid']] = $key;
            
            //���� ������� �� ��������� �� ����� ��������� ����� UID
            if (substr($row['tabs'], 7, 1) == 1) {
                $tu_frl_ids[$key] = $row['uid'];
            }
        }
        

        //��������� ���������������� ������ �����/�����
        require_once(ABS_PATH . '/freelancers/widgets/FreelancersPreviewWidget.php');
        require_once(ABS_PATH . '/freelancers/models/FreelancersPreviewModel.php');

        $freelancersPreviewModel = new FreelancersPreviewModel();
        $list = $freelancersPreviewModel->getListByUids(
                    $frl_ids,
                    ($current_categoty_is_spec?0:$current_categoty_id),
                    $prof_id);

        $tmp_tu_uids = $tu_frl_ids;
        foreach ($list as $item) {
            //���� ��������� ������� �� �� �� ���������
            if (!$item || ($item->type == FreelancersPreviewModel::TYPE_TU && 
                !in_array($item->user_id, $tmp_tu_uids))) {
                    continue;
            }

            //�������������� ������ ����� � ������/������ ���� ������ ����� �����
            $key = $frl_ids_map[$item->user_id];
            $item->setUser(array('login' => $frls[$key]['login']));

            //������ ������ ���� ��� ���
            if (!isset($frls[$key]['preview'])) {
                $frls[$key]['preview'] = new FreelancersPreviewWidget(array(
                    'is_owner' => (($frls[$key]['uid'] == $uid) && ($frls[$key]['is_pro'] == 't'))
                ));
            }

            //��������� ������ � ������
            $frls[$key]['preview']->addItem($item);

            //��������� �� ���������� ���������
            unset($frl_ids[$key], $tu_frl_ids[$key]);
        }

        
        
        if ($frl_ids) {
            $join_blocked  = ' LEFT JOIN portfolio_blocked pb ON p.id = pb.src_id ';
            $where_blocked = ' AND pb.src_id IS NULL ';

            $sql = "
                SELECT 
                    p.id, 
                    p.user_id, 
                    p.name, 
                    p.descr, 
                    p.pict, 
                    p.prev_pict, 
                    p.show_preview, 
                    p.norder, 
                    p.prev_type, 
                    p.is_video
                FROM portfolio p 
                INNER JOIN portf_choise pc ON pc.user_id = p.user_id AND pc.prof_id = p.prof_id 
                ".( $prof_id ? '' : 'INNER JOIN freelancer f ON f.uid = p.user_id' )."
                $join_blocked 
                WHERE p.user_id IN (".implode(',', $frl_ids).")";

            if ($specs_list) {
                $sql .= " AND $specs_list";
            } else {
                $sql .= " AND p.prof_id = ".($prof_id ? "'{$or_prof}'" : 'f.spec_orig');            
            }

            $sql .= " AND p.first3 = true  $where_blocked ORDER BY p.user_id, p.norder";


            if ($ret = $memBuff->getSql(
                    $error, 
                    $sql, 
                    self::CATALOG_PORTFOLIO_MEM_LIFE, 
                    true, 
                    static::getCatalogMemTags($current_categoty_id, $current_categoty_is_spec))) {

               $current_user_pf_ids = array();

               foreach ($ret as $row) {
                   $works[$row['user_id']][] = $row;

                   if ($row['user_id'] == $uid) {
                       $current_user_pf_ids[] = $row['id'];
                   }
               }

               if (!empty($current_user_pf_ids)) {
                   FreelancersPreviewModel::setExistPreviewData(
                           FreelancersPreviewModel::TYPE_PF, $current_user_pf_ids);
               }
            } 
        }
        
        //----------------------------------------------------------------------
        
        //���� � ������������ �� ����������� ��������� 
        //�� ����� �������� 3 ��������� ��
        $exist_uids = ($works)? array_keys($works) : array();
        $tu_uids = array_diff($tu_frl_ids, $exist_uids);
        
        if ($tu_uids) {
            require_once(ABS_PATH . '/tu/models/TServiceModel.php');
            
            $tserviceModel = new TServiceModel();
            if($list = $tserviceModel->getListByUids(
                    $tu_uids, 3,
                    self::CATALOG_PORTFOLIO_MEM_LIFE)) {
                
                $current_user_tu_ids = array();
                
                foreach ($list as $item) {
                    $key = $frl_ids_map[$item['user_id']];
                    $item['login'] = $frls[$key]['login'];
                    $frls[$key]['tservices'][] = $item;
                    
                    if ($item['user_id'] == $uid) {
                        $current_user_tu_ids[] = $item['id'];
                    }
                }
                
                if (!empty($current_user_tu_ids)) {
                    FreelancersPreviewModel::setExistPreviewData(
                        FreelancersPreviewModel::TYPE_TU, $current_user_tu_ids);                    
                }
            }
        }

        return $frls;
    }
    
    
    
    /**
     * ���������� �������� �������� ����������� �� ����� ������������ ������������. ������� ������!
     *
     * @param integer prof_id     ��. ��������� (������� ��������). ���� 0, �� ������� ����������� �� ������ ��������.
     * @param integer uid         ��. �����, ���������������� �������.
     * @param integer count       ���������� ����� ����������� � ������ ������� ��������.
     * @param integer size        ���������� ����������� �� ������ �������� ��������.
     * @param array   works       ������, ��������������� ��. �����������, ���������� ������ �� ���� ������ ����� ������� ���������� � ������ �������.
     * @param integer limit       ������� ����������� �� ����� ��������.
     * @param integer offset      OFFSET.
     * @param string  order       ��� ���������� (��. �������������).
     * @param int     direction   ������� ����������. 0 -- �� ���������, �� 0 -- �� ������������.
     * @param int     favorite    ���� -- ���������� �� ������ ���������.
     * @param array   filter      ������ � ����������� ������� ��� NULL -- ������ �� ��������.
     *
     * @return array  ������ � ������������.
     */
    function old_getCatalog($prof_id, $uid, &$count, &$size, &$works, $limit, $offset, $order = "general", $direction = 0, $favorite = 0, $filter = NULL)
    {
        require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/projects.php");
        global $DB;
        $project_exRates = project_exrates::GetAll();
        $dir_sql = (!$direction ? 'DESC' : 'ASC');
        $cost_fm = '';
     
        $fu_table = self::$fu_table;

        $fprms = self::createCatalogFilterSql($filter, $prof_id);
        if($fprms==-1) {
            return null;
        }
        
        list($filter_where, $filter_join) = $fprms;
        if($filter_where) {
            $filter_where = ' AND '.$filter_where;
        }
        
        if(!$filter_where && intval($_SESSION['region_filter_country'])) {
        	$filter_where = 'AND s.country IN ('.intval($_SESSION['region_filter_country']).')'.(intval($_SESSION['region_filter_city'])!=0 ? 'AND s.city IN ('.intval($_SESSION['region_filter_city']).') ' : '');
        }

        $size = 0;
        if($prof_id) {
            $or_prof = professions::GetProfessionOrigin($prof_id);
            $ord_spec = ', s.its_his_main_spec DESC';
        }

        // ������ ������������� ��� ���������� � ���������
        $specs_list = '';

        switch($order)
        {
            case "opinions":
                $uc_side = 'INNER';
                $order = ", osum {$dir_sql}, s.rating {$dir_sql}";
                break;
            case "sbr":
                $uc_side = 'INNER';
                $order = ", ssum {$dir_sql}, s.rating {$dir_sql}";
                break;
            case "cost_hour":
                $order = "{$ord_spec}, cost_hour_is_0, cost_fm {$dir_sql}, s.rating {$dir_sql}";
                $orderCf = 'pc.cost_hour';
                $orderCt = 'pc.cost_type_hour';
                break;
            case "cost_month":
                $order = "{$ord_spec}, COALESCE(s.cost_month,0)=0, cost_fm {$dir_sql}, s.rating {$dir_sql}";
                $orderCf = 's.cost_month';
                $orderCt = 's.cost_type_month';
                break;
            case "cost_proj":
                $order = "{$ord_spec}, COALESCE(cost_from,0)=0, cost_fm {$dir_sql}, s.rating {$dir_sql}";
                $orderCf = 'pc.cost_from';
                $orderCt = 'pc.cost_type';
                break;
            case "cost_1000":
                $order = "{$ord_spec}, COALESCE(cost_1000,0)=0, cost_fm {$dir_sql}, s.rating {$dir_sql}";
                $orderCf = 'pc.cost_1000';
                $orderCt = 'pc.cost_type';
                break;
            case "general":
            default:
                $order = "{$ord_spec}, rating_get(s.rating, s.is_pro, s.is_verify, s.is_profi) {$dir_sql}";
                break;
        }

        if($orderCf && $orderCt) {
            $cost_fm = ",
            CASE WHEN COALESCE({$orderCt},0) = 0 THEN {$orderCf} * {$project_exRates[24]}
                 WHEN {$orderCt} = 1 THEN {$orderCf} * {$project_exRates[34]}
                 WHEN {$orderCt} = 2 THEN {$orderCf} * {$project_exRates[44]}
                 WHEN {$orderCt} = 3 THEN {$orderCf} * {$project_exRates[14]}
                 ELSE {$orderCf}
             END as cost_fm ";
        }
        
        if(!$uc_side) {
            $uc_side = strpos($filter_where, 'uc.') !== false ? 'INNER' : 'OUTER';
        }
        $uc_cols[$uc_side] = "
          , uc.ops_emp_plus + uc.ops_frl_plus as sg, uc.ops_emp_minus + uc.ops_frl_minus as sl, uc.ops_emp_null + uc.ops_frl_null as se,
          zin(uc.paid_advices_cnt + uc.sbr_opi_plus + uc.tu_orders_plus + uc.projects_fb_plus)-zin(uc.sbr_opi_minus + uc.tu_orders_minus + uc.projects_fb_minus) as ssum, 
          zin(uc.ops_emp_plus)-zin(uc.ops_emp_minus) as osum,
          (uc.paid_advices_cnt + uc.sbr_opi_plus + uc.tu_orders_plus + uc.projects_fb_plus) AS total_opi_plus,
          (uc.sbr_opi_null) AS total_opi_null,
          (uc.sbr_opi_minus + uc.tu_orders_minus + uc.projects_fb_minus) AS total_opi_minus,
          uc.*
        ";
        $uc_join[$uc_side] = "LEFT JOIN users_counters uc ON uc.user_id = s.uid";
        
        $fb_cols = "
        ,   (fb.id > 0)::boolean as is_binded
        ";
        
        
        if( $prof_id ) // ��������� � ���������� �������.
        {
            $fb_join = "LEFT JOIN freelancer_binds fb ON fb.user_id = s.uid AND fb.prof_id = '{$or_prof}' AND fb.status = TRUE AND fb.date_stop > NOW()";
            $pc_side = strpos($filter_where, 'pc.') !== false || strpos($cost_fm, 'pc.') !== false  ? 'INNER' : 'OUTER';
            $pc_cols[$pc_side] = "
              , (COALESCE(pc.cost_hour, 0) = 0) as cost_hour_is_0, pc.cost_hour, pc.cost_type_hour, pc.cost_from, pc.cost_type, pc.cost_1000
              
            ";
            $pc_join[$pc_side] = "LEFT JOIN portf_choise pc ON pc.prof_id = '{$or_prof}' AND pc.user_id = s.uid";
            
            $fu = "(
              SELECT *, true as its_his_main_spec FROM {$fu_table} WHERE spec_orig = '{$or_prof}'
              UNION ALL
              SELECT {$fu_table}.*, false FROM {$fu_table} INNER JOIN spec_add_choise sp ON sp.user_id = {$fu_table}.uid AND sp.prof_id = '{$or_prof}' WHERE {$fu_table}.is_pro = true
              UNION ALL
              SELECT {$fu_table}.*, false FROM {$fu_table} INNER JOIN spec_paid_choise pc ON pc.user_id = {$fu_table}.uid AND pc.prof_id = '{$or_prof}' AND pc.paid_to > NOW()
            )";
            
            $sql = "
              SELECT s.*,
                     city.city_name as str_city, country.country_name as str_country, sbr_meta.completed_cnt,
                     rating_get(s.rating, s.is_pro, s.is_verify, s.is_profi) as t_rating
                     {$uc_cols['OUTER']}
                     {$pc_cols['OUTER']}
                     {$fb_cols}
                FROM (
                  SELECT s.* {$cost_fm}, s.cost_hour as frl_cost_hour, s.cost_type_hour as frl_cost_type_hour
                        {$uc_cols['INNER']}
                        {$pc_cols['INNER']}
                    FROM {$fu} as s
                  {$uc_join['INNER']}
                  {$pc_join['INNER']}
                  {$filter_join}
                   {$fb_join}
                   WHERE s.is_banned = '0' {$filter_where} AND ( s.cat_show = 't' OR s.is_pro = 'f' ) 
                   ORDER BY (fb.id IS NULL)::boolean ASC, fb.date_start DESC, s.is_pro DESC {$order}, s.uid
                   LIMIT {$limit} OFFSET {$offset}                 
                ) as s
              {$uc_join['OUTER']}
              {$pc_join['OUTER']}
              {$fb_join}
              LEFT JOIN
              	country 
                  ON country.id = s.country
              LEFT JOIN
              	city 
                  ON city.id = s.city
              LEFT JOIN
              	sbr_meta 
                  ON sbr_meta.user_id = s.uid
              ORDER BY (fb.id IS NULL)::boolean ASC, fb.date_start DESC, s.is_pro DESC {$order}, s.uid
            ";
            
            $countSql = "SELECT COUNT(s.uid) as count, SUM(s.is_pro::int) as payed FROM {$fu} as s {$filter_join} "
                      . ($filter_where ? $uc_join['INNER'].' '.$pc_join['INNER'] : '')
                      . " WHERE s.is_banned = '0' {$filter_where}";
        }
        else {
            // ����� �������.
            // � ������� �� �������� ��� ������� ������ � posrtf_choise -- ��� ���� �� ������� ���������� � ����� ��������.

            //���������� ��� ���������� �������� �� �������������� ��������������
            $join_add_spec = '';
            $prof_choise_condition = "pc.prof_id = s.spec_orig";
            $pattern = "#(s.spec_orig\s+(IN\s+\([\d,]+\)))#";
            $order_add_spec = "";
            $order_add_spec_field = "";
            if (preg_match($pattern, $filter_where, $m)) {
                $filter_where = preg_replace($pattern, "(
                $1  
                OR (sa.prof_id $2 AND s.is_pro = 't' ) -- ������ � ��� ��������� ��� �������������, �� �������� ������� �������������
                OR (sp.prof_id $2  )
                    )", $filter_where);

               $join_add_spec = "LEFT JOIN 
                   spec_add_choise sa
                     ON  sa.user_id = s.uid
                     
                  LEFT JOIN 
                    spec_paid_choise sp
                     ON  sp.user_id = s.uid";
               $prof_choise_condition = "(
                    pc.prof_id = s.spec_orig
                      OR pc.prof_id = sa.prof_id
                      OR pc.prof_id = sp.prof_id
                      )";
               //$order_add_spec = "aso DESC, ";
               $order_add_spec_field = "CAST(s.spec_orig {$m[2]} AS integer) AS aso, ";
            }
            
            
            $distinct = array_map( 'trim', array_filter( explode( ',', str_replace(array('DESC', 'ASC', 'descr', 'asc'), '', $order) ) ) );
            $distinct = $distinct ? implode(", ", $distinct) ."," : "";     

            // ���������� ����������� ������ ������������ �������� ������ �� ����������
            $spec_case_order = '';
            if (isset($m[2]) && $m[2]) {
                $spec_case_order = ", CASE WHEN s.spec_orig {$m[2]} THEN 1 ELSE 2 END";
                $specs_list = "p.prof_id {$m[2]}";
            }
            
            $fb_on_prof = 0;
            if($filter['prof']) {
                if(count($filter['prof'][0]) > 0) {
                    $group_ids = array_keys($filter['prof'][0]);
                    $fb_on_prof = $group_ids[0];
                }
            }
            $fb_join = "LEFT JOIN freelancer_binds fb ON fb.user_id = s.uid AND fb.prof_id = {$fb_on_prof} AND fb.is_spec = FALSE AND fb.status = TRUE AND fb.date_stop > NOW()";

            $sql = "
                    SELECT s.*,
                     city.city_name as str_city, country.country_name as str_country, sbr_meta.completed_cnt,
                     p.name as profname, p.is_text,
                     rating_get(s.rating, s.is_pro, s.is_verify, s.is_profi) as t_rating
                     {$uc_cols['OUTER']}
                     {$fb_cols}
                FROM (
                	SELECT s.* FROM (
                          SELECT  DISTINCT ON (s.is_pro, {$distinct} s.uid) s.*, s.cost_hour as frl_cost_hour, s.cost_type_hour as frl_cost_type_hour, {$order_add_spec_field}
                                (COALESCE(pc.cost_hour, 0) = 0) as cost_hour_is_0, pc.cost_hour, pc.cost_from, pc.cost_type, pc.cost_1000, pc.cost_type_hour as pc_cost_type_hour
                                {$cost_fm}
                                {$uc_cols['INNER']}
                            FROM {$fu_table} s
                          {$join_add_spec}
                          {$uc_join['INNER']}
                          INNER JOIN
                            portf_choise pc
                              ON $prof_choise_condition
                             AND pc.user_id = s.uid
                          {$filter_join}
                           WHERE s.is_banned = '0' {$filter_where}  AND ( s.cat_show = 't' OR s.is_pro = 'f' )
                        ) as s
                    ) as s 
              {$uc_join['OUTER']}
              {$fb_join}
              LEFT JOIN
                professions p
                  ON p.id = s.spec
              LEFT JOIN
              	country 
                  ON country.id = s.country
              LEFT JOIN
              	sbr_meta 
                  ON sbr_meta.user_id = s.uid
              LEFT JOIN
              	city 
                  ON city.id = s.city
               ORDER BY (fb.id IS NULL)::boolean ASC, fb.date_start DESC, s.is_pro DESC {$spec_case_order} {$order}, {$order_add_spec} s.uid
               LIMIT {$limit} OFFSET {$offset}
            ";
            $countSql = self::_createMainCountSql($filter_where, $filter_join, $join_add_spec);
        }
        
        if(!$filter_where) {
            $memBuff = new memBuff();
            $DB->setTimeout(90);
            $frls = $memBuff->getSql($error, $sql, self::CATALOG_MEM_LIFE);
            $DB->setTimeout();
            if($error || !$frls)
                return NULL;

            if(!$prof_id && !$offset && !$memBuff->getBWasMqUsed()) {
                professions::RecalcCatalogPositions();
            }
                
            $DB->setTimeout(90);
            $count_arr = $memBuff->getSql($error, $countSql, self::CATALOG_MEM_LIFE);
            $DB->setTimeout();
            $count = $count_arr[0]['count'];
            $size = sizeof($frls);

            if($prof_id && !$memBuff->getSqlBWasMqUsed && !$filter_where)
                professions::UpdateProfessionCount($or_prof, $count, $count_arr[0]['payed']);

                
        } else {
            $DB->setTimeout(90);
            $frls  = $DB->rows($sql);
            $DB->setTimeout();
            $error = $DB->error;
            
            if($error || !$frls)
                return NULL;
                
            $DB->setTimeout(90);
            $count_arr = $DB->rows($countSql);//$memBuff->getSql($error, $countSql, 1800);
            $DB->setTimeout();
            $count = $count_arr[0]['count'];
            $size = sizeof($frls);    
            
            //@todo: ��� ������� �� ����������� �����?
            if($prof_id && !$filter_where)
                professions::UpdateProfessionCount($or_prof, $count, $count_arr[0]['payed']);
        }
        
        foreach($frls as $row)
            $frl_ids[] = $row['uid'];
        $join_blocked  = ' LEFT JOIN portfolio_blocked pb ON p.id = pb.src_id ';
        $where_blocked = ' AND pb.src_id IS NULL ';

        $sql = "SELECT p.id, p.user_id, p.name, p.descr, p.pict, p.prev_pict, p.show_preview, p.norder, p.prev_type, p.is_video
               FROM portfolio p
             INNER JOIN
               portf_choise pc
                 ON pc.user_id = p.user_id
                AND pc.prof_id = p.prof_id 
             ".( $prof_id ? '' : 'INNER JOIN freelancer f ON f.uid = p.user_id' )."
             $join_blocked 
              WHERE p.user_id IN (".implode(',', $frl_ids).")
        ";

        if ($specs_list) {
            $sql .= " AND $specs_list";
        }
        else {
            $sql .= " AND p.prof_id = ".($prof_id ? "'{$or_prof}'" : 'f.spec_orig');            
        }

        $sql .= " AND p.first3 = true  $where_blocked ORDER BY p.user_id, p.norder";

        if(!$filter_where) {
            if($ret = $memBuff->getSql($error, $sql, 600, true)) {
                foreach ($ret as $row)
                    $works[$row['user_id']][] = $row;
            }
        } else {

            $ret  = $DB->rows($sql);
            
            if($ret) {
                foreach ($ret as $row) $works[$row['user_id']][] = $row;    
            }
        }

        return $frls;
    }

    /**
     * ������ SQL-������� �� ��������� ���������� ����������� � ����� ��������.
     * 
     * @param string $filter_where   sql-�������, �������������� �������� freelancer::_createMainCountSql()
     * @param string $filter_join   sql-������� (���. ������), �������������� �������� freelancer::_createMainCountSql()
     * @return string 
     */
    function _createMainCountSql($filter_where, $filter_join, $join_add_spec = '') 
    {
        $fu_table = self::$fu_table;

        $sql =
        "SELECT COUNT(DISTINCT(s.uid)) as count
           FROM {$fu_table} s
        {$join_add_spec}
         {$filter_join}
          WHERE s.is_banned = '0' {$filter_where}";
        return $sql;
    }

    /**
     * ���������� ���������� ������ � ����� ��������, ��������������� ��������� �������
     * @see freelancer::_createMainCountSql()
     * @see externalApi_Hh::x____getFrlCount()
     * 
     * @param array $filter   ������
     * @return integer 
     */
    function getFrlCount($filter) {
        global $DB;
        $fprms = self::createCatalogFilterSql($filter);
        if($fprms==-1) {
            return 0;
        }
        
        list($filter_where, $filter_join) = $fprms;
        if($filter_where)
            $filter_where = ' AND '.$filter_where;
        $sql = self::_createMainCountSql($filter_where, $filter_join);
        $ret = $DB->val($sql);
        return ($ret?$ret:0);
    }

  /**
   * ������� ��������� ����� ����� ���� ����������� � ������������ �������������.
   * @param    integer   $prof_id   id �������������
   * @param    boolean   $is_text   ���� ������������� ������� � �������, �.�. ����� ��������� 
   *                                �� ��������� �� ������, � ��������� �� ���-�� ��������, �� TRUE, ����� FALSE
   * @return   array                ������ � �����������, � �������: �������: month, hour, projects; 
   *                                �������� - ������� ��������� �� �����, ��� � ������ ��������������
   */
  function getAvgCost($prof_id, $is_text = false) 
  {
    $cost = NULL;
    $memBuff = new memBuff();
    require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/professions.php");
    $spec_orig = professions::GetProfessionOrigin($prof_id);
    $prj_cost = $is_text ? 'cost_1000' : 'cost_from';

    $sql = 
    "SELECT param, AVG(p.value/ex.val)::decimal(8,2) as value
       FROM
       (
         SELECT uid FROM fu WHERE spec_orig = {$spec_orig} AND is_banned = '0'
         UNION ALL
         SELECT fu.uid
           FROM fu
         INNER JOIN
           spec_add_choise sp
             ON sp.user_id = fu.uid
            AND sp.prof_id = {$spec_orig}
          WHERE fu.is_pro = true
            AND fu.is_banned = '0'
         UNION ALL
         SELECT fu.uid
           FROM fu
         INNER JOIN
           spec_paid_choise pc
             ON pc.user_id = fu.uid
            AND pc.prof_id = {$spec_orig} AND pc.paid_to > NOW()
          WHERE fu.is_banned = '0'
       ) as s 
     INNER JOIN
       (
         SELECT 'month' as param, uid, cost_month as value, cost_type_month as param_type FROM fu WHERE COALESCE(cost_month,0) > 0 UNION ALL
         SELECT 'hour', user_id, cost_hour, cost_type_hour FROM portf_choise WHERE COALESCE(cost_hour,0) > 0 AND prof_id = {$spec_orig} UNION ALL
         SELECT 'project', user_id, {$prj_cost}, cost_type FROM portf_choise WHERE COALESCE({$prj_cost},0) > 0 AND prof_id = {$spec_orig}
       ) as p
         ON p.uid = s.uid
     INNER JOIN
       project_exrates ex
         ON ex.id = COALESCE(22*(0 = p.param_type)::int +
                             23*(1 = p.param_type)::int +
                             24*(2 = p.param_type)::int +
                             21*(3 = p.param_type)::int, 22)

      GROUP BY param";

    if($rows = $memBuff->getSql($error, $sql, 1800)) {
      foreach($rows as $r)
        $cost[$r['param']] = $r['value'];
    }

    return $cost;
  }


  /**
   * ���������� �����������, ������� ��������� �� ����������� � ����� ��������.
   * @param    string    $error      ���������� ��������� ������
   * @param    integer   $page       ����� �������� � ������� ������ ����� (� ������ �������� $offset �������������)
   * @param    integer   $offset     ���������� �������������, ������� ���������� ��������
   * @param    array     $exclude_users      �������������� �������������, ������� ��� ���������� �������� � ����� ��������
   * @return   array                 ������ � ���������� �������������
   */
  function GetPrjRecps(&$error, $page, $offset = 1000, $exclude_users = array()) {
    global $DB;
    
    // > ���� mailer ��� ����� ���� ��������� pow(2, id �������������)
    // �����? ������ ������������ ��� 1/0 ���������� ��������
    
    $exclude = "";
    if ( count($exclude_users) ) {
        $exclude = "AND f.uid NOT IN (" . join(",", $exclude_users) . ")";
    }
    
    $from = $offset;
    $to = ($page-1)*$offset;
    
        //@todo: EXTRACT ���������
	$sql = "SELECT 
                    --EXTRACT(YEAR FROM f.reg_date) AS reg_date_year,
                    --EXTRACT(DAY FROM NOW() - f.reg_date) AS reg_days_ago,
                    --DATE_PART('year', NOW()) - DATE_PART('year', f.last_time) AS last_years_ago,
                    f.reg_date, 
                    f.last_time, 
                    f.uname, 
                    f.usurname, 
                    f.login, 
                    f.email, 
                    f.mailer, 
                    f.mailer_str, 
                    usk.key AS unsubscribe_key, 
                    f.uid 
                FROM freelancer AS f 
                LEFT JOIN users_subscribe_keys AS usk ON f.uid = usk.uid 
                WHERE 
                    mailer > 0  
                    AND is_banned = '0' {$exclude} 
                ORDER BY f.uid 
                LIMIT {$from} OFFSET {$to}";
                    
     //@todo: mrows ��������� ��� rows!    
     //$ret = $DB->mrows($sql, $offset, ($page-1)*$offset);
     
     //@todo: � �������� ����� ��� �������
     $res = $DB->query($sql);          
     $ret = pg_fetch_all($res);   
                    
     $error = $DB->error;
     
        
     return $ret;
  }

        
  
  
  /**
   * ���������� ������ ����������
   * �� ����� �������
   * 
   * @global object $DB
   * @param int $uid
   * @return array
   */
  public static function GetPrjRecp($uid){
      global $DB;

      $row = $DB->row("
          SELECT 
            f.reg_date, 
            f.last_time, 
            f.uname, 
            f.usurname, 
            f.login, 
            f.email, 
            f.mailer, 
            f.mailer_str, 
            usk.key AS unsubscribe_key, 
            f.uid 
         FROM freelancer AS f 
         LEFT JOIN users_subscribe_keys AS usk ON f.uid = usk.uid 
         WHERE 
            f.mailer > 0 
            AND f.is_banned = '0' 
            AND f.uid = ?i 
         LIMIT 1",$uid);
      
      if ($row && !$row['unsubscribe_key']) {
          $row['unsubscribe_key'] = users::GetUnsubscribeKey($row['login']);
      }
      
      return $row;
  }










  /**
	 * ����������� ������ � ��������� ������������.
	 * @param     integer   $fid                   uid ������������
	 * @param     boolean   $newmsgs               ����������� � ����� ���������� � "��� ��������"
	 * @param     boolean   $vacan                 ���������� � ����� ��������?
	 * @param     boolean   $comments              ����������� � ����������/������������ � ������
	 * @param     boolean   $opin                  ����������� � ����������/�������� ������
	 * @param     boolean   $prcomments            ����������� � ����������/������������ � ��������
	 * @param     boolean   $commune_subscr        ����������� � ����� ��������� � �����������
	 * @param     boolean   $commune_top_subscr    ����������� � ����� ����� � �����������
	 * @param     boolean   $adm_subscr            ������� �� ������� Free-lance.ru
	 * @param     boolean   $content_subscr        ����������� � ���������
	 * @param     boolean   $defilecomments        ����������� � ������/������������ � ������
	 * @param     boolean   $articlescomments      ����������� � ������� "������/��������"
	 * @param     boolean   $massending            ������� ��������
	 * @param     integer   $shop                  ����������� � ������ � ��������
	 * @param     integer   $daily_news           ����������� � ������� �������������
     * @param     boolean   $vacan_use             ��������� �� �������� ����������� �������� � ����� ��������
     * @param     boolean   $payment               ����������� � ��������
	 * @return    string                           ��������� ������
	 */
	function UpdateSubscr( $fid, $newmsgs, $vacan, $comments, $opin, $prcomments, $commune_subscr, $commune_top_subscr, $adm_subscr, $contest_subscr, $team, $defilecomments, $articlescomments, $massending, $shop, $daily_news, $vacan_use = true, $payment) {
        $this->mailer = $vacan_use ? 1 : 0;
        $this->mailer_str = '';
        $cats = array();
        foreach ($vacan as $val){
            $cats[] = 'c'.(int)$val['category_id'].($val['subcategory_id'] ? 's'.(int)$val['subcategory_id'] : '');
        }
        $this->mailer_str = implode(':', $cats);
        
        //@todo: ��������� ��������� �������� ���� ���� �� ������� ������ ���������
        //if(!$this->mailer_str) {
        //    $this->mailer = 0;
        //}
        
	    if ($this->mailer) $proj = 1; else $proj = 0;
        $this->subscr = (int)$newmsgs.$proj.(int)$comments.(int)$opin.(int)$prcomments.(int)$commune_subscr.(int)$commune_top_subscr.(int)$adm_subscr.(int)$contest_subscr.(int)$team.(int)$defilecomments.(int)$articlescomments.(int)$massending.(int)$shop.(int)$daily_news.(int)$payment;
        while (strlen($this->subscr) < $GLOBALS['subscrsize'])
			$this->subscr .= '0';
		$error = parent::Update($fid, $res);
		return ($error);
	}

        /**
         * ������, �������� �� ��������� �� ������ ������
         *
         * @param string $mailer_str
         * @param array $project
         * @return boolean
         */
        public static function isSubmited($mailer_str, $cats) {
            $filters = strlen($mailer_str) ? explode(':', $mailer_str) : array();
            foreach ($filters as $filter) {
                if(!preg_match('/c(\d+)(?:s(\d+))?/i', $filter, $pars)) continue;
                foreach ($cats as $cat) {
                    if($cat['category_id'] == $pars[1]) { // �������� �� ������ ������ (���� �� �� ���� �������������).
                        if(!$pars[2] || !isset($cat['subcategory_id']) || is_null($cat['subcategory_id']) || $pars[2] == $cat['subcategory_id']) { // ������� "��� �������������" ���� �������� �� ���������� �������������.
                            return true;
                        }
                    }
                }
            }
            return false;
        }

	/**
	 * ���������� ���������� ����������� � ������ �� ���������.
	 * @return   array     ������, � �������: ������ - id ���������; �������� - ���-�� �����������. ������ -1 - ����� �����������
	 */
	function CountUsersInProfessions(){
        global $DB;
		$sql = "(SELECT (-1) as prof_group, COUNT(*) as grcount FROM freelancer WHERE is_banned='0') UNION ALL (SELECT prof_group, SUM(count) FROM professions LEFT JOIN (SELECT prof_id, COUNT(*) as count FROM (SELECT user_id, prof_id FROM portfolio LEFT JOIN users ON uid=user_id WHERE is_banned='0' ) as t GROUP BY (t.prof_id)) as r ON r.prof_id=professions.id GROUP BY prof_group)";
		$ret = $DB->rows($sql);
		if ($ret) foreach($ret as $ikey=>$val) $out[$val['prof_group']] = $val['grcount'];
		return $out;
	}

	/**
	 * ���������� � �������� ���������� � ���-�� ����� �� ��� ��������.
	 * @param    string   $login   login ����������
	 * @param    string   $err     ���������� ��������� ������
	 * @return   array             ������ � �������
	 */
	function GetAdditInfo($login, &$err){
        global $DB;
		if ($login){
      $sql = "SELECT hits, rating_get(rating, is_pro, is_verify, is_profi) as rating, hitstoday FROM freelancer WHERE login=?";
            $ret = $DB->row($sql, $login);
			$err .= $DB->error;
		}
		return $ret;
	}

	/**
	 * ������ ������� ��������� ����������
	 * @param   integer   $status   id �������
	 * @return  string              ������ �������
	 */
	function statusToStr($status){
		$stats = array("��������", "�����", "����������",-1=>"������ �� ������");
		return (isset($stats[$status]))?$stats[$status]:false;
	}

	/**
	 * ���������� HTML ������������ ������ ��������� ����������
	 * @param   integer   $status   id �������
	 * @param   boolean   $full     ���� TRUE, �� ����� �������� ������� ��� � ����� �� ��������
	 * @return  string              HTML
	 */
	function viewStatus($status, $full = false){
	  switch ($status)
	  {
	    case -1:
  	    $res = "";
  	    break;
	    case 0:
  	    $res = ($full ? "<span class='u-free'>��������</span>" : "<img src=\"/images/dot_free.gif\" class=\"dot_status\" alt=\"��������\" title=\"��������\" border=\"0\">");
  	    break;
	    case 1:
  	    $res = ($full ? "<span class='u-busy'>�����</span>" : "<img src=\"/images/dot_busy.gif\" class=\"dot_status\" alt=\"�����\" title=\"�����\" border=\"0\">");
	    //$res = "<img src=\"/images/dot_busy.gif\" class=\"dot_status\" alt=\"�����\" title=\"�����\" border=\"0\">" . ($full ? "<span class='u_busy'>�����</span>" : "");
  	    break;
	    case 2:
  	    $res = ($full ? "<span class='u-busy'>����������</span>" : "<img src=\"/images/dot_busy.gif\" class=\"dot_status\" alt=\"����������\" title=\"����������\" border=\"0\">");
	    //$res = "<img src=\"/images/dot_busy.gif\" class=\"dot_status\" alt=\"����������\" title=\"����������\" border=\"0\">" . ($full ? "<span class='u_absent'>����������</span>" : "");
  	    break;
	  }
		return $res;
	}

	/**
	 * ��������� "�����������" ���������� - ���������� � ���������, ���� ��� �� ������ � ��������, ���� ��� ������.
	 *
	 * @param    integer   $frl_id   ��� ����������
	 * @param    integer   $prof_id  ��� ���������
	 * @param    integer   $uid      ��� �����
	 * @return   array               ��������� (0-�� �������: ���������� ��������� ������) � ��� ���������� �������� (1-�� �������: 0 - ������, 1 - ��������)
	 */
    function ChangeFav($frl_id, $prof_id, $uid)
    {
    global $DB;
	if ($frl_id != $uid)
    {
      require_once $_SERVER['DOCUMENT_ROOT'].'/classes/teams.php';
      $teams = new teams;
	  $ret = array(0, 0);
      if (!$teams->teamsIsInFavorites($uid, $frl_id))
      {
        if ($prof_id > 0)
        {
      		require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/professions.php");
      		$mirrored = professions::GetMirroredProfs($prof_id);
      		$profs = "'" . implode("', '", $mirrored) . "'";
			$teams->teamsAddFavorites($uid, $frl_id, false);
			$m = $teams->teamsFavorites($uid, $error);
			$myteam = array();
			for ($i=0; $i<count($m); $i++) {
				$myteam[] = $m[$i]['uid'];
			}
			if ($myteam) {
				//$DB->debug = '/var/tmp/DB.log';
				$sql = "SELECT COUNT(*) FROM portf_choise WHERE user_id IN (".implode(',', $myteam).") AND prof_id IN ({$profs})";
				$ret[0] = $DB->val($sql);
				//$DB->debug = '';
			}
        }
        else
        {
			$teams->teamsAddFavorites($uid, $frl_id, false);
			$ret[0] = $teams->teamsFavoritesCount($uid, $error);
        }
		$ret[1] = 1;
      }
      else
      {
        if ($prof_id > 0)
        {
      		require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/professions.php");
      		$mirrored = professions::GetMirroredProfs($prof_id);
      		$profs = "'" . implode("', '", $mirrored) . "'";
			$teams->user_id = $uid;
			$teams->target_id = $frl_id;
			$teams->teamsDelFavorites();
			$m = $teams->teamsFavorites($uid, $error);
			$myteam = array();
			for ($i=0; $i<count($m); $i++) {
				$myteam[] = $m[$i]['uid'];
			}
			if ($myteam) {
				$sql = "SELECT COUNT(*) FROM portf_choise WHERE user_id IN (".implode(',', $myteam).") AND prof_id IN ({$profs})";
				$ret[0] = $DB->val($sql);
			}
        }
        else
        {
			$teams->user_id = $uid;
			$teams->target_id = $frl_id;
			$teams->teamsDelFavorites();
			$ret[0] = $teams->teamsFavoritesCount($uid, $error);
        }
		return $ret;
      }
    }
    else // ����� ��� ���������� ������ ��������� ���� �� ������, �� �� ������ ������...
    {
      $ret[0] = $teams->teamsFavoritesCount($uid, $error);
    }
    return $ret;
  }

  /**
   * ���������� ������ ��������� �����������.
   *
   * @param   integer   $prof_id        id ��������� (�� ������������, ������ ��������� ��� �������������)
   * @param   integer   $uid            id ������������
   * @param   boolean   $filter_apply   ������������ ������? (�������� �� ������������)
   * @param   array     $filter         ������ � ������� ��� ������� (�������� �� ������������)
   * @return  array                     ������ ��������� ����������� (id ����������)
   */
  function GetFavorites($prof_id, $uid, $filter_apply = false, $filter = null)
  {
    require_once $_SERVER['DOCUMENT_ROOT'].'/classes/teams.php';
	$teams = new teams;
	$ret = $teams->teamsFavorites($uid, $error);

/*
    if ($prof_id > 0)
    {
   		require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/professions.php");
  		$mirrored = professions::GetMirroredProfs($prof_id);
  		$profs = "'" . implode("', '", $mirrored) . "'";
      $sql = "SELECT ff.target_id FROM teams AS ff INNER JOIN portf_choise as pc ON (ff.target_id = pc.user_id) WHERE pc.prof_id IN ($profs) AND ff.user_id='$uid'";
    }
    else
    {
      $sql = "SELECT ff.target_id FROM teams AS ff WHERE ff.user_id='$uid'";
    }
*/
    $out = array();
    if ($ret)
    {
      foreach($ret as $ikey => $value)
      {
        $out[] = $value['uid'];
      }
    }
    return $out;
  }

  /**
   * ���������� ���-�� ���� � PRO �����������
   * @param   integer   $all_count   ���������� ���������� ���� �����������
   * @param   integer   $pro_count   ���������� ���������� PRO �����������
   * @return  integer                ����� ����������
   */
  function GetAllCount(&$all_count, &$pro_count=NULL)
  {
    return self::GetMergeCountByProfs($all_count, $pro_count, 'ALL', NULL);
  }

  
  /**
   * ���������� ���������� ���� � PRO ����������� �� ��������� ����������
   * @param   integer          $all_count   ���������� ���������� ���� �����������
   * @param   integer          $pro_count   ���������� ���������� ���� PRO-�����������
   * @param   string           $all_profs   ���� NULL, �� $pro_profs ������ ���� �� NULL, ��� ��������, ��� ����� ������� ������ ���-����������.
   *                                        ���� 'ALL', �� $pro_profs ������������ � �������� ���������� (�� ���� ���� � ��� �� ���)
   *                                        ���� ������ ���������� �� �� �������������, �������, ����� ��� �����-�� ������� (�� ������ ��������) �������������� � ��������.
   * @param   integer|string   $all_profs   ������ ��������� (���� ������, �� ������ ���� ������ ����������� ��������), �� ������� ����� ����� ������ ��� ������
   * @return  integer                       ����� ����������
   */
  function GetMergeCountByProfs(&$all_count, &$pro_count, $all_profs=NULL, $pro_profs=NULL)
  {
    global $DB;
    require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/professions.php");

    $all_count = 0;
    $pro_count = 0;

    if(!$all_profs && !$pro_profs)
      return 0;

    if($all_profs=='ALL') $pro_profs=NULL;

    if($all_profs && $all_profs!='ALL')
      $all_profs = professions::GetProfessionOrigin($all_profs);
    if($pro_profs && $pro_profs!='ALL')
      $pro_profs = professions::GetProfessionOrigin($pro_profs);


    if($all_profs=='ALL' || $pro_profs=='ALL') {
      $sql =
      "SELECT COUNT(fu.uid) as count,
              SUM((fu.is_pro IS TRUE)::int) as pro_count
         FROM fu
       INNER JOIN
         portf_choise pc
           ON pc.user_id = fu.uid
          AND pc.prof_id = fu.spec_orig".
        ($pro_profs=='ALL' ? ' WHERE fu.is_pro = true' : '');
    }
    
    else {

      $sql = "
        SELECT
               COUNT(su.uid) as count,
               SUM((su.is_pro IS TRUE)::int) as pro_count
          FROM
          (".
            (
              !$all_profs
              ? ''
              : "SELECT ".(!$pro_profs ? 'DISTINCT' : '')." s.*
                   FROM
                   (
                     SELECT uid, is_pro FROM fu WHERE is_banned = '0' AND spec_orig IN ({$all_profs})
                     UNION ALL
                     SELECT fu.uid, fu.is_pro
                       FROM fu
                     INNER JOIN
                       spec_add_choise sp
                         ON sp.user_id = fu.uid
                        AND sp.prof_id IN ({$all_profs})
                      WHERE fu.is_pro = true
                        AND fu.is_banned = '0'
                     UNION ALL
                     SELECT fu.uid, fu.is_pro
                       FROM fu
                     INNER JOIN
                       spec_paid_choise pc
                         ON pc.user_id = fu.uid
                        AND pc.prof_id IN ({$all_profs}) AND pc.paid_to > NOW()
                      WHERE fu.is_banned = '0'
                   ) as s".
                 (!$pro_profs ? '' : ' UNION ')
            ).
            (
              !$pro_profs
              ? ''
              : "SELECT ".(!$all_profs ? 'DISTINCT' : '')." s.*
                   FROM
                   (
                     SELECT uid, is_pro, is_team FROM fu WHERE is_pro=true AND is_banned = '0' AND spec_orig IN ({$pro_profs})
                     UNION ALL
                     SELECT fu.uid, fu.is_pro, fu.is_team
                       FROM fu
                     INNER JOIN
                       spec_add_choise sp
                         ON sp.user_id = fu.uid
                        AND sp.prof_id IN ({$pro_profs})
                      WHERE fu.is_pro = true
                        AND fu.is_banned = '0'
                     UNION ALL
                     SELECT fu.uid, fu.is_pro, fu.is_team
                       FROM fu
                     INNER JOIN
                       spec_paid_choise pc
                         ON pc.user_id = fu.uid
                        AND pc.prof_id IN ({$pro_profs}) AND pc.paid_to > NOW()
                      WHERE fu.is_banned = '0'
                   ) as s "
            )."
          ) as su";
    }

    $memBuff = new memBuff();
    $count_arr = $memBuff->getSql($error, $sql, 1800);

    if(!$error) {
      $all_count = $count_arr[0]['count'];
      $pro_count = $count_arr[0]['pro_count'];
      return 1;
    }

    return 0;
  }

  /**
   * �������� ���������� ���������� ��� ������ ���������: ������� ���� ������ �� �����, �� ������ ��� ������ ������, �� ���.
   * @return  integer  ����� ����������
   */
  function getAvgCostAll()
  {
        global $DB;
  		$sql = "

                INSERT INTO professions_stats_money (prof_id, cost_month, cost_project, cost_hour)

                SELECT m.spec_orig as prof_id,
                       sum((CASE WHEN m.param = 'month' THEN m.value ELSE 0 END)) as month,
                       sum((CASE WHEN m.param = 'project' THEN m.value ELSE 0 END)) as project,
                       sum((CASE WHEN m.param = 'hour' THEN m.value ELSE 0 END)) as hour
                FROM
                (

                   SELECT p.spec_orig, p.param, AVG(p.value/ex.val)::decimal(8,2) as value
                   FROM professions py

                   INNER JOIN professions px
                   ON px.id = COALESCE((SELECT main_prof FROM mirrored_professions WHERE mirror_prof = py.id), py.id)

                   INNER JOIN
                   (
                     SELECT fu.uid, spec_orig as spec FROM fu WHERE is_banned = '0' AND spec_orig > 0 
                     UNION ALL
                     SELECT fu.uid, sp.prof_id FROM fu INNER JOIN spec_add_choise sp ON sp.user_id = fu.uid WHERE fu.is_pro = true AND fu.is_banned = '0' AND sp.prof_id > 0
                     UNION ALL
                     SELECT fu.uid, spc.prof_id FROM fu INNER JOIN spec_paid_choise spc ON spc.user_id = fu.uid WHERE fu.is_banned = '0' AND spc.prof_id IS NOT NULL AND sp.paid_to > now()
                   ) as s 
                   ON px.id=s.spec

                   INNER JOIN
                   (
                     SELECT 'month' as param, uid, cost_month as value, cost_type_month as param_type, spec_orig FROM fu WHERE COALESCE(cost_month,0) > 0 AND spec_orig > 0 UNION ALL

                     SELECT 'hour', user_id, cost_hour as value, cost_type_hour as param_type, prof_id as spec_orig FROM portf_choise WHERE COALESCE(cost_hour,0) > 0 AND prof_id > 0 UNION ALL

                     SELECT 'project', user_id, (CASE WHEN professions.is_text = true THEN cost_1000 ELSE cost_from END) as value, cost_type as param_type, prof_id as spec_orig
                     FROM portf_choise
                     INNER JOIN professions ON professions.id = portf_choise.prof_id
                     WHERE COALESCE((CASE WHEN professions.is_text = true THEN cost_1000 ELSE cost_from END),0) > 0 AND prof_id > 0
                   ) as p
                   ON p.uid = s.uid AND (param = 'month' OR p.spec_orig=px.id)

                   INNER JOIN project_exrates ex
                   ON ex.id = COALESCE(22*(0 = p.param_type)::int +
                                      23*(1 = p.param_type)::int +
                                      24*(2 = p.param_type)::int +
                                      21*(3 = p.param_type)::int, 22)

                   WHERE py.id > 0
                   GROUP BY p.spec_orig, p.param

                ) m

                GROUP BY m.spec_orig

  		";

		$DB->query($sql);

		return 1;
  }
  
  
  
  /**
   * ��������� ������ ������������ � ����������� ����������
   * � ������ �������� � �������������� ���� ���
   * 
   * @global object $DB
   * @param type $uid
   * @param type $is_pro
   * @return type
   */
  public static function getAllSpecAndGroup($uid, $is_pro = false)
  {
      global $DB;
      
      if ($is_pro) {

        $sql = "
            SELECT 
              p.prof_group AS group,
              s.spec 
            FROM (
              SELECT spec FROM freelancer WHERE uid = ?i AND spec > 0
              UNION
              SELECT COALESCE(prof_origin, prof_id) AS spec FROM spec_add_choise WHERE user_id = ?i
            ) AS s
            INNER JOIN professions AS p ON p.id = s.spec
        ";
        
        $res = $DB->rows($sql, $uid, $uid);
        
      } else {
         
        $sql = "
            SELECT 
              p.prof_group AS group,
              s.spec 
            FROM freelancer AS s 
            INNER JOIN professions AS p ON p.id = s.spec
            WHERE s.uid = ?i AND s.spec > 0
            LIMIT 1
        ";    
        
        $res = $DB->rows($sql, $uid);
      }
      
      $result = array(
          //������ �������������
          'specs' => array(),
          //������ �����
          'groups' => array(),
          //����� ����� ������ > �������������
          'specs_tree' => array()
      );
      
      if ($res) {
          foreach ($res as $item) {
              $result['specs'][] = $item['spec'];
              $result['groups'][] = $item['group'];
              $result['specs_tree'][$item['group']][] = $item['spec'];
          }
          
          $result['specs'] = array_unique($result['specs']);
          $result['groups'] = array_unique($result['groups']);
      }
      
      return $result;
  }





  /**
   * @deprecated ��������. ������������� ������� �� getAllSpecAndGroup()
   * 
   * �������� ������ ���� ������������� ����� �� ������ ������
   * 
   * @param integer $uid	UID ����������
   * @return array 			������ ID �������������
   */
  function GetAllSpecs($uid){
        global $DB;
  		$out = array();
  		$sql = "SELECT spec FROM (
            SELECT 1 as main_spec, spec FROM freelancer WHERE uid = '".$uid."'
  			UNION 
  			SELECT 0, prof_id FROM spec_choise WHERE user_id = '".$uid."'
  			UNION 
  			SELECT 0, prof_id FROM spec_add_choise INNER JOIN freelancer ON freelancer.uid = spec_add_choise.user_id AND freelancer.is_pro = TRUE WHERE user_id = '".$uid."' 
  			UNION 
  			SELECT 0, prof_id FROM spec_paid_choise WHERE user_id = '".$uid."' AND paid_from < now() AND paid_to > now()
  			) as specs
            ORDER BY main_spec DESC;";
  		$res_arr = $DB->rows($sql);
  		if ($res_arr) foreach ($res_arr as $item){
  			if ($item['spec']) $out[] = $item['spec'];
  		}
  		return $out;
  }

  /**
   * ���������� ���� ��� �������� �� �������������?
   * 
   * !!!������ ������������� �� �����
   *
   * @param  int $category_id ID ������ ���������
   * @param  int $subcategory_id ID ���������
   * @return string
   */
  public static function drawSubscrFilterLine($category_id, $subcategory_id){
      require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/professions.php");
      $grp = professions::GetGroup($category_id,$error);
      $cat_name = $category_id ? $grp['name'] : '<em>��� �������</em>';
      $sub_name = $subcategory_id ? professions::GetProfName($subcategory_id) : '<em>��� ����������</em>';
    ob_start();
    ?>
    <tr>
           <th><?= $cat_name;?>
            <input type="hidden" name="cats[]" value="<?= (int)$category_id;?>"/>
            <input type="hidden" name="subcats[]" value="<?= (int)$subcategory_id;?>"/>
           </th>
           <td><?= $sub_name;?></td>
           <td><a href="javascript:void(0)" onclick="document.getElementById('filter_body').removeChild(this.parentNode.parentNode)"><img src="/images/btn-remove2.png" alt="�������"></a></td>
    </tr>
                                    <?
     $html = ob_get_contents();
     ob_clean();
     return $html;
  }

  /**
   * ������������ �� �������
   *
   * @param integer $uid
   * @param integer $pid
   */
  public static function Refuse($uid,$pid){
      global $DB;
        $sql = "UPDATE projects_offers SET frl_refused = true WHERE user_id = ?i AND project_id = ?i RETURNING frl_refused";
        $ref = $DB->val($sql, $uid, $pid);
        if (!$DB->error) {
            // ������� id ������������ � ������� ���������� ��������������� ������� � ��������
            $sql = "SELECT p.user_id 
                    FROM projects p
                    WHERE p.id = ?i";
            $emp_id = $DB->val($sql, $pid);
            $mem = new memBuff();
            $mem->delete('prjEventsCnt' . $emp_id);
        }
        return $ref;
  }
  
  /**
   * ���������� ���� ��� ��������� ��������� ���� ��� ������� � ����� �������� ������� � �������� �����
   * 
   * @param  bool $random �����������. ���������� � true ���� ����� �������� ���� ��������� �����
   * @return string|array ������ ���� ����� ��� ���� ������ ���� � ����������� �� $random
   */
  public static function GetSearchStringExample($random = true){
      $examples = array(
        '��������� ��������',
        '������ ����������',
        '�����������',
        '����-��������',
        '�����������',
        '������������� ������',
        '������� ��� ���',
        '����������� ������',
        '��������� �����������',
        '���������� ���',
        '������ ��� �����������',
        '�������������� �������',
        '������ �����',
        '����-������',
        '��������-�������');
      return $random ? $examples[mt_rand(0,count($examples)-1)] : $examples;
  }
  
  /**
   * ���������� �������� �� ������� ��������� ������������ ������ �� ��� �������
   *
   * @param integer $pos         ������� ������������
   * @param integer $count_pages ������������� �� 1 ��������
   * @return string �������� ������������
   */
  public function getPositionToPage($pos, $count_pages=false) {
      global $user;

      if(!$count_pages) $count_pages = FRL_PP;
      
      $page = ceil($pos/$count_pages);
      
      $params = array();

      if ($page>1) {
        $params[] = "page={$page}";
      }

      return $params?'?'.join('&', $params):'';
  }

    /**
     * ������� xml ���� webprof
     * 
     * @return text $filename ������ ���� � ����� ���� webdav ������ ��������� ������������ xml
     */
    public function webprofGenerateRss($filename) {
        global $DB, $GLOBALS;

        require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/professions.php");
        require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/kwords.php");

        function getProfessionName($id, $professions) {
            foreach($professions as $profession) {
                if($profession['id']==$id) {
                    return "{$profession['groupname']} / {$profession['profname']}";
                }
            }
        }

        $spec = array(9, 37, 27, 86, 8, 164, 10);

        $users = self::getListForWebprof($spec);
        $professions = professions::GetAllProfessions();

        $xml  = '';
        $host = str_replace(HTTP_PREFIX, '', $GLOBALS['host']);
        $HTTP_PREFIX = "https://"; 
        $XMLData = '';

        $xml .= '<?xml version="1.0" encoding="utf-8"?>'."\n";
        $xml .= '<!DOCTYPE source>'."\n";
        $xml .= '<source creation-time="'.date('Y-m-d H:i:s').' GMT+3" host="'.$host.'">'."\n";
        $xml .= '   <users>'."\n";

        if ( is_array($users) && count($users) ) { 
            $XMLData = '';
            foreach ( $users as $user ) {
                $frl_name = trim("{$user['uname']} {$user['usurname']}");
                $frl_name = iconv( 'CP1251', 'UTF-8', htmlspecialchars($frl_name, ENT_QUOTES) );
                $frl_spec_main = iconv( 'CP1251', 'UTF-8', htmlspecialchars(getProfessionName($user['spec'], $professions), ENT_QUOTES) );

                switch($user['status_type']) {
                    case '0':
                        $frl_status = 'free';
                        break;
                    case '1':
                        $frl_status = 'busy';
                        break;
                    case '2':
                        $frl_status = 'absent';
                        break;
                    default:
                        $frl_status = 'no status';
                        break;
                }

                $frl_spec_ext = '';
                $spec_ext_ids = professions::GetProfsAddSpec($user['uid']);
                if($spec_ext_ids) {
                    foreach($spec_ext_ids as $spec_id) {
                        $frl_spec_ext .= "<spec>".iconv( 'CP1251', 'UTF-8', htmlspecialchars(getProfessionName($spec_id, $professions), ENT_QUOTES) )."</spec>";
                    }
                }

                $frl_tags = '';
                $tags = kwords::getUserKeys($user['uid'], $user['spec']);
                $bIsModer = kwords::isModerUserKeys( $user['uid'], $user['spec'] );
                if ( $tags && !$bIsModer ) {
                    foreach($tags as $tag) {
                        $frl_tags .= "<tag>".iconv( 'CP1251', 'UTF-8', htmlspecialchars($tag, ENT_QUOTES) )."</tag>";
                    }
                }

                $frl_cost_hour = '';
                $frl_cost_month = '';

                if($user['cost_hour']!=0) {
                    $frl_cost_hour = (float) $user['cost_hour'];
                    switch($user['cost_type_hour']) {
                        case '1':
                            $frl_cost_hour .= " Euro";
                            break;
                        case '2':
                            $frl_cost_hour .= " ���";
                            break;
                        case '3':
                            $frl_cost_hour .= " FM";
                            break;
                        default:
                            $frl_cost_hour .= " USD";
                            break;
                    }
                    $frl_cost_hour = iconv( 'CP1251', 'UTF-8', $frl_cost_hour );
                }

                if($user['cost_month']!=0) {
                    $frl_cost_month = (float) $user['cost_month'];
                    switch($user['cost_type_month']) {
                        case '1':
                            $frl_cost_month .= " Euro";
                            break;
                        case '2':
                            $frl_cost_month .= " ���";
                            break;
                        case '3':
                            $frl_cost_month .= " FM";
                            break;
                        default:
                            $frl_cost_month .= " USD";
                            break;
                    }
                    $frl_cost_month = iconv( 'CP1251', 'UTF-8', $frl_cost_month );
                }

                $XMLData .= "<user>";
                $XMLData .= "<name>{$frl_name}</name>";
                $XMLData .= "<spec_main>{$frl_spec_main}</spec_main>";
                $XMLData .= "<spec_ext>{$frl_spec_ext}</spec_ext>";
                $XMLData .= "<status>{$frl_status}</status>";
                $XMLData .= "<rating>{$user['rating']}</rating>";
                $XMLData .= "<cost_from_hour>{$frl_cost_hour}</cost_from_hour>";
                $XMLData .= "<cost_from_month>{$frl_cost_month}</cost_from_month>";
                $XMLData .= "<url>".$HTTP_PREFIX."{$host}/users/{$user['login']}</url>";
                $XMLData .= "<tags>{$frl_tags}</tags>";
                $XMLData .= "</user>\n";
            }
        }

        $xml .= $XMLData."\n";
        $xml .= '   </users>'."\n";
        $xml .= '</source>'."\n";

        $file = new CFile;
        return $file->putContent($filename, $xml);
    }
    
    /**
     * ������� 3 ��������� ���������� � �������, ��������� �������
     * 
     * @global object $DB   ����������� � ��
     * @param array $specs ����� ��������������� ����������
     * @return boolean|array ������ �����������
     */
    function getFreelancersPromoForProjects($specs) {
        global $DB;
        
        if(count($specs) <= 0) return false;
        $specs = implode(", ", $specs);
        $sql = "SELECT fu.uname, fu.usurname, fu.login, fu.is_pro, fu.is_team, fu.role, fu.photo, fu.uid, uc.sbr_opi_null, uc.sbr_opi_plus, uc.sbr_opi_minus,
                    (uc.ops_emp_null + uc.ops_frl_null + uc.sbr_opi_null) as total_opi_null,
                    (uc.ops_emp_minus + uc.ops_frl_minus + uc.sbr_opi_minus) as total_opi_minus,
                    (uc.paid_advices_cnt + uc.ops_emp_plus + uc.ops_frl_plus + uc.sbr_opi_plus) as total_opi_plus,
                    (uc.ops_emp_null + uc.sbr_opi_null) as emp_opi_null,
                    (uc.ops_emp_minus + uc.sbr_opi_minus) as emp_opi_minus,
                    (uc.ops_emp_plus + uc.sbr_opi_plus) as emp_opi_plus
                FROM fu 
                LEFT JOIN users_counters uc ON uc.user_id = fu.uid
                WHERE 
                    (fu.status_type = -1 OR fu.status_type = 0) AND 
                    fu.is_banned = B'0' AND fu.is_pro = true AND fu.spec_orig IN ({$specs}) 
                ORDER BY RANDOM() LIMIT 20;";
                    
        $result = $DB->cache(300)->rows($sql);
        
        if($result) {
            if(count($result) > 3) {
                //�������� ����������� ������ 3 ����������� �� �������
                $rnd = array_rand($result, 3);
                return array($result[$rnd[0]], $result[$rnd[1]], $result[$rnd[2]]);
            } else {
                return $result;
            }
        } else {
            return false;
        }
    }
    
    /**
     * ��� ������������� �����������
     * 
     * @global object $DB
     * @param integer $size ���������� ����������� � ������
     * @return type
     */
    public static function getTopFreelancer($size = 6) {
        global $DB;
        
        $sql = "SELECT 
                    f.uname, f.usurname, f.login, f.is_pro, f.is_team, f.photo, f.uid,
                    uc.sbr_opi_plus, uc.sbr_opi_null, uc.sbr_opi_minus
                FROM users_counters uc 
                INNER JOIN freelancer f ON uc.user_id = f.uid
                ORDER BY uc.sbr_opi_plus DESC, uc.sbr_opi_null DESC, uc.sbr_opi_minus ASC
                LIMIT ?i";
        
        return $DB->rows($sql, $size);
    }   
    
    /**
     * ����� ����������� �� �� ������
     * 
     * @global object $DB
     * @param array $logins
     * @return type
     */
    public static function getFreelancerByLogin($logins) {
        global $DB;
        
        $logins = array_map('strtolower', $logins);
        $sql = "SELECT f.uname, f.usurname, f.login, f.is_pro, f.is_team, f.photo, f.uid, f.spec FROM freelancer f
                WHERE lower(login) IN (?l)";
        
        $res = $DB->rows($sql, $logins);
        return $res;
    }
    /**
   * ���������� �����������, ������� ����������� �� ����� ������ ����� � ������ ��������.
   * @param    string    $error      ���������� ��������� ������
   * @param    integer   $page       ����� �������� � ������� ������ ����� (� ������ �������� $offset �������������)
   * @param    integer   $offset     ���������� �������������, ������� ���������� ��������
   * @return   array                 ������ � ���������� �������������
   */
  function GetMissingMoreThan24h(&$error, $page, $offset = 1000) {
    global $DB;
    $debug = '';
    if ( $_GET["debug"] == 1 ) {
        $debug = " AND f.email IN ('jusoft@yandex.ru', 'lamzin.a.n@rambler.ru', 'lamzin80@mail.ru') ";
    }
    $sql = "SELECT f.uname, f.usurname, f.login, f.email, f.spec,
                   usk.key AS unsubscribe_key, f.uid, f.is_pro, f.is_verify, 
                   substring(subscr from 2 for 1)::integer = 1  AS subscr_new_prj,
                   (add_spec.additional_specs || ',' || COALESCE(p_spec.paid_specs, '')) AS additional_specs
            FROM freelancer AS f 
            LEFT JOIN users_subscribe_keys AS usk ON f.uid = usk.uid

            LEFT JOIN ( SELECT array_to_string(array_agg(sa.prof_id), ','::text)  AS additional_specs, sa.user_id AS uid
                FROM spec_add_choise AS sa
                GROUP BY sa.user_id) AS add_spec ON add_spec.uid = f.uid

            LEFT JOIN ( SELECT array_to_string(array_agg(sp.prof_id), ','::text)  AS paid_specs, sp.user_id AS uid
                FROM spec_paid_choise AS sp
                WHERE paid_to > now()
                GROUP BY sp.user_id) AS p_spec ON p_spec.uid = f.uid
            
            WHERE  substring(subscr from 15 for 1)::integer = 1
            AND is_banned = '0' AND last_time < now() - '24 hours'::interval AND last_time > now() - '6 months'::interval {$debug} ORDER BY f.uid LIMIT ?i OFFSET ?i";
        $ret = $DB->mrows($sql, $offset, ($page-1)*$offset);
        $error = $DB->error;
        return $ret;
    }
      
    
    
    /**
     * SQL ������ ������� ����� �������������
     * 
     * @param type $limit
     * @return type
     */
    function getProfiAllSql($limit = 39)
    {
        $sql = "
            SELECT 
                p.name as profname,
                s.photo,
                s.login,
                s.uname,
                s.usurname,                
                s.status_text
            FROM freelancer AS s 
            LEFT JOIN professions AS p ON p.id = s.spec
            WHERE s.is_active AND s.is_profi AND s.is_banned = '0' 
            LIMIT {$limit}
        "; 
       
        return $sql;
    }

    
    /**
     * �������� � ��������� ������� ����� ������������� ������ �� ����
     * 
     * @param type $limit
     * @return type
     */
    function getProfiAllRandomFromCache($limit = 39)
    {
        $sql = $this->getProfiAllSql($limit);
        $memBuff = new memBuff();
        $frls = $memBuff->get(md5($sql));
        shuffle($frls);
        return $frls;
    }
    
    
    /**
     * �������� � ��������� ������� ����� �������������
     * 
     * @param type $limit
     * @return null
     */
    function getProfiAllRandom($limit = 39)
    {
        $error = null;
        $sql = $this->getProfiAllSql($limit);
        
        $memBuff = new memBuff();
        $frls = $memBuff->getSql(
                $error, 
                $sql, 
                self::CATALOG_PROFI_MEM_LIFE, 
                true,
                self::CATALOG_PROFI_MEM_TAG);
        
        if ($error || !$frls) {
            return null;
        }
        
        shuffle($frls);
        
        return $frls;
    }




    /**
     * ������ PROFI ������������� ��� ��������
     * 
     * @param type $limit
     * @return null
     */
    function getProfiLanding($limit = 39)
    {
        $fu_table = self::$fu_table;
        $error = null;
        
        $sql = "
            SELECT 
                p.name as profname,
                s.*
            FROM {$fu_table} AS s 
            INNER JOIN orders AS o ON o.from_id = s.uid AND o.from_date < NOW() AND (o.from_date + o.to_date) > NOW()
            LEFT JOIN professions AS p ON p.id = s.spec
            WHERE 
                s.is_profi = 't' AND s.is_banned = '0'
            ORDER BY o.from_date DESC
            LIMIT {$limit}
        ";
        
        $memBuff = new memBuff();
        $frls = $memBuff->getSql(
                $error, 
                $sql, 
                self::CATALOG_PROFI_MEM_LIFE, 
                true,
                self::CATALOG_PROFI_MEM_TAG);
        
        if ($error || !$frls) {
            return null;
        }
        
        return $frls;        
    }





    /**
     * ������ PROFI �������������
     * 
     * @param type $limit
     * @return null
     */
    function getProfiCatalog($limit = 40)
    {
        $fu_table = self::$fu_table;
        $error = null;
        
        $sql = "
            SELECT 
                p.name as profname,
                (COALESCE(sm.completed_cnt,0) + COALESCE(rm.completed_cnt,0)) AS completed_cnt,
                rating_get(s.rating, s.is_pro, s.is_verify, s.is_profi) as t_rating,
                (uc.paid_advices_cnt + uc.ops_frl_plus + uc.ops_emp_plus + uc.sbr_opi_plus + uc.tu_orders_plus + uc.projects_fb_plus) AS total_opi_plus,
                (uc.ops_frl_minus + uc.ops_emp_minus + uc.sbr_opi_minus + uc.tu_orders_minus + uc.projects_fb_minus) AS total_opi_minus,
                s.*
            FROM {$fu_table} AS s 
            INNER JOIN orders AS o ON o.from_id = s.uid AND o.from_date < NOW() AND (o.from_date + o.to_date) > NOW()
            LEFT JOIN users_counters AS uc ON uc.user_id = s.uid
            LEFT JOIN sbr_meta AS sm ON sm.user_id = s.uid
            LEFT JOIN reserves_meta AS rm ON rm.user_id = s.uid
            LEFT JOIN professions AS p ON p.id = s.spec
            WHERE 
                s.is_profi = 't' AND s.is_banned = '0'
            ORDER BY o.from_date DESC
            LIMIT {$limit};
        ";
        
        $memBuff = new memBuff();
        $frls = $memBuff->getSql(
                $error, 
                $sql, 
                self::CATALOG_PROFI_MEM_LIFE, 
                true,
                self::CATALOG_PROFI_MEM_TAG);
        
        if ($error || !$frls) {
            return null;
        }
        
        return $frls;
    }
    
    
    /**
     * �������� ��� ������� PROFI 
     * � �������� � ��������
     * 
     * @return type
     */
    public static function clearCacheProfiCatalog()
    {
        $memBuff = new memBuff;
        return $memBuff->flushGroup(self::CATALOG_PROFI_MEM_TAG);
    }

    /**
    * @return string ������ �� ������� �������� ������������
    */
    public function getProfileUrl() 
    {
    	return (isset($this->login) && $this->login)?'/users/'.$this->login.'/':'';
    }
    
}