<?
require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/stdf.php");


/**
 * ����� ������ � ��������� � ��������
 *
 */
class projects_offers_dialogue
{
    /**
     * ��������� ������� �� ����������� ����������� � �������
     *
     * @param integer $po_id             id ����������� � �������
     *
     * @return array                     ������ ��������� �������
     */
    function GetDialogueForOffer($po_id)
    {
        $sel_blocked = ', pb.reason as blocked_reason, pb.blocked_time, COALESCE(pb.src_id::boolean, false) as is_blocked, 
            admins.login as admin_login, admins.uname as admin_uname, admins.usurname as admin_usurname';
        $join_blocked = 'LEFT JOIN projects_offers_dialogue_blocked pb ON d.id = pb.src_id 
            LEFT JOIN users as admins ON pb.admin = admins.uid ';

        return $GLOBALS['DB']->rows("
			SELECT 
				d.*, u.login, u.uname, u.usurname, u.role $sel_blocked 
			FROM 
				projects_offers_dialogue AS d 
			INNER JOIN 
				users AS u ON u.uid=d.user_id 
            $join_blocked 
			WHERE 
				po_id = ?
			ORDER BY id
		", $po_id);
    }
    
    /**
     * ���������� ������ ��������� �� ��� ID
     * 
     * @param type $dialogue_id ID ��������� � �������
     * @return array
     */
    function getDialogueMessageById( $dialogue_id = 0 ) {
        $sel_blocked = ', pb.reason as blocked_reason, pb.blocked_time, COALESCE(pb.src_id::boolean, false) as is_blocked, 
            admins.login as admin_login, admins.uname as admin_uname, admins.usurname as admin_usurname';
        $join_blocked = 'LEFT JOIN projects_offers_dialogue_blocked pb ON d.id = pb.src_id 
            LEFT JOIN users as admins ON pb.admin = admins.uid ';
        
        $sQuery = "SELECT d.*, po.project_id, p.name AS project_name $sel_blocked 
            FROM projects_offers_dialogue d 
            INNER JOIN projects_offers po ON po.id = d.po_id 
            INNER JOIN projects p ON p.id = po.project_id 
            $join_blocked 
            WHERE d.id = ?i";
        
        return $GLOBALS['DB']->row( $sQuery, $dialogue_id );
    }
    
    /**
     * ��������� ���������
     * 
     * @param  integer $dialogue_id ID ����������
     * @param  string $reason �������
     * @param  string $reason_id id �������, ���� ��� ������� �� ������
     * @param  integer $uid uid �������������� (���� 0, ������������ $_SESSION['uid'])
     * @param  boolean $from_stream true - ���������� �� ������, false - �� �����
     * @return integer ID ����������
     */
    function Blocked( $dialogue_id = 0, $reason, $reason_id = null, $uid = 0, $from_stream = false ) {      
        if (!$uid && !($uid = $_SESSION['uid'])) return '������������ ����';
        $sql = "INSERT INTO projects_offers_dialogue_blocked (src_id, \"admin\", reason, reason_id, blocked_time) VALUES(?i, ?i, ?, ?, NOW()) RETURNING id";
        $sId = $GLOBALS['DB']->val( $sql, $dialogue_id, $uid, $reason, $reason_id );
        
        $sql = "
            SELECT
                p.user_id as emp_id, o.user_id as frl_id
            FROM 
                projects_offers_dialogue d
            INNER JOIN
                projects_offers o ON d.po_id = o.id
            INNER JOIN
                projects p ON o.project_id = p.id
            WHERE
                d.id = ?
        ";
        $row = $GLOBALS['DB']->row($sql, $dialogue_id);
        $memBuff = new memBuff;
        $memBuff->delete('prjMsgsCnt'.$row['emp_id']);
        $memBuff->delete('prjMsgsCnt'.$row['frl_id']);
        
        if(!$from_stream) {
            require_once $_SERVER['DOCUMENT_ROOT'].'/classes/messages.php';
            require_once( $_SERVER['DOCUMENT_ROOT'] . '/classes/user_content.php' );
            
            messages::SendBlockedDialogue( $dialogue_id, $reason );
            
            $GLOBALS['DB']->query( 'DELETE FROM moderation WHERE rec_id = ?i AND rec_type = ?i;', $dialogue_id, user_content::MODER_PRJ_DIALOG );
            $GLOBALS['DB']->val( 'UPDATE projects_offers_dialogue SET moderator_status = ?i WHERE id = ?i', $uid, $dialogue_id );
        }
        
        return $sId;
    }
        
    /**
     * ������������ ���������
     *
     * @param integer $dialogue_id ID ����������
     * @return string ��������� �� ������
     */
    function UnBlocked( $dialogue_id ) {
        $GLOBALS['DB']->query( 'DELETE FROM projects_offers_dialogue_blocked WHERE src_id = ?i', $dialogue_id );
        
        $sql = "
            SELECT
                p.user_id as emp_id, o.user_id as frl_id
            FROM 
                projects_offers_dialogue d
            INNER JOIN
                projects_offers o ON d.po_id = o.id
            INNER JOIN
                projects p ON o.project_id = p.id
            WHERE
                d.id = ?
        ";
        $row = $GLOBALS['DB']->row($sql, $dialogue_id);
        $memBuff = new memBuff;
        $memBuff->delete('prjMsgsCnt'.$row['emp_id']);
        $memBuff->delete('prjMsgsCnt'.$row['frl_id']);
        
        return $GLOBALS['DB']->error;
    }
    
    /**
     * �������� id ������� �� id ����������� � �������
     *
     * @param integer $po_id             id ����������� � �������
     *
     * @return integer                   id ������� ��� 0 � ������, ���� ������ �� ������
     */
    function GetProjectIDFromDialogue($po_id) {
        $pid = $GLOBALS['DB']->val("SELECT project_id FROM projects_offers WHERE id = ?", $po_id);
        return (int) $pid;
    }



    /**
     * �������� ������ ������� �� id ����������� � �������
     *
     * @param integer $po_id             id ����������� � �������
     *
     * @return array                     ������ �������
     */
    function GetProjectFromDialogue($po_id) {
        return $GLOBALS['DB']->row("SELECT p.* FROM projects AS p INNER JOIN projects_offers AS po ON p.id = po.project_id WHERE po.id = ?", $po_id);
    }



    /**
     * ���������� ��������� � ������ ����������� � �������
     *
     * @param integer $po_id              id ����������� � �������
     * @param integer $user_id            id ������������
     * @param string $message             ����� ���������
     * @param boolean $frl_read           ������� � ��������� �����������
     * @param boolean $emp_read           ������� � ��������� �������������
     * @param boolean $emp_read           ������� � �������� ��������� - ���� �����������
     *
     * @return string                     ������ ������ ���� ����� �������� ������� ��� ��������� �� ������
     */
    function AddDialogueMessage($po_id, $user_id, $message, $frl_read = false, $emp_read = false, $root = false)
    {
        global $DB;
		$message = preg_replace("/(\r\n|\r|\n){3,100}/i", "\r\n\r\n", $message);
        $message = rtrim(ltrim($message, "\r\n"));
        if(strlen_real($message) > 1000) {
            $message = substr(stripcslashes($message), 0, 1000);
        }
		$message = change_q_x(stripcslashes($message), false, true, '', false, false);
        
        $sql = 'SELECT po.user_id AS frl, p.user_id AS emp, e.is_pro AS emp_is_pro, f.is_pro AS frl_is_pro 
                FROM projects_offers po
                LEFT JOIN projects p ON p.id = po.project_id 
                LEFT JOIN employer e ON e.uid = p.user_id 
                LEFT JOIN freelancer f ON f.uid = po.user_id 
                WHERE po.id = ?i LIMIT 1';
        
        $users = $DB->row($sql, $po_id);
        
        $nStopWordsCnt = 0;
        
        if ( !$root && $users['emp_is_pro'] != 't' && $users['frl_is_pro'] != 't' ) {
            require_once( $_SERVER['DOCUMENT_ROOT'] . '/classes/stop_words.php' );
            
            $stop_words    = new stop_words();
            $nStopWordsCnt = $stop_words->calculate( $message );
        }
        
        $sModVal = ( $root || $users['emp_is_pro'] == 't' || $users['frl_is_pro'] == 't' || !$nStopWordsCnt ) ? null : 0;
        
		$sId     = $DB->insert('projects_offers_dialogue', array(
			'po_id'     => $po_id,
			'user_id'   => $user_id,
			'post_text' => (string) $message,
			'frl_read'  => (bool) $frl_read,
			'emp_read'  => (bool) $emp_read,
			'root'      => (bool) $root,
            'moderator_status' => $sModVal
		), 'id');
        
        if ( $sId && !$root && $users['emp_is_pro'] != 't' && $users['frl_is_pro'] != 't' && $nStopWordsCnt ) {
            require_once( $_SERVER['DOCUMENT_ROOT'] . '/classes/user_content.php' );
            $GLOBALS['DB']->insert( 'moderation', array('rec_id' => $sId, 'rec_type' => user_content::MODER_PRJ_DIALOG, 'stop_words_cnt' => $nStopWordsCnt) );
        }
        
        // ������� ������
        $memBuff = new memBuff();
        if ((int)$users['frl'] !== (int)$user_id) {
            $memBuff->delete("prjMsgsCnt{$users['frl']}");
            $memBuff->delete("prjMsgsCntWst{$users['frl']}");
        } elseif ((int)$users['emp'] !== (int)$user_id) {
            $memBuff->delete("prjMsgsCnt{$users['emp']}");
            $memBuff->delete("prjLastMess{$users['emp']}");
        }
        
        return $GLOBALS['DB']->error;
    }



    /**
	 * �������������� ��������� � ������� ����������� � �������
	 *
	 * @param integer $user_id            id ������������
	 * @param string $message             ����� ���������
	 * @param integer $comment_id         id �����������
	 * @param integer $po_id              id ����� ������������ �������
	 * @param boolean $is_first           ������ ����������� � ����� (�����������) ��� �����������
	 * @param integer $moduser_id         UID ������������ (������), ����������� �����������. ���� null - �� ������� $user_id
     * @param string $modified_reason     ������� ��������������
	 * @return string                     ������ ������ ���� ����� �������� ������� ��� ��������� �� ������
	 */
	function SaveDialogueMessage( $user_id, $message, $comment_id, $po_id, $is_first = false, $moduser_id = null, $modified_reason = '' ) {
		$user_id = intval($user_id);
		$comment_id = intval($comment_id);
		$message = preg_replace("/(\r\n|\r|\n){3,100}/i", "\r\n\r\n", $message);
		$message = rtrim(ltrim($message, "\r\n"));
		$message = change_q_x(substr(stripcslashes($message), 0, 1000), false, true, '', false, false);
        $moduser_id = $moduser_id ? $moduser_id : $user_id;
		if ($is_first) {
			$GLOBALS['DB']->query("UPDATE projects_offers_dialogue SET post_text = ?, post_date = NOW(), moduser_id = ?i, modified = now() WHERE id = ?", $message, $moduser_id, $comment_id);
			return $DB->error;
		} else {
			$ret = $GLOBALS['DB']->row( 'SELECT d.user_id, d.post_text, e.is_pro AS emp_is_pro, f.is_pro AS frl_is_pro 
                FROM projects_offers_dialogue d 
                LEFT JOIN projects_offers po ON po.id = d.po_id 
                LEFT JOIN projects p ON p.id = po.project_id 
                LEFT JOIN employer e ON e.uid = p.user_id 
                LEFT JOIN freelancer f ON f.uid = po.user_id 
                WHERE po_id = ? LIMIT 1', $po_id);
            
			if ( $ret['user_id'] == $user_id || hasPermissions('projects') ) {
                if ( $ret['emp_is_pro'] != 't' && $ret['frl_is_pro'] != 't' && $ret['user_id'] == $moduser_id && !hasPermissions('projects') && $ret['post_text'] != $message ) {
                    // �����, �� �����, �� ��� ������ ��������� ���� ����� - ��������� �� �������������
                    require_once( $_SERVER['DOCUMENT_ROOT'] . '/classes/stop_words.php' );
                    require_once( $_SERVER['DOCUMENT_ROOT'] . '/classes/user_content.php' );
                    
                    $stop_words    = new stop_words();
                    $nStopWordsCnt = $stop_words->calculate( $message );
                    $sModer        = ' , moderator_status =' . ( $nStopWordsCnt ? ' 0 ' : ' NULL ' );
                    
                    if ( $nStopWordsCnt ) {
                        $GLOBALS['DB']->insert( 'moderation', array('rec_id' => $comment_id, 'rec_type' => user_content::MODER_PRJ_DIALOG, 'stop_words_cnt' => $nStopWordsCnt) );
                    }
                    else {
                        $GLOBALS['DB']->query( 'DELETE FROM moderation WHERE rec_id = ?i AND rec_type = ?i;', $comment_id, user_content::MODER_PRJ_DIALOG );
                    }
                }
                
				$GLOBALS['DB']->query("UPDATE projects_offers_dialogue SET post_text = ?, post_date = NOW(), moduser_id = ?i, modified = now(), modified_reason = ? $sModer WHERE id = ? AND user_id = ?", $message, $moduser_id, $modified_reason, $comment_id, $user_id);
				return $GLOBALS['DB']->error;
			} else {
				return 1;
			}
		}
	}



    /**
	 * �������� id ���������� ��������� ����� ������������ ������� ��� �������� ������������
	 *
	 * @param integer $user_id           id ������������
	 * @param integer $po_id             id ����� ������������ �������
	 *
	 * @return id                        id ���������� ��������� ����� ������������
	 */
	function GetLastDialogueMessage($user_id, $po_id) {
		return $GLOBALS['DB']->val("SELECT id FROM projects_offers_dialogue WHERE user_id = ? AND po_id = ? ORDER BY id DESC LIMIT 1", $user_id, $po_id);
	}

	
	/**
	 * �������� id ���������� ��������� ����� ������������ ������� ��� �������� ������������
	 *
	 * @param integer $user_id           id ������������
	 * @param integer $po_id             id ����� ������������ �������
	 *
	 * @return id                        id ���������� ��������� ����� ������������
	 */
	function GetLastDialogueMessageData($user_id, $po_id) {
		return $GLOBALS['DB']->row("SELECT * FROM projects_offers_dialogue WHERE user_id = ? AND po_id = ? ORDER BY id DESC LIMIT 1", $user_id, $po_id);
	}



    /**
	 * �������� ��� ��������� ������� � ����������� � ������� ��� ����������� �����������
	 *
	 * @param integer $po_id             id ����������� � �������
	 * @param integer $user_id           id ����������
	 *
	 * @return string                    ������ ������ ���� ����� �������� ������� ��� ��������� �� ������
	 */
	function markReadFrl($po_id, $user_id) {
		$ret = $GLOBALS['DB']->row("SELECT user_id FROM projects_offers WHERE id = ?", $po_id);
		if ($ret['user_id'] == $user_id) {
			$GLOBALS['DB']->query("UPDATE projects_offers_dialogue SET frl_read = 't' WHERE po_id = ?", $po_id);
            
            $memBuff = new memBuff();
            $memBuff->delete("prjMsgsCnt" . $user_id);
            $memBuff->delete("prjMsgsCntWst" . $user_id);
            $memBuff->delete('prjEventsCnt' . $user_id);
            $memBuff->delete('prjEventsCntWst' . $user_id);
			return $GLOBALS['DB']->error;
		}
		return '';
	}

    /**
     * �������� ��� ��������� ������� � ����������� � ������� ��� ����������� �����������
     *
     * @param array   $po_ids            id ����������� � �������
     * @param integer $user_id           id ����������
     *
     * @return string                    ������ ������ ���� ����� �������� ������� ��� ��������� �� ������
     */
    function markReadMod($po_ids, $user_id)
    {
        $GLOBALS['DB']->query("UPDATE projects_offers_dialogue SET mod_read = 't' WHERE po_id IN (?l)", $po_ids);
        return $GLOBALS['DB']->error;
    }



    /**
     * �������� ��� ��������� ������� � ����������� � ������� ��� ����������� �������������
     *
     * @param array   $po_ids            id ����������� � �������
     * @param integer $user_id           id �������������
     *
     * @return string                    ������ ������ ���� ����� �������� ������� ��� ��������� �� ������
     */
    function markReadEmp($po_ids, $user_id)
    {
		$ret = $GLOBALS['DB']->row("SELECT p.user_id FROM projects AS p LEFT JOIN projects_offers AS po ON p.id = po.project_id WHERE po.id IN (?l)", $po_ids);
        if ($ret['user_id'] == $user_id) {
            $GLOBALS['DB']->query("UPDATE projects_offers_dialogue SET emp_read = 't' WHERE po_id IN (?l)", $po_ids);
            $memBuff = new memBuff();
            $memBuff->delete("prjMsgsCnt" . $user_id);
            $memBuff->delete("prjLastMess" . $user_id);
			return $GLOBALS['DB']->error;
        }

        return '';
    }

    
	/**
     * �������� ��� ��������� ���� ����������� � ������� ��� ����������� �������������
     *
     * @param integer $po_id             id �������
     * @param integer $user_id           id ������������
     *
     * @return string                    ������ ������ ���� ����� �������� ������� ��� ��������� �� ������
     */	
	function markAllReadEmp($prj_id, $user_id) 
	{
		$ret = $GLOBALS['DB']->row("SELECT user_id FROM projects WHERE id = ?", $prj_id);
		if ($ret['user_id'] == $user_id) {
			$GLOBALS['DB']->query("
				UPDATE 
					projects_offers_dialogue 
				SET
					emp_read = TRUE
				WHERE 
					po_id IN (SELECT id FROM projects_offers WHERE project_id = ? AND emp_new_msg_count > 0)
					AND emp_read = FALSE
			", $prj_id);
		}
        $memBuff = new memBuff();
        $memBuff->delete("prjMsgsCnt" . $user_id);
        $memBuff->delete("prjLastMess" . $user_id);

		$GLOBALS['DB']->error;
	}



    /**
     * ������������ ���������� ��������� ��� ������������ �� ���� ��� ��������
     *
     * @param integer $user_id           id ������������
     * @param boolean $new               ������� �������� ����� (true) ��� ���� (false) ��������� (!!! ������ ���� �������� ������� ������, ��� true)
     *
     * @return integer                   ���������� ���������
     */
    function CountMessagesForEmp($user_id, $new = false, $as_array = false)
    {
        $mem = new memBuff();
        $count = $mem->get("prjMsgsCnt{$user_id}");
        if (true || !is_array($count) && count($count) != 2) {
            $count = false;
        }
        if ($count === FALSE) {
            $count = $GLOBALS['DB']->row("
                SELECT SUM(emp_new_msg_count) AS all,
                SUM(CASE WHEN po.po_emp_read = false THEN 1 ELSE 0 END) AS offers
                FROM projects p
                LEFT JOIN projects_blocked pb ON pb.project_id = p.id
                INNER JOIN projects_offers po ON po.project_id = p.id
                INNER JOIN freelancer f ON f.uid = po.user_id
                WHERE p.user_id = ? AND f.is_banned = B'0' AND pb.id IS NULL
                AND (p.trash IS NULL OR p.trash = FALSE)
                ", $user_id);
             
            $count_contest = $GLOBALS['DB']->val("
                SELECT SUM(CASE WHEN po.po_emp_read = false THEN 1 ELSE 0 END) AS cnt
                FROM projects p
                LEFT JOIN projects_blocked pb ON pb.project_id = p.id
                INNER JOIN projects_contest_offers po ON po.project_id = p.id
                INNER JOIN freelancer f ON f.uid = po.user_id
                WHERE p.user_id = ? AND f.is_banned = B'0' AND pb.id IS NULL
                AND (p.trash IS NULL OR p.trash = FALSE)
                ", $user_id);
            
            $count['messages'] = $count['all'] - $count['offers'] + $count_contest;
            
            $count['offers'] += $count_contest;
            $count['all'] += $count_contest;
            
            
			$mem->set("prjMsgsCnt{$user_id}", $count, 1800, 'prjMsgsCnt');
		}
        
        return $as_array ? $count : $count['offers'];
    }
	
	
    /**
     * ������������ ���������� ����� ��������� ��� ������������ � �������
     *
     * @param integer $prj_id   id �������
	 *
     * @return integer          ���������� ����� ���������
     */
	function CountMessagesPrjForEmp($prj_id)
	{
		return $GLOBALS['DB']->val("SELECT SUM(emp_new_msg_count) AS cnt FROM projects_offers WHERE project_id = ?", $prj_id);
	}



    /**
     * ������������ ���������� ��������� ��� ���������� �� ���� ��������
     *
     * @param integer $user_id           id ����������
     * @param boolean $new               ������� �������� ����� (true) ��� ���� (false) ��������� (!!! ������ ���� �������� ������� ������, ��� true)
     * @param boolean $waste             ��������� ������� � �������?
     *
     * @return integer                   ���������� ���������
     */
    function CountMessagesForFrl($user_id, $new = false, $waste = true)
    {
        $mem = new memBuff();
        $key = 'prjMsgsCnt' . ($waste ? 'Wst' : '') . $user_id;
        $count = $mem->get($key);
        if ($count === FALSE || is_array($count)) {
            $count = $GLOBALS['DB']->val("
                SELECT 
                    COALESCE(SUM(po.frl_new_msg_count),0) AS cnt 
                FROM projects_offers AS po
                LEFT JOIN projects p ON p.id = po.project_id
                WHERE 
                    p.state = 0 
                    AND po.frl_new_msg_count > 0 
                    AND po.user_id = ?".($waste? "": " AND po.is_waste = 'f'"), 
                $user_id);
            
            $mem->set($key, $count, 1800, 'prjMsgsCnt');
	}
        
        return $count;
    }



    /**
	 * ������� ��� ������������ ������ � ��������� ������������� ����������
	 *
	 * @param integer $user_id           id ������������
	 *
	 * @return mixed                     id �������, ���� ���� ������� � �������������� ����������� � ������� � false, ���� ���.
	 */
	function FindLastMessageProjectForEmp($user_id) {
        $mem = new memBuff;
        $pid = $mem->get('prjLastMess' . $user_id);
        if ($pid !== false && !is_array($pid)) {
            return $pid;
        }
		$pid = $GLOBALS['DB']->val("
		    SET enable_seqscan = false;
		    SET enable_sort = false;
		    SET enable_hashjoin = false;
			SELECT
				p.id
			FROM
				projects p
			INNER JOIN
				projects_offers po ON po.project_id = p.id AND ( po.emp_new_msg_count > 0 OR po.po_emp_read = false )
			LEFT JOIN
				projects_contest_msgs dc ON dc.offer_id = po.id
			LEFT JOIN
				projects_offers_dialogue dp ON dp.po_id = po.id AND dp.emp_read = false
			WHERE
				p.user_id = ?
			ORDER BY
                p.post_date DESC, --  #0024381 ������� ����� ����� ����� ������� c ��������
                COALESCE(dc.post_date, dp.post_date) DESC -- � ��� � ��� �������
			LIMIT
				1
		", $user_id);
		/*if ($_SESSION['uid']) { // ����������� ��� /personal_emp.php
            $_SESSION['lst_emp_new_messages']['pid'] = $pid;
		}*/
        $mem->set('prjLastMess' . $user_id, $pid, 1800);
		return $pid;
	}



    /**
     * ������� ��� ���������� ������ � ��������� ������������� ����������
     *
     * @param integer $user_id id ����������
     *
     * @return mixed                     id �������, ���� ���� ������� � �������������� ����������� � ������� � false, ���� ���.
     */
    function FindLastMessageProjectForFrl($user_id)
    {
        return $GLOBALS['DB']->val("
			SELECT
				po.project_id AS id
			FROM
				projects_offers_dialogue AS pod
			INNER JOIN
				projects_offers AS po ON po.id = pod.po_id
			WHERE
				pod.user_id <> ?i AND po.user_id = ?i AND pod.frl_read = 'f'
			ORDER BY
				pod.post_date DESC
			LIMIT
				1
			OFFSET
				0
		", $user_id, $user_id);
    }
	
    
    /**
     * ������� ��� �������, ������ ������������� "����������" ��������� ������������
     *
     * @param integer $uid �� ������������
     * @return array
     */
    function FindAllUnreadMessageFrl($uid) {
        if (!hasPermissions('projects')) {
			return false;
		}
        return $GLOBALS['DB']->rows("
			SELECT
				d.*, pb.project_id as is_blocked, pb.blocked_time, e.login, e.is_banned, p.pro_only,
				p.name as project_name, po.project_id, ub.id as is_emp_ban, ub.reason, ub.from as from_ban
			FROM
				projects_offers po
			INNER JOIN
				projects_offers_dialogue d ON d.po_id = po.id AND d.frl_read = false
			INNER JOIN
				projects p ON p.id = po.project_id
			INNER JOIN
				employer e ON e.uid = p.user_id
			LEFT JOIN
				projects_blocked pb ON pb.project_id = po.project_id
			LEFT JOIN
				users_ban ub ON ub.uid = e.uid AND ub.to > now()
			WHERE
				po.user_id = ? OR ( po.po_frl_read = false AND po.frl_new_msg_count = 0 AND po.user_id = ?)
			ORDER BY
				d.post_date DESC;
		", $uid, $uid);
    }
    
    /**
     * ������� ��� �������, ������ ������������� "����������" ��������� ������������
     *
     * @param integer $uid �� ������������
     * @return array
     */
    function FindAllUnreadMessageEmp($uid) {
        if (!hasPermissions('projects')) {
			return false;
		}
        $uid = intval($uid);
        return $GLOBALS['DB']->rows("
		    SET enable_seqscan = false;
		    SET enable_sort = false;
		    SET enable_hashjoin = false;
			SELECT
				d.*, pb.project_id as is_blocked, pb.blocked_time, f.login, f.is_banned, p.pro_only, p.name as project_name,
				po.project_id, ub.id as is_frl_ban, ub.reason, ub.from as from_ban
			FROM
				projects p
			LEFT JOIN
				projects_blocked pb ON pb.project_id = p.id
			INNER JOIN
				projects_offers po ON po.project_id = p.id AND po.emp_new_msg_count > 0
			INNER JOIN
				projects_offers_dialogue d ON d.po_id = po.id AND d.emp_read = false
			INNER JOIN
				freelancer f ON f.uid = po.user_id
			LEFT JOIN
				users_ban ub ON ub.uid = f.uid AND ub.to > now()
			WHERE
				p.user_id = ? OR ( po.po_emp_read = false AND po.emp_new_msg_count = 0 )
			ORDER BY
				d.post_date DESC;
		", $uid);
    }
    
    /**
     * ������� ��� �������, ����� ��������� ������������� ���������
     *
     * @param array $msgs �� ��������� ������� ���������� ��������
     * @return string ��������� �� ������
     */
    function getUnread2Read($msgs, $frl=true) {
        if(!hasPermissions('projects') || !is_array($msgs)) {
			return false;
		}
        if ($frl) {
			$data['frl_read'] = TRUE;
		} else {
			$data['emp_read'] = TRUE;
		}
		$GLOBALS['DB']->update('projects_offers_dialogue', $data, "id IN(?l)", $msgs);
        return $GLOBALS['DB']->error;
    }
    
    /**
     * ���������� ����������� �� �������� ���������
     * 
     * @param int $msg_id ID ���������
     * @param int $deluser_id UID ����������
     */
    function DelDialogueMessageNotification( $msg_id = 0, $deluser_id = 0 ) {
        $aDialogue = $GLOBALS['DB']->row( 'SELECT po.project_id, f.uid, f.login, f.uname, f.usurname, p.name 
            FROM projects_offers_dialogue d 
            INNER JOIN projects_offers po ON po.id = d.po_id 
            INNER JOIN projects p ON p.id = po.project_id 
            INNER JOIN freelancer f ON f.uid = po.user_id 
            WHERE d.id = ?i', $msg_id 
        );
        
        if ( $aDialogue['uid'] != $deluser_id ) {
            require_once( $_SERVER['DOCUMENT_ROOT'] . '/classes/messages.php' );
            messages::dialogueMessageDeletedNotification( $aDialogue );
        }
    }
}
