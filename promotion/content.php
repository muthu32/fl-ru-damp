<?
require_once($_SERVER['DOCUMENT_ROOT'] . "/xajax/quickpro.common.php");
$xajax->printJavascript('/xajax/');

  if($DEBUG)
    if(!hasPermissions('users') && $_SESSION['login']!='sll' || !$login) { exit; }
    
  function _broundAll(&$v) {
      $v=t_promotion::bround($v);
  }

  // #ff6d1b ����� �����
  // #fff9e7 ��������� ����
  // #63a545 ������� �����
  // #7eb710 ������� ������
  // #ff9c46 ����� ������
  // #666666 �����-����� ������
  // #c1c1c1 ������-����� ������
  // #f5f5f5 ��� �������
  // #f6f6f6 ����� ��� �������
  // #f7f7f7 ����� ���� �����
  // #808080 �����-����� ������� � �������
  // #b2b2b2 ������-����� ������� � �������


  $u_m_prm_periods = array(); // ��������� ������� ������������� ��������� (�������� ����������� ���������������), ������� � �������� ������.
  $u_y_prm_periods = array(); // ��������� ������� ������������� ���������, ������� � �������� ����.
  $u_last_prm_left = 0;    // ������ � �������� �� ������ �������� ������� �� ������ ���������� ��������� ���-�������.
  $u_last_prm_width  = 0;  // ������ ���������� ��������� ���-�������, � ��������.
  $u_last_prm_period = NULL;
  $u_prm_end_time = 0;
  $u_spec = professions::GetProfessionOrigin($user->spec);
  $u_login  = $user->login;
  $u_is_profi = $user->is_profi == 't';
  $u_is_pro = $iAmAdmin ? is_pro(true, $uid) : ($_SESSION['pro_last'] !== NULL); // ��� �� ��. ����� ���������� ����� (��. ����) -- ������� � ���, ��� ���� is_pro ����������� ��� � ������.
  $u_is_pro_auto_prolong = $user->GetField($uid, $e, 'is_pro_auto_prolong', false); // �������� �� � ����� �������������� ��������� PRO
  $u_is_verify = $user->is_verify;
  $u_summary = promotion::GetSummary($uid); // ������ �� ����� �� stat_summary.
  $u_rating = $user->GetField($uid, $e, 'rating_get(rating, is_pro, is_verify)');
  $u_pro_rating = $u_rating; // �������, � ������, ��� ���� ����� ��� (������������ ����).
  $u_has_ps = false; // ���� �� � ���� ������� ����� ���� ���-��.
  $u_has_ps_fp   = false; // ���� �� � ���� ������� ����� �� ������� ��������.
  $u_has_ps_ctg = false; // ���� �� � ���� ������� ����� � ��������.
  $u_has_pp = false; // ��� �� ������������ � ������� ������ ������ �������� ���� �� ���
  $u_has_of = false; // ��� �� ������������ � ����� ����������� ���� �� ���
  $u_today  = promotion::GetToday($uid); // ���������� �� �������.
  $u_yesterday = promotion::GetYesterday($uid, $YESTERDAY); // ���������� �� �����. ������������ ��� ��� ������� �� ������ � ������.
  $u_last30 = NULL; // ���������� �� ��������� 30 ����, ������ �����.
  $u_ctlg_pos = NULL; // ������� ����� � �������� (� ��������� �� �������������� ��� ��������).
  $u_month = $TODAY_DAY > 1 ? array_fill(1, $TODAY_DAY-1, 0) : array(); // ���������� �� ������� ����� �� ����, �� (� �� �������) ������������ ���.
  $u_month_sum = NULL; // ������ ���� ����� �� ������� ����� (�� ���������� ������������), ������� ���������� �����.
  $u_year = array(); // ���������� ����� �� ������� ��� �� �������, �� (� �� �������) ������� �����.
  $cur_month_max_h = 0; // ��������� ��������� ������� (� ��������).
  $cur_year_max_h  = 0; // ��������� �������� ������� (� ��������).
  $fp_pos_7d_summary = promotion::GetFromPSummary(date('Y-m-d',$time - 7*24*3600), $TODAY);
  $fp_pos_30d_summary = promotion::GetFromPSummary(date('Y-m-d',$time - 30*24*3600), $TODAY);
  $u_has_prm = false; // ����� �� ���� ��������������� �������� (���, ������� ����� �� �������, ������� ����� � ��������).
  $u_ps = NULL; // ������� ����� �����.
  $add_from_c     = false; //
  $sub_from_c     = false; // �� ����, �������������� �� �� ��������, � ������ ���. 
  $add_from_p_fp1  = false; // �������������� �� ��������� �� ������� ���� �� �������, ��������� � ������� 1-� ����� �� �������.
  $add_from_p_ctg1 = false; // �������������� �� ��������� �� ������� ���� � ��������, ��������� � ������� 1-� ����� � ��������.
  $add_from_p_fpAVG  = false; // �������������� �� ��������� �� ������� ���� �� �������, ��������� ������� �� ������� ������������ � ���������� � ����� ����� �� �������.
  $add_from_p_ctgAVG = false; // �������������� �� ��������� �� ������� ���� � ��������, ��������� ������� �� ������� ������������ � ���������� � ����� ����� � ��������.
  $sub_from_p     = false; // true, ���� ����� �������������� ������� ����� (���� ���).
  $u_month_msgs = promotion::GetCountMsgsByMonths($uid);  // ������, ��������������� �������� ������� (1-12), ���������� ���������� ��������� �� ����������.

  // ��� ����������� ������ �� �����, ����� ����� ���� ������� � ���������� �
  // ��� �� ������������ �� ���������� ����� �������.
  unset($user);

  // ��� �� ������������ ���� �� ��� � ������� ������ ������ ������� ��������
  $u_has_pp = account::checkHistory($uid, array(55, 65));
  $u_has_of = account::checkHistory($uid, array(94));
   
  $u_today['from_a'] = $u_today['by_e'] + $u_today['by_f'] + $u_today['by_u'];
  $u_today['from_c'] = $u_today['by_e_from_c'] + $u_today['by_f_from_c'] + $u_today['by_u_from_c'];
  $u_today['from_b'] = $u_today['by_e_from_b'] + $u_today['by_f_from_b'] + $u_today['by_u_from_b'];
  $u_today['from_p'] = $u_today['by_e_from_p'] + $u_today['by_f_from_p'] + $u_today['by_u_from_p'];
  $u_today['from_t'] = $u_today['by_e_from_t'] + $u_today['by_f_from_t'] + $u_today['by_u_from_t'];
  $u_today['from_o'] = $u_today['by_e_from_o'] + $u_today['by_f_from_o'] + $u_today['by_u_from_o'];
  $u_today['from_s'] = $u_today['by_e_from_s'] + $u_today['by_f_from_s'] + $u_today['by_u_from_s'];
  
  if($u_today['from_a']>$cur_month_max_h) $cur_month_max_h = $u_today['from_a'];
  if($u_today['from_a']>$cur_year_max_h)  $cur_year_max_h = $u_today['from_a'];

  $u_month_sum['by_a'] = $u_today['from_a'];
  $u_month_sum['by_e'] = $u_today['by_e'];
  $u_month_sum['by_f'] = $u_today['by_f'];
  $u_month_sum['by_u'] = $u_today['by_u'];

  $u_last30 = array(
                    'from_c' => $u_summary['by_e_from_c_30d'] + $u_summary['by_f_from_c_30d'] + $u_summary['by_u_from_c_30d'],
                    'from_b' => $u_summary['by_e_from_b_30d'] + $u_summary['by_f_from_b_30d'] + $u_summary['by_u_from_b_30d'],
                    'from_p' => $u_summary['by_e_from_p_30d'] + $u_summary['by_f_from_p_30d'] + $u_summary['by_u_from_p_30d'],
                    'from_t' => $u_summary['by_e_from_t_30d'] + $u_summary['by_f_from_t_30d'] + $u_summary['by_u_from_t_30d'],
                    'from_o' => $u_summary['by_e_from_o_30d'] + $u_summary['by_f_from_o_30d'] + $u_summary['by_u_from_o_30d'],
                    'from_s' => $u_summary['by_e_from_s_30d'] + $u_summary['by_f_from_s_30d'] + $u_summary['by_u_from_s_30d'],
                    'from_a' => $u_summary['by_e_30d'] + $u_summary['by_f_30d'] + $u_summary['by_u_30d']
                  );


  // ������� ��������� ��������������� ��������� �����.
  if( ($prm_is_PRO && ($y_prm_p = promotion::GetUserProPeriods($uid, $YEAR.'-01-01', TRUE))) // ������� ��� �� ���
      || ($prm_is_FP && ($y_prm_p = promotion::GetUserPsPeriods($uid, $YEAR.'-01-01'))) // ������� ������� ���� �� ������� �� ���.
      || ($prm_is_CTG && ($y_prm_p = promotion::GetUserPsPeriods($uid, $YEAR.'-01-01', -1, '<>'))) ) // ������� � �������� �� ���.
  {
    // ��������� ��������� ������ ��������������(������) ������, ���� ���������
    // ������� ������� � ���� ������� (����� ��� �������� ��������� ������� ���� � ��������).
    foreach($y_prm_p as $pp) {
      $fday = substr($pp['from_time'],0,10);
      $tday = substr($pp['to_time'],0,10);
      $ltime = 0;
      if($u_last_prm_period
         && ($ltime = strtotime($u_last_prm_period['to_day'])) >= strtotime($tday)) 
        { continue; }
      if($ltime >= strtotime($fday)) {
        $u_last_prm_period['to_day'] = $tday;
        $u_last_prm_period['to_time'] = $pp['to_time'];
      }
      else {
        if($u_last_prm_period)
          $u_y_prm_periods[] = $u_last_prm_period;
        $u_last_prm_period = array('from_day'=> $fday, 'to_day' => $tday, 'from_time' => $pp['from_time'], 'to_time' => $pp['to_time']);
      }
    }
    $u_y_prm_periods[] = $u_last_prm_period;


    // �������� "���������" ������� �� ������� �����.
    foreach($u_y_prm_periods as $pp) {
      if(($ftime=strtotime($pp['from_time'])) < $TOMORROW_TIME && strtotime($pp['to_time']) >= $MONTHDAY_TIME)
        $u_m_prm_periods[] = ($u_m_prm_periods || $ftime >= $MONTHDAY_TIME) ? $pp : array('from_time'=>$MONTHDAY, 'to_time'=>$pp['to_time']);
    }

    
    
    // ��������� ���� (�����) ������������� ���������.
    if($prm_is_PRO) {
        if (!$iAmAdmin) {
            $u_prm_end_time = strtotime($_SESSION['pro_last']); // ����� ������ ����� ���������� ��� � ������ �������� @see #0014946
        } else {
            $pro_last = payed::ProLast($login);
            $u_prm_end_time = strtotime($pro_last['is_freezed'] ? false : $pro_last['cnt']);
        }
    } else {
        $u_prm_end_time = strtotime($u_last_prm_period['to_time']);
    }

    // ��������� ����� �� ������ ���� �������� ������� � ������ ������� ������ �������.
    $lp_m = date('n', strtotime($u_last_prm_period['from_day'])) - 1; // ������ - 0.
    $lp_d = date('j', strtotime($u_last_prm_period['from_day']));
    $lp_y = substr($u_last_prm_period['from_day'],0,4);
    $lp_to_m = date('n', strtotime($u_last_prm_period['to_day'])) - 1;
    $lp_to_d = date('j', strtotime($u_last_prm_period['to_day']));
    $lp_to_y = substr($u_last_prm_period['to_day'],0,4);
    for($i=0;$i<$lp_m;$i++) {
      $u_last_prm_left += $MSIZES[$i]*2 + 1; // ���� ����� ��������� ������.
    }
    $u_last_prm_left += ($lp_d - 1)*2 + 1; // ���� ��� ������, � ������� ������ ����������, �� �� ������� ��� ������ ����.
    if($lp_to_y != $lp_y);
    else if($lp_to_m - $lp_m > 0) {
      $u_last_prm_width += ($MSIZES[$lp_m] - $lp_d + 1)*2; // ��� ������, � ������� ������ ����������, ������� � ������� ��� (� ������� ���).
      for($i=$lp_m+1;$i<$lp_to_m;$i++) {
        $u_last_prm_width += $MSIZES[$i]*2 + 1;
      }
      $u_last_prm_width += $lp_to_d*2 + 1; // ($lp_to_d - 1)*2 + 1
    }
    else {
      $u_last_prm_width += ($lp_to_d - $lp_d + 1)*2;
    }
  }


  $u_has_ps = $u_has_ps_fp || $u_has_ps_ctg;
  $u_has_prm = $prm_is_FP ? $u_has_ps_fp : ($prm_is_CTG ? $u_has_ps_ctg : $u_is_pro);
  if(!$u_is_pro)
    $u_pro_rating = rating::GetByFormula($u_rating + (int)rating::GetWorkFactorPlusIfPro($uid), 't', $u_is_verify);

  // ���������� ����� � ��������.
  if($u_profs = professions::GetProfessionsByUser($uid, false)) {
    foreach($u_profs as $prof_id) {
      if(!$u_is_pro)
        $pro_pos = professions::GetCatalogPosition($uid, $u_spec, $u_pro_rating, $prof_id, TRUE, TRUE);

      $cur_pos = professions::GetCatalogPosition($uid, $u_spec, $u_rating, $prof_id, $u_is_pro);
      $u_ctlg_pos[] = array('prof_name' => $cur_pos['prof_name'],
                            'prof_id'   => $prof_id,
                            'pos'       => $cur_pos['pos'],
                            'propos'    => $pro_pos['pos'],
                            'link'      => $cur_pos['link']);
    }
  }

  // �������� ���������� ����� ��� ������� �� ����� � �� ���.

  if($mdays = promotion::GetFromDaily($uid, $MONTHDAY, $TODAY)) {
    foreach($mdays as $d) {
      if(($mc=$d['by_e'] + $d['by_f'] + $d['by_u']) > $cur_month_max_h)
        $cur_month_max_h = $mc;
      if($mc > $cur_year_max_h)
        $cur_year_max_h = $mc;
      $u_month_sum['by_a'] += $mc;
      $u_month_sum['by_e'] += $d['by_e'];
      $u_month_sum['by_f'] += $d['by_f'];
      $u_month_sum['by_u'] += $d['by_u'];
      $u_month[date('j',strtotime($d['_date']))] = $d;
    }
  }

  if($ymonths = promotion::GetFromMonthly($uid, $YEAR.'-01-01', $TODAY)) {
    foreach($ymonths as $m) {
      $by_e_arr = t_promotion::pg2php_arr($m['by_e']);
      $by_f_arr = t_promotion::pg2php_arr($m['by_f']);
      $by_u_arr = t_promotion::pg2php_arr($m['by_u']);
      for($i=0;$i<count($by_e_arr);$i++) {
        if(($mc=($by_e_arr[$i] + $by_f_arr[$i] + $by_u_arr[$i])) > $cur_year_max_h)
          $cur_year_max_h = $mc;
      }
      $u_year[date('n', strtotime($m['_date']))] = $m;
    }
  }


//////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////prognostics//////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////

  $next30_sum = NULL;
  $avg7  = NULL;
  $avg30 = NULL;

  // ����� �� ������ ��� ���������, �� � ��� ���������� (� �������).
  $avg7['by_e_from_p_fp1'] = ($fp_pos_7d_summary[1]['by_e'] / 7);  
  $avg7['by_f_from_p_fp1'] = ($fp_pos_7d_summary[1]['by_f'] / 7);
  $avg7['by_u_from_p_fp1'] = ($fp_pos_7d_summary[1]['by_u'] / 7);
  $avg7['by_e_from_p_ctg1'] = ($fp_pos_7d_summary[0]['by_e'] / 7);  
  $avg7['by_f_from_p_ctg1'] = ($fp_pos_7d_summary[0]['by_f'] / 7);
  $avg7['by_u_from_p_ctg1'] = ($fp_pos_7d_summary[0]['by_u'] / 7);

  
  if(!$u_has_prm)
  {
    /*
     ���.
     �������� ���������� "�� ��������", ���������� ������� "�� ��������".
     1) ���� ������� ����� �� �������:
        �������� ���������� ���� ������� ����, ���������� ������� �� �������.
     2) ���� ������� ����� � ��������:
        �������� ���������� ���� ������� ����, ���������� ������� �� ��������.
     3) ���� ������� ����� � �������� � �� �������:
        �������� ���������� ���� ������� ����, ���������� ������� �� ��������, ���� ������� �� �������.
     �������.
     �������� ���������� ���� ������� ����, ���������� ������� �� �������.
     1) ���� ������� ����� � ��������:
        ���������� ������� �� ��������
     2) ���� ���:
        �������� ���������� "�� ��������", ���������� ������� "�� ��������".
     �������.
     �������� ���������� ���� ������� ����, ���������� ������� �� ��������.
     1) ���� ������� ����� �� �������:
        ���������� ������� �� �������
     2) ���� ���:
        �������� ���������� "�� ��������", ���������� ������� "�� ��������".
     */
    
    $add_from_c =
    $sub_from_c     = $prm_is_PRO || ( ($prm_is_FP || $prm_is_CTG) && $u_is_pro );
    $add_from_p_fp1  = $prm_is_FP;
    $add_from_p_ctg1 = $prm_is_CTG;
    $sub_from_p     = $prm_is_FP  || $prm_is_CTG || ( $prm_is_PRO && $u_has_ps );
    $add_from_p_fpAVG  = $sub_from_p && !$add_from_p_fp1;
    $add_from_p_ctgAVG = $sub_from_p && !$add_from_p_ctg1;


    if($add_from_p_fpAVG || $add_from_p_ctgAVG) {

      // ���� ������ ���.
      // 1. ������������ ������������ �� ��������. � ����� ���� ������� ����� �� ������� (�� ��� � �������� -- ��� ���� ��, ���� ��):
      //    - �������� ��� ��������� ��������� � ������� ���� (�.�. ��� � �������).
      //    - ���������� �� � 1-�� ����� �� �������, � ��� ����������� ������� �� 30 ����! -- �.�. �� ������ �� ������������, � ������ ���� ������ ��� ����� �������.
      //    - ���������� ������� ������������ � 1-�� ����� ��������.
      // 2. ������������ ������������ � �������. �.�. ���� ����� � ��������:
      //    - �������� ��� ��������� ��������� � ������� ���� (�.�. ��� �� ��������).
      //    - ���������� �� � 1-�� ����� � ����� ��������, � ��� ����������� ������� �� 30 ����!
      //    - ���������� ������� ������������ � 1-�� ����� �� �������.
     
      // ������� ������������ �� �������� ����� � ����� �������� � �� ������� �� 30 ����:
      // 1) �������� ����� ������������ � ������� ���� �� ��������� 30 ���� (A).
      // 2) �������� ���������� ���� �� ���� 30-��, ����� ���� ���� ������� �����:
      //    - � �������� (Dc);
      //    - �� ������� (Df).
      // 3) ����� �������: A = Dc*C + Df*F,
      //    ��� F -- ������� ������������ � �������, C -- ������� ������������ �� �������� � ���������������
      //    ������� (30 ����), �.�. ��, ��� ����� �����.
      // 4) ������� ��������� ������������ �� �������� � �������: � = C / F
      //    K ������� ����� ��������� ������������ �� 1-�� ����� �������� � 1-�� ����� �� ������� ��
      //    �����-������ ������������ ������ (30 ����, ��������).
      // 5) �� 3 � 4 ��������:
      //    C = F * K,
      //    F = A / (Dc*K + Df).

      // * ������ ����� ���� ����, �� ��������.
      
      if(($u_psDays = promotion::GetUserPsDayCount($uid, date('Y-m-d',strtotime($YESTERDAY) - 30*24*3600), $YESTERDAY))
         && ($u_psDays['fp_days'] + $u_psDays['ctg_days']) > 0)
      {

        if($fp_pos_30d_summary[1]['by_e'] && ($K_psCF_by_e = $fp_pos_30d_summary[0]['by_e'] / $fp_pos_30d_summary[1]['by_e']))
          $t_fp_e = $u_summary['by_e_from_p_30d'] / ($u_psDays['ctg_days'] * $K_psCF_by_e + $u_psDays['fp_days']);
        if($fp_pos_30d_summary[1]['by_f'] && ($K_psCF_by_f = $fp_pos_30d_summary[0]['by_f'] / $fp_pos_30d_summary[1]['by_f']))
          $t_fp_f = $u_summary['by_f_from_p_30d'] / ($u_psDays['ctg_days'] * $K_psCF_by_f + $u_psDays['fp_days']);
        if($fp_pos_30d_summary[1]['by_u'] && ($K_psCF_by_u = $fp_pos_30d_summary[0]['by_u'] / $fp_pos_30d_summary[1]['by_u']))
          $t_fp_u = $u_summary['by_u_from_p_30d'] / ($u_psDays['ctg_days'] * $K_psCF_by_u + $u_psDays['fp_days']);

        if($u_psDays['fp_days']) {
          $avg30['by_e_from_p_fp'] = $t_fp_e ? $t_fp_e : $u_summary['by_e_from_p_30d'] / $u_psDays['fp_days'];
          $avg30['by_f_from_p_fp'] = $t_fp_f ? $t_fp_f : $u_summary['by_f_from_p_30d'] / $u_psDays['fp_days'];
          $avg30['by_u_from_p_fp'] = $t_fp_u ? $t_fp_u : $u_summary['by_u_from_p_30d'] / $u_psDays['fp_days'];
        }
        if($u_psDays['ctg_days']) {
          $avg30['by_e_from_p_ctg'] = $t_fp_e && $K_psCF_by_e ? $t_fp_e * $K_psCF_by_e : $u_summary['by_e_from_p_30d'] / $u_psDays['ctg_days'];
          $avg30['by_f_from_p_ctg'] = $t_fp_f && $K_psCF_by_f ? $t_fp_f * $K_psCF_by_f : $u_summary['by_f_from_p_30d'] / $u_psDays['ctg_days'];
          $avg30['by_u_from_p_ctg'] = $t_fp_u && $K_psCF_by_u ? $t_fp_u * $K_psCF_by_u : $u_summary['by_u_from_p_30d'] / $u_psDays['ctg_days'];
        }
      }
      
    }

    $avg7['by_e_from_p'] = $add_from_p_fp1 * $avg7['by_e_from_p_fp1'] + $add_from_p_ctg1 * $avg7['by_e_from_p_ctg1'] + $add_from_p_fpAVG*$avg30['by_e_from_p_fp'] + $add_from_p_ctgAVG*$avg30['by_e_from_p_ctg'];
    $avg7['by_f_from_p'] = $add_from_p_fp1 * $avg7['by_f_from_p_fp1'] + $add_from_p_ctg1 * $avg7['by_f_from_p_ctg1'] + $add_from_p_fpAVG*$avg30['by_f_from_p_fp'] + $add_from_p_ctgAVG*$avg30['by_f_from_p_ctg'];
    $avg7['by_u_from_p'] = $add_from_p_fp1 * $avg7['by_u_from_p_fp1'] + $add_from_p_ctg1 * $avg7['by_u_from_p_ctg1'] + $add_from_p_fpAVG*$avg30['by_u_from_p_fp'] + $add_from_p_ctgAVG*$avg30['by_u_from_p_ctg'];
    $avg7['by_e_from_b'] = ($u_summary['by_e_from_b_7d'] / 7);
    $avg7['by_f_from_b'] = ($u_summary['by_f_from_b_7d'] / 7);
    $avg7['by_u_from_b'] = ($u_summary['by_u_from_b_7d'] / 7);
    $avg7['by_e_from_o'] = ($u_summary['by_e_from_o_7d'] / 7);
    $avg7['by_f_from_o'] = ($u_summary['by_f_from_o_7d'] / 7);
    $avg7['by_u_from_o'] = ($u_summary['by_u_from_o_7d'] / 7);
    $avg30['by_e_from_p'] = $add_from_p_fp1 * ($fp_pos_30d_summary[1]['by_e'] / 30) + $add_from_p_ctg1 * ($fp_pos_30d_summary[0]['by_e'] / 30) + $add_from_p_fpAVG*$avg30['by_e_from_p_fp'] + $add_from_p_ctgAVG*$avg30['by_e_from_p_ctg'];
    $avg30['by_f_from_p'] = $add_from_p_fp1 * ($fp_pos_30d_summary[1]['by_f'] / 30) + $add_from_p_ctg1 * ($fp_pos_30d_summary[0]['by_f'] / 30) + $add_from_p_fpAVG*$avg30['by_f_from_p_fp'] + $add_from_p_ctgAVG*$avg30['by_f_from_p_ctg'];
    $avg30['by_u_from_p'] = $add_from_p_fp1 * ($fp_pos_30d_summary[1]['by_u'] / 30) + $add_from_p_ctg1 * ($fp_pos_30d_summary[0]['by_u'] / 30) + $add_from_p_fpAVG*$avg30['by_u_from_p_fp'] + $add_from_p_ctgAVG*$avg30['by_u_from_p_ctg'];
    $avg30['by_e_from_b'] = ($u_summary['by_e_from_b_30d'] / 30);
    $avg30['by_f_from_b'] = ($u_summary['by_f_from_b_30d'] / 30);
    $avg30['by_u_from_b'] = ($u_summary['by_u_from_b_30d'] / 30);
    $avg30['by_e_from_c'] = ($u_summary['by_e_from_c_30d'] / 30);
    $avg30['by_f_from_c'] = ($u_summary['by_f_from_c_30d'] / 30);
    $avg30['by_u_from_c'] = ($u_summary['by_u_from_c_30d'] / 30);
    $avg30['by_e_from_t'] = ($u_summary['by_e_from_t_30d'] / 30);
    $avg30['by_f_from_t'] = ($u_summary['by_f_from_t_30d'] / 30);
    $avg30['by_u_from_t'] = ($u_summary['by_u_from_t_30d'] / 30);
    $avg30['by_e_from_o'] = ($u_summary['by_e_from_o_30d'] / 30);
    $avg30['by_f_from_o'] = ($u_summary['by_f_from_o_30d'] / 30);
    $avg30['by_u_from_o'] = ($u_summary['by_u_from_o_30d'] / 30);


    $nday     = date('Y-m-d', $time - 27 * (24*3600));
    $prev27   = NULL;
    $pro_days = NULL;
    $K_wC = 0.00; // ��������� ������������� ������� ������������ "�� ��������".
    $npcnt = 0;  // ������� ���� �� ������ ������ ���������, � �������������� �������������� ��������� (� ������������ � $next30 � ���� �����).
    $next30 = NULL;
    $coeffs = promotion::GetWeekCoeffs();
    $j=0;

    if($add_from_c)
    {
      // ����� ��� � GetProCatalogByDay() �������, ��� ���� ������ � ����� ����� �������������,
      // �� � 27 ���� ����� ��� �� � ����. �� ����� ������, �� �� ��������.
      if($pro_periods = promotion::GetProPeriods($u_spec, $nday, $YESTERDAY))
      {
        foreach($pro_periods as $pd) {
          $i=0;
          $frtm = strtotime($pd['from']);
          do {
            $from = date('Y-m-d', $frtm + ($i * 24*3600));
            $pro_days[$from] = true;
          } while($from != $pd['to'] && ++$i<=27);
          if($i>27) break;
        }

        while(strtotime($nday) < $TODAY_TIME)
        {
          $tnday = $nday;
          // ����� ��������� �������� �� ���������� ����, ������� � -28-�� ��� �� ����������� �����. ��������� -- �� ����, ����� ���������� �����,
          // ������� ��� � ���� ���� (����� ����) � ��� �� �������������, ��� � ����. � ������ ������ �� ����� 5, � ������ 0.
          // ���� 0, �� ���� ������, ����� ���������� ���� ������ $prev27[], �������������� ������ ����.
          // ���� ������� -- ��� ������ �� ��� ����� ���������� �����, �� ��� ����� ����� ����������
          // ������������.
        
          // ����� ���� ����� ��� �� ������������� � ������� ��� � ���� ����.
          // ���� � �������� ��� ���� ���, �� "C" ������ ����� � ����� �� �����. ��������� ����������.
          if ( $pro_days[$nday]
               && ($neighbours = promotion::GetProCatalogByDay($u_spec, $nday)) )
          {
            // �������� ����� ��� ����� ����������.
            if ( $ngbs = promotion::GetNeighbours($neighbours, $u_pro_rating) )
            {
              if(!($ngbs['A'] && $ngbs['E'])) $ngbs['A'] = $ngbs['E'] = NULL;
              if(!($ngbs['B'] && $ngbs['D'])) $ngbs['B'] = $ngbs['D'] = NULL;

              // ������� ���� ��� � ����-�� �� ��������� ����� ��������� ��� ������, ��� � ���������.
              // �� ����� ��� �� ����� ������������ ������������ ���� ��������� ������, � 
              // � ���� ���� � ����� ���� �������� �������� ����� ������ �����.
              // ���� � ����-�� ��� ���������� ������� ���, �� ����� ������ ��, �� �� ������� ���� ����.
              // ����� ���� ����� �������, � ������� � ���� ���� (����� ����) ��� ���.
              $min_pro_to = $TODAY_TIME;
              if($ngbs['A'] && ($t = strtotime($ngbs['A']['pro_to'])) < $min_pro_to) $min_pro_to = $t;
              if($ngbs['B'] && ($t = strtotime($ngbs['B']['pro_to'])) < $min_pro_to) $min_pro_to = $t;
              if($ngbs['C'] && ($t = strtotime($ngbs['C']['pro_to'])) < $min_pro_to) $min_pro_to = $t;
              if($ngbs['D'] && ($t = strtotime($ngbs['D']['pro_to'])) < $min_pro_to) $min_pro_to = $t;
              if($ngbs['E'] && ($t = strtotime($ngbs['E']['pro_to'])) < $min_pro_to) $min_pro_to = $t;


              if($C = promotion::GetFromDaily($ngbs['C']['user_id'], $nday, date('Y-m-d', $min_pro_to))) {
                foreach($C as $c) $prev27[$c['_date']]['C'] = $c;
                if($ngbs['A']) {
                  if(($A = promotion::GetFromDaily($ngbs['A']['user_id'], $nday, date('Y-m-d', $min_pro_to)))
                     && ($E = promotion::GetFromDaily($ngbs['E']['user_id'], $nday, date('Y-m-d', $min_pro_to))))
                  {
                    foreach($A as $a) $prev27[$a['_date']]['A'] = $a;
                    foreach($E as $e) $prev27[$e['_date']]['E'] = $e;
                  }
                  else; // ���� ����� � ��� ����� ������...
                }
                if($ngbs['B']) {
                  if(($B = promotion::GetFromDaily($ngbs['B']['user_id'], $nday, date('Y-m-d', $min_pro_to)))
                     && ($D = promotion::GetFromDaily($ngbs['D']['user_id'], $nday, date('Y-m-d', $min_pro_to))))
                  {
                    foreach($B as $b) $prev27[$b['_date']]['B'] = $b;
                    foreach($D as $d) $prev27[$d['_date']]['D'] = $d;
                  }
                }
                // ���� $min_pro_to >= �������, �� ���� ����������. (����������� ������������ �� �����, �.�. ����� ������ ����� ���.)
                $nday = date('Y-m-d', $min_pro_to);
              }
            }
          }

          $sh = 0;
          while($nday == $tnday)
              $nday = date('Y-m-d', strtotime($nday) + (24+$sh++)*3600);
        }
      }

    } // if($add_from_c)

    else
    {
      $next30[$j] = array (
        'by_e_from_c' => $avg30['by_e_from_c'],
        'by_f_from_c' => $avg30['by_f_from_c'],
        'by_u_from_c' => $avg30['by_u_from_c'],
        'by_e_from_b' => $avg7['by_e_from_b'],
        'by_f_from_b' => $avg7['by_f_from_b'],
        'by_u_from_b' => $avg7['by_u_from_b'],
        'by_e_from_p' => $avg7['by_e_from_p'],
        'by_f_from_p' => $avg7['by_f_from_p'],
        'by_u_from_p' => $avg7['by_u_from_p'],
        'by_e_from_t' => $avg30['by_e_from_t'],
        'by_f_from_t' => $avg30['by_f_from_t'],
        'by_u_from_t' => $avg30['by_u_from_t'],
        'by_e_from_o' => $avg30['by_e_from_o'],
        'by_f_from_o' => $avg30['by_f_from_o'],
        'by_u_from_o' => $avg30['by_u_from_o']
      );

      $npcnt++;
      $j++;
    }

    // ����� ����� ������ ��������� ���������� ������������� ������ ���� (� ����� �� 30),
    // ������� � ����������� ���.
    // ��� ����� � ������� ������� ����� �������������� ������ $prev27.

    for($j;$j<30;$j++)
    {
      // ���� ������ ��� �������� �� ������ ����, ������� � �����������.
      // ������� � $prev27 ������� ����.
    
      $n30_ctm  = $time + (($j+1)*24*3600);
      $n30_cday = date('Y-m-d', $n30_ctm);
      $n30_cwdy = date('w', $n30_ctm);
      $p27data = NULL;

      if($prev27  // $prev27 ����������, ������ ���� $prm_is_PRO
         && !$npcnt) // ���� ���� ���� ��� �������� ����� ������ "�����", �� ��� ������, ��� ������� $prev27 ��������� ����,
                     // ������� ���� �� ����� ����.
      {
        $p27_ctm  = $time + ($j - 27) * (24*3600);
        $p27_cday = date('Y-m-d', $p27_ctm);
        $p27_cwdy = date('w', $p27_ctm);
        if($prev27[$p27_cday]) {
          // (0) ��� ��.
          $p27data = array('data'=>$prev27[$p27_cday], 'eKC'=>1, 'fKC'=>1, 'uKC'=>1);
        }
        else {
          // (1) ������� ������ �� $prev27 ����� ������ ������.
          for($d=1;$d<=4;$d++) {
            $gd = date('Y-m-d', $p27_ctm + $d*7*24*3600);
            if($prev27[$gd]) {
              $p27data = array('data'=>$prev27[$gd], 'eKC'=>1, 'fKC'=>1, 'uKC'=>1);
              break;
            }
          }
          // (2) ������� ������ �� $prev27 ����� ������ ����.
          if(!$p27data) {
            for($d=1;$d<=27;$d++) {
              $gd = date('Y-m-d', $p27_ctm + $d*24*3600);
              if($prev27[$gd]) {
                $eKC=$fKC=$uKC=1;
                if($coeffs) {
                  $dwdy = date('w', $p27_ctm + $d*24*3600); // ���� ������, ��� ����� ������.
                  $eKC = $coeffs[$p27_cwdy]['by_e_from_c'] / $coeffs[$dwdy]['by_e_from_c'];
                  $fKC = $coeffs[$p27_cwdy]['by_f_from_c'] / $coeffs[$dwdy]['by_f_from_c'];
                  $uKC = $coeffs[$p27_cwdy]['by_u_from_c'] / $coeffs[$dwdy]['by_u_from_c'];
                }
                $p27data = array('data'=>$prev27[$gd], 'eKC'=>$eKC, 'fKC'=>$fKC, 'uKC'=>$uKC);
                break;
              }
            }
          }
        }
      }

      if(!$p27data)
      {
        // ���� �����, �� ��� � ������� $next30.
      
        $npcnt++;
      
        if($next30)
        {
          // (3) ���� �����, �� ��� � ������� $next30.
          // ����� ������ ���������� ����.
        
          $n30p = $next30[$j-1];
          $eK=$fK=$uK=$eKC=$fKC=$uKC=1;
          if($coeffs) {
            $dwdy = date('w', $n30_ctm - 24*3600); // ����, �� �������� ����� ������ (��������������).
            $eKC = $coeffs[$n30_cwdy]['by_e_from_c'] / $coeffs[$dwdy]['by_e_from_c']; // ������������.
            $fKC = $coeffs[$n30_cwdy]['by_f_from_c'] / $coeffs[$dwdy]['by_f_from_c'];
            $uKC = $coeffs[$n30_cwdy]['by_u_from_c'] / $coeffs[$dwdy]['by_u_from_c'];
          }

          $eKC *= (1 + $K_wC * floor($npcnt / 7));
          $fKC *= (1 + $K_wC * floor($npcnt / 7));
          $uKC *= (1 + $K_wC * floor($npcnt / 7));

          $next30[$j] = array (
            'by_e_from_c' => $n30p['by_e_from_c'] * $eKC,
            'by_f_from_c' => $n30p['by_f_from_c'] * $fKC,
            'by_u_from_c' => $n30p['by_u_from_c'] * $uKC,
            'by_e_from_b' => $avg30['by_e_from_b'],
            'by_f_from_b' => $avg30['by_f_from_b'],
            'by_u_from_b' => $avg30['by_u_from_b'],
            'by_e_from_p' => $avg30['by_e_from_p'],
            'by_f_from_p' => $avg30['by_f_from_p'],
            'by_u_from_p' => $avg30['by_u_from_p'],
            'by_e_from_t' => $avg30['by_e_from_t'],
            'by_f_from_t' => $avg30['by_f_from_t'],
            'by_u_from_t' => $avg30['by_u_from_t'],
            'by_e_from_o' => $avg30['by_e_from_o'],
            'by_f_from_o' => $avg30['by_f_from_o'],
            'by_u_from_o' => $avg30['by_u_from_o']
          );
        }
        else {
          // (4) ��� ������ ������.
          
          // ������ ���������� ������������ ����� �� ���������� �� ������������ �������, ���, �����
          // ������� ����� ����� ��� ����������� ��������� � ���������.
          if($like_pro_uid = promotion::GetProFromLikeSpec($u_spec, $u_pro_rating))
              $smry_lpu = promotion::GetSummary($like_pro_uid);
        
          $by_e_from_c = $smry_lpu ? ceil($smry_lpu['by_e_30d'] / 30) : 0;
          $by_f_from_c = $smry_lpu ? ceil($smry_lpu['by_f_30d'] / 30) : 0;
          $by_u_from_c = $smry_lpu ? ceil($smry_lpu['by_u_30d'] / 30) : 0;

          $next30[$j] = array (
            'by_e_from_c' => $by_e_from_c,
            'by_f_from_c' => $by_f_from_c,
            'by_u_from_c' => $by_u_from_c,
            'by_e_from_b' => $avg7['by_e_from_b'],
            'by_f_from_b' => $avg7['by_f_from_b'],
            'by_u_from_b' => $avg7['by_u_from_b'],
            'by_e_from_p' => $avg7['by_e_from_p'],
            'by_f_from_p' => $avg7['by_f_from_p'],
            'by_u_from_p' => $avg7['by_u_from_p'],
            'by_e_from_t' => $avg30['by_e_from_t'],
            'by_f_from_t' => $avg30['by_f_from_t'],
            'by_u_from_t' => $avg30['by_u_from_t'],
            'by_e_from_o' => $avg30['by_e_from_o'],
            'by_f_from_o' => $avg30['by_f_from_o'],
            'by_u_from_o' => $avg30['by_u_from_o']
          );

        }
      } // if(!$p27data)
      else
      {
        $A = $p27data['data']['A'];
        $B = $p27data['data']['B'];
        $C = $p27data['data']['C'];
        $D = $p27data['data']['D'];
        $E = $p27data['data']['E'];

        $by_e_from_c = ceil(
                     ((  1*(int)$A['by_e']
                       + 2*(int)$B['by_e']
                       + 3*(int)$C['by_e']
                       + 2*(int)$D['by_e']
                       + 1*(int)$E['by_e'] ) / ((!!$A) + 2*(!!$B) + 3*(!!$C) + 2*(!!$D) + (!!$E))) * $p27data['eKC']);
        $by_f_from_c = ceil(
                     ((  1*(int)$A['by_f']
                       + 2*(int)$B['by_f']
                       + 3*(int)$C['by_f']
                       + 2*(int)$D['by_f']
                       + 1*(int)$E['by_f'] ) / ((!!$A) + 2*(!!$B) + 3*(!!$C) + 2*(!!$D) + (!!$E))) * $p27data['fKC']);
        $by_u_from_c = ceil(
                     ((  1*(int)$A['by_u']
                       + 2*(int)$B['by_u']
                       + 3*(int)$C['by_u']
                       + 2*(int)$D['by_u']
                       + 1*(int)$E['by_u'] ) / ((!!$A) + 2*(!!$B) + 3*(!!$C) + 2*(!!$D) + (!!$E))) * $p27data['uKC']);

        $avg = ($j ? 'avg30' : 'avg7');
        $next30[$j] = array (
          'by_e_from_c' => $by_e_from_c,
          'by_f_from_c' => $by_f_from_c,
          'by_u_from_c' => $by_u_from_c,
          'by_e_from_b' => ${$avg}['by_e_from_b'],
          'by_f_from_b' => ${$avg}['by_f_from_b'],
          'by_u_from_b' => ${$avg}['by_u_from_b'],
          'by_e_from_p' => ${$avg}['by_e_from_p'],
          'by_f_from_p' => ${$avg}['by_f_from_p'],
          'by_u_from_p' => ${$avg}['by_u_from_p'],
          'by_e_from_t' => $avg30['by_e_from_t'],
          'by_f_from_t' => $avg30['by_f_from_t'],
          'by_u_from_t' => $avg30['by_u_from_t'],
          'by_e_from_o' => $avg30['by_e_from_o'],
          'by_f_from_o' => $avg30['by_f_from_o'],
          'by_u_from_o' => $avg30['by_u_from_o']
        );
      }
    
    }

    for($j=0;$j<30;$j++)
    {
      $n = &$next30[$j];

      // ���������� ����� � �����.
      array_walk($n, '_broundAll');

      $n['by_e'] = $u_yesterday['by_e'] - $u_yesterday['by_e_from_c'] - $u_yesterday['by_e_from_b'] - ($sub_from_p * $u_yesterday['by_e_from_p']) - $u_yesterday['by_e_from_t']
                    + $n['by_e_from_c'] + $n['by_e_from_b'] + $n['by_e_from_p'] + $n['by_e_from_t'];
      $n['by_f'] = $u_yesterday['by_f'] - $u_yesterday['by_f_from_c'] - $u_yesterday['by_f_from_b'] - ($sub_from_p * $u_yesterday['by_f_from_p']) - $u_yesterday['by_f_from_t']
                    + $n['by_f_from_c'] + $n['by_f_from_b'] + $n['by_f_from_p'] + $n['by_f_from_t'];
      $n['by_u'] = $u_yesterday['by_u'] - $u_yesterday['by_u_from_c'] - $u_yesterday['by_u_from_b'] - ($sub_from_p * $u_yesterday['by_u_from_p']) - $u_yesterday['by_u_from_t']
                    + $n['by_u_from_c'] + $n['by_u_from_b'] + $n['by_u_from_p'] + $n['by_u_from_t'];

      if($j < $MONTH_SIZE - $TODAY_DAY) {
        // �������� �� ���������� ��� �������� ������ (�� ������� ����������� ����).
        $to_eom_sum['by_e'] += $n['by_e'];
        $to_eom_sum['by_f'] += $n['by_f'];
        $to_eom_sum['by_u'] += $n['by_u'];
      }

      if(($mc = $n['by_e'] + $n['by_f'] + $n['by_u']) > $cur_month_max_h)
        $cur_month_max_h = $mc;

      $next30_sum['by_e_from_c'] += $n['by_e_from_c'];
      $next30_sum['by_f_from_c'] += $n['by_f_from_c'];
      $next30_sum['by_u_from_c'] += $n['by_u_from_c'];
      $next30_sum['by_e_from_b'] += $n['by_e_from_b'];
      $next30_sum['by_f_from_b'] += $n['by_f_from_b'];
      $next30_sum['by_u_from_b'] += $n['by_u_from_b'];
      $next30_sum['by_e_from_p'] += $n['by_e_from_p'];
      $next30_sum['by_f_from_p'] += $n['by_f_from_p'];
      $next30_sum['by_u_from_p'] += $n['by_u_from_p'];
      $next30_sum['by_e_from_o'] += $n['by_e_from_o'];
      $next30_sum['by_f_from_o'] += $n['by_f_from_o'];
      $next30_sum['by_u_from_o'] += $n['by_u_from_o'];
      $next30_sum['by_e'] += $n['by_e'];
      $next30_sum['by_f'] += $n['by_f'];
      $next30_sum['by_u'] += $n['by_u'];
    }



    $mc = $to_eom_sum['by_e'] + $to_eom_sum['by_f'] + $to_eom_sum['by_u'];
    $u_month_sum['by_a'] += $mc;
    $u_month_sum['by_e'] += $to_eom_sum['by_e'];
    $u_month_sum['by_f'] += $to_eom_sum['by_f'];
    $u_month_sum['by_u'] += $to_eom_sum['by_u'];

    if($MONTH_SIZE != $TODAY_DAY && ($mc = $mc / ($MONTH_SIZE - $TODAY_DAY)) > $cur_year_max_h)
      $cur_year_max_h = $mc;


    // ������������ ��������� ������.
    $next_months = NULL;
    $K_ym = 1.1;
    for($i=$MONTH+1;$i<=12;$i++) {
      if($i==$MONTH+1) {
        // �� ������� ���� ��� ����, ����� ���� ������������ ����� �������� � ��������.
        // ���� ���������� ������� �� 30 ���� ����� ������ ��������� ��������� �� ��������� �����. ���� � ����. ������
        // 30 ����, � ������� ��������� ���� ������, �� � ��������� ����� ����������� ����� ���������� ����� �� 30 ����.
        // ��� ���������� ����� ���������� � �������.
        $next_months[$i]['by_e'] = $next30_sum['by_e'] + ceil($to_eom_sum['by_e'] * ($K_ym - 1)) + ($MSIZES[$i-1] - 30) * ceil($next30_sum['by_e'] / 30);
        $next_months[$i]['by_f'] = $next30_sum['by_f'] + ceil($to_eom_sum['by_f'] * ($K_ym - 1)) + ($MSIZES[$i-1] - 30) * ceil($next30_sum['by_f'] / 30);
        $next_months[$i]['by_u'] = $next30_sum['by_u'] + ceil($to_eom_sum['by_u'] * ($K_ym - 1)) + ($MSIZES[$i-1] - 30) * ceil($next30_sum['by_u'] / 30);
      }
      else {
        $next_months[$i]['by_e'] = ceil( ($next_months[$i-1]['by_e'] ? $next_months[$i-1]['by_e'] * $K_ym : $next30_sum['by_e']) );
        $next_months[$i]['by_f'] = ceil( ($next_months[$i-1]['by_f'] ? $next_months[$i-1]['by_f'] * $K_ym : $next30_sum['by_f']) );
        $next_months[$i]['by_u'] = ceil( ($next_months[$i-1]['by_u'] ? $next_months[$i-1]['by_u'] * $K_ym : $next30_sum['by_u']) );
      }
      if(($mc = ($next_months[$i]['by_e'] + $next_months[$i]['by_f'] + $next_months[$i]['by_u']) / $MSIZES[$i-1]) > $cur_year_max_h)
        $cur_year_max_h = $mc;
    }

  } // if(!$u_has_prm) ///////////////////////////////////////////////////////////////////////////////////


  $PS_STEP_PRICE = 150;

  
  $pro_price = payed::GetProPrice(true);

  $bmCls = getBookmarksStyles(promotion::BM_COUNT, $bm); // ������ ��������.


//////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////output///////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////

?>      
  <script type="text/javascript">
    var P=[<?=round($fp_price[0],2)?>,<?=round($fp_price['n'],2)?>,<?=round($fp_price[-1],2)?>,<?$pro_price[48]?>],pp={0:P[0]},AS=<?=round($account->sum,2);?>;
    <? if($prm_is_FP) { 
        ?>var PB=[<? $i=0;foreach($fp_ps as $ps) print(($ps['psum']+$PS_STEP_PRICE).',');?>0],ws=P[2],pls=0;<?
      } ?>
    function getTypePro( ) {
        for(i=0;i<$('payed-pro').elements['oppro'].length;i++) {
            if($('payed-pro').elements['oppro'][i].checked) {
                return $('payed-pro').elements['oppro'][i].value;
            }
        }
    }
    function prcm(th) { prrc(iv(th)<?// *P[3]?>); }
    function prrc(s) {
        $('prbuy').removeClass('b-button_rectangle_color_disable');
        if(!s||nmny(s)) {
            $('prbuy').addClass('b-button_rectangle_color_disable');
        }
        if(s == 5) {
            $('prbuy_text').set('html', '�������� �� ' + s + ' ���.');
        } else {
            $('prbuy_text').set('html', '������ �� ' + s + ' ���.');
        }
    }
    function fpcw(th) { $('fpw').innerHTML=(ws=P[2]*iv(th));fprc(); }
    function fpcpl(th) { var v;pls=0;if((v=iv(th,PB.length))>0)pls=PB[v-1];$('fppl').innerHTML=pls;fprc(); }
    function fprc() {
      var s=ws+pls;
      $('fpws').innerHTML=ws;
      $('fppls').innerHTML=pls;
      $('fpbid').value=pls;
      $('fpact').value=pls?'buyall':'buy';
      $('fpas').innerHTML=s;
      //$('fpbuy').disabled=!ws||nmny(s);
    }
    function ctgcp(th,c) { $('ps'+c).innerHTML=(pp[c]=P[!!c-0]*iv(th));ctgrc(); }
    function ctgrc() { var s=0;for(c in pp) s+=pp[c];$('ts').innerHTML=s;$('ctgbuy').disabled=!s||nmny(s); }
    function ctgdp(c) {
      var sb;if(!(sb=$('sb'+c))) return;
      delete pp[c];
      sb.parentNode.removeChild(sb);
      $('pr'+c).checked=false;ctgrc();
    }
    function ctgap(th) {
      var c=th.value-0;
      if(!th.checked) {ctgdp(c);return;}
      var p={id:c,n:c==0?'� ����� ��������':$('lb'+c).innerHTML,prc:(pp[c]=P[!!c-0])};
      $('sbxs').innerHTML+=<?=t_promotion::selBox()?>;ctgrc();
    }
    function cibywheel(obj,low,up,dir) {
      event.returnValue=false;
      if(!dir)dir=1;
      var cv=obj.value-0,dlt=event.wheelDelta;
      if(isNaN(cv))obj.value=0;
      else if(cv==low&&dlt<0||cv==up&&dlt>0);
      else obj.value=cv+(dlt>0?dir:-dir);
      return obj.value-0;
    }
    function iv(th,mx) {
      var nv=th.value.replace(/^[^1-9]+/,'').replace(/[^0-9]+$/,'');
      if((nv=isNaN(nv-0)?'':(nv>mx?mx:nv)).toString()!=th.value) th.value=nv;
      return(nv-0);
    }
    function nmny(s) { return false; }
    window.addEvent('domready', function() {
        if($('test_ico_quest')) {
            $('test_ico_quest').addEvent('click', function(event){
                event.stop();
                $('test_promo').toggleClass('b-shadow_hide');
            });

            $(document.body).addEvent('click', function() {
                $('test_promo').addClass('b-shadow_hide');
            });
        }
    });
  </script>
        <h1 class="b-page__title">����������</h1>

    
  
  <div id="header">
		<div class="b-menu b-menu_line">
				<ul class="b-menu__list">
						<li class="b-menu__item  b-menu__item_active">��������</li>
						<li class="b-menu__item b-menu__item_last"><a class="b-menu__link" href="?bm=<?=promotion::BM_GUESTS?><?=($DEBUG?"&user={$login}":'')?>">����������</a></li>
				</ul>
		</div>
  </div>



  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="promotion-tbl">
    <tr>
      <td style="background:#fff;" class=" promotion">


<? //// ����� /////////////////////////////////////////////////////////////// ?>

        <div class="b-layout b-layout_padtop_30">
            <div class="b-layout b-layout_inline-block b-layout_padright_30 b-layout_padbot_15" style="vertical-align:top">
                <? if(!$prm_is_PRO) { ?>
                  <div class="big-s">
                      <a href="/promotion/<?=($DEBUG?"?user={$login}":'')?>" class="blue">������� <b><?php if($u_is_profi): ?>PROFI<?php else: ?>PRO<?php endif; ?></b></a>
                  </div>
                <? } else { ?>
                  <div class="big-s">
                      ������� <b><?php if($u_is_profi): ?>PROFI<?php else: ?>PRO<?php endif; ?></b>
                  </div>
                <? } ?>
                <div class="sml-s lgray-c">
                  <?=($u_is_pro ? '�����������' : '�� �����������')?>
                </div>
            </div>
        </div>


<? //// ������ ////////////////////////////////////////////////////////////// ?>
      
        <div class="" style="padding:5px 0 30px 0px">
          <? if(!$u_has_prm) { ?>
            
          <? }

             else if($prm_is_CTG)
             {
               foreach($u_ps as $id=>$ps)
               {
                 if($id<0) continue;
                 if($id==0) $ps['name'] = '����� ��������';
                 else $ps['name'] = '������� "'.$ps['name'].'"';
                 $to_time = strtotime($ps['to_date']);
          ?>
            <div style="padding-top:20px">
              <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr style="vertical-align:middle">
                  <td class="big-s" style="font-family:Trebuchet MS;font-size:19px">
                    ����� � <?=$ps['name']?> �������� �� <?=date('d.m.y', $to_time)?>
                    <?
                      $end_day = date('Y-m-d', $to_time);
                      $days = ceil((strtotime($end_day) - $TODAY_TIME) / (24 * 3600));
                      if(!$days)
                        $s_days = '�������� �������';
                      else {
                        $s = getSymbolicName($days,'day',$et);
                        $s_days = '�����'.($et==1?'��':'���')." {$days} {$s}";
                      }
                    ?>
                    <span class="orange-c"><br/>(<?=$s_days?>)</span>
                  </td>
                  <td style="padding:0 55px 0 0; text-align:right"> </td>
                </tr>
              </table>
            </div>
          <?   } 

             } else { ?>

            <div class="big-s" style="padding:20px 0 0 0;font-family:Trebuchet MS;font-size:19px">
              <? if($prm_is_PRO) { ?>
                ������� 
                    <?php if($u_is_profi): ?> 
                        <?=view_profi('b-icon_top_4');?>
                    <?php else: ?>
                        <span style="position:relative; top:-2px;"><?=view_pro()?></span>
                    <?php endif; ?>
                ������� 
              <? } else { ?>
                ����� �� ������� ��������
              <? } ?>
              �� <?=date('d.m.y', $u_prm_end_time)?>
              <?
              $last_time = $u_prm_end_time;
              if(floor(($last_time-time())/(60*60*24)) > 0) {
                  $last_ending = floor(($last_time-time())/(60*60*24));
                  $last_string1 = '����';
                  $last_string2 = '���';
                  $last_string3 = '����';
              } else if (floor(($last_time-time())/(60*60)) > 0) {
                  $last_ending = floor(($last_time-time())/(60*60));
                  $last_string1 = '���';
                  $last_string2 = '����';
                  $last_string3 = '�����';
              } else {
                  $last_ending = floor(($last_time-time())/60);
                  $last_string1 = '������';
                  $last_string2 = '������';
                  $last_string3 = '�����';
              }
              $s_prm_days = '�������� ����� '.$last_ending.' '.ending($last_ending, $last_string1, $last_string2, $last_string3);
              ?>
              <span class="orange-c">(<?=$s_prm_days?>)</span>
            </div>

          <? } ?>
        </div>


<? //// ������� ���������� ////////////////////////////////////////////////// ?>

        <div style=" <?=(!$u_has_prm?'padding:45px 0 0 0px;':'padding:45px 0 0 0px;')?>">
          <div class="big-s" style="padding-bottom:15px">
            <?
              if($prm_is_PRO)
                print('���������'.(!$u_has_prm?' � ���������':'').' ��� '.(($u_is_profi)?view_profi('b-icon_top_5'):view_pro()));
              else if($prm_is_FP)
                print('���������'.(!$u_has_prm?' � ��������� ��� ������� ����� �� �������' : ''));
              else if($prm_is_CTG)
                print('���������'.(!$u_has_prm?' � ��������� ��� ������ ��������' : ''));
            ?>
            <? if($u_has_prm && $prm_is_PRO) { ?>
              <span class="norm-s lgray-c">�� <?=date('d.m.y', $u_prm_end_time)?></span>
            <? } ?>
          </div>
          <div class="tbl-promotion">
             <div class="b-layout b-layout_inline-block b-layout_margbot_20 tbl-prm-stat-wrap" style="vertical-align:top;">
                <table class="tbl-prm-stat" border="0" cellspacing="0" cellpadding="0" style="width:<?=(!$u_has_prm?600:460)?>px;table-layout:fixed">
                  <col/>
                  <col style="width:50px"/>
                  <col style="width:50px"/>
                  <col style="width:60px"/>
                  <col style="width:95px"/>
                  <? if(!$u_has_prm) { ?>
                    <col style="width:60px"/>
                    <col style="width:60px"/>
                    <col style="width:100px"/>
                  <? } ?>
                  <? // ����� ?>
                  <tr class="ac bb gray-bc" style="height:20px; vertical-align:top">
                    <td class=" b-layout__td_width_100_iphone">&nbsp;</td>
                    <td>�� ����</td>
                    <td>�����</td>
                    <td>�� 30 ����</td>
                    <td>�� ��� �����</td>
                    <? if(!$u_has_prm) { ?>
                      <td class="orange-c"><b>�������:</b></td>
                      <td class="orange-c"><b>������</b></td>
                      <td class="orange-c"><b>�� 30 ����</b></td>
                    <? } ?>
                  </tr>
                  <? // �������� ?>
                  <tr style="height:22px; vertical-align:bottom" class="bt white-bc">
                    <td class="lorange-bg b-layout__td_width_100_iphone" style="padding:3px 0 5px 5px">��������</td>
                    <td class="lorange-bg" style="padding-bottom:5px; padding-top:3px; text-align:center" ><b><a href="?bm=<?=promotion::BM_GUESTS?>" style="color:#666666"><?=$u_today['from_a']?></a></b></td>
                    <td class="lorange-bg" style="padding-bottom:5px;padding-top:3px; text-align:center" ><b><a href="?bm=<?=promotion::BM_GUESTS?>" style="color:#666666"><?=($u_yesterday['by_e']+$u_yesterday['by_f']+$u_yesterday['by_u'])?></a></b></td>
                    <td class="lorange-bg" style="padding-bottom:5px;padding-top:3px; text-align:center" ><b><?=$u_last30['from_a']?></b></td>
                    <td class="lorange-bg" style="padding-bottom:5px;padding-top:3px; text-align:center" ><b><?=$u_summary['from_a']?></b></td>
                    <? if(!$u_has_prm) { ?>
                      <td class="lorange-bg" style="padding-bottom:5px;padding-top:3px;">&nbsp;</td>
                      <td class="lorange-bg" style="padding-bottom:5px; text-align:center;padding-top:3px;" ><b class="green-c"><?=$next30[0]['by_e']?></b>/<b class="orange-c"><?=$next30[0]['by_f']?></b>/<b><?=$next30[0]['by_u']?></b></td>
                      <td class="lorange-bg" style="padding-bottom:5px; text-align:center;padding-top:3px;" ><b class="green-c"><?=$next30_sum['by_e']?></b>/<b class="orange-c"><?=$next30_sum['by_f']?></b>/<b><?=$next30_sum['by_u']?></b></td>
                    <? } ?>
                  </tr>
                  <?
                    $bg = !$u_has_prm ? 'lllgray-bg' : 'lorange-bg';
                  ?>
                  <? // �� �������� ?>
                  <tr style="height:18px" class="bt white-bc">
                    <td class="<?=$bg?> b-layout__td_width_100_iphone" style="padding-left:5px; padding-bottom:5px;padding-top:3px;">�� ��������</td>
                    <td class="<?=$bg?>"  style="text-align:center; padding-bottom:5px;padding-top:3px;"><?=$u_today['from_c']?></td>
                    <td class="<?=$bg?>"  style="text-align:center; padding-bottom:5px;padding-top:3px;"><?=($u_yesterday['by_e_from_c']+$u_yesterday['by_f_from_c']+$u_yesterday['by_u_from_c'])?></td>
                    <td class="<?=$bg?>"  style="text-align:center; padding-bottom:5px;padding-top:3px;"><?=$u_last30['from_c']?></td>
                    <td class="<?=$bg?>"  style="text-align:center; padding-bottom:5px;padding-top:3px;"><?=$u_summary['from_c']?></td>
                    <? if(!$u_has_prm) { ?>
                      <td class="lorange-bg">&nbsp;</td>
                      <td class="lorange-bg"  style="text-align:center; padding-bottom:5px;padding-top:3px;"><span class="green-c"><?=$next30[0]['by_e_from_c']?></span>/<span class="orange-c"><?=$next30[0]['by_f_from_c']?></span>/<span><?=$next30[0]['by_u_from_c']?></span></td>
                      <td class="lorange-bg"  style="text-align:center; padding-bottom:5px;padding-top:3px;"><span class="green-c"><?=$next30_sum['by_e_from_c']?></span>/<span class="orange-c"><?=$next30_sum['by_f_from_c']?></span>/<span><?=$next30_sum['by_u_from_c']?></span></td>
                    <? } ?>
                  </tr>
                  <? // �� ������ ?>
                  <? if (BLOGS_CLOSED == false) { ?>
                  <tr class="bt white-bc" style="height:18px">
                    <td class="<?=$bg?> b-layout__td_width_100_iphone" style="padding-left:5px; padding-bottom:5px;padding-top:3px;">�� ������</td>
                    <td class="<?=$bg?>"  style="text-align:center; padding-bottom:5px;padding-top:3px;"><?=$u_today['from_b']?></td>
                    <td class="<?=$bg?>"  style="text-align:center; padding-bottom:5px;padding-top:3px;"><?=($u_yesterday['by_e_from_b']+$u_yesterday['by_f_from_b']+$u_yesterday['by_u_from_b'])?></td>
                    <td class="<?=$bg?>"  style="text-align:center; padding-bottom:5px;padding-top:3px;"><?=$u_last30['from_b']?></td>
                    <td class="<?=$bg?>"  style="text-align:center; padding-bottom:5px;padding-top:3px;"><?=$u_summary['from_b']?></td>
                    <? if(!$u_has_prm) { ?>
                      <td class="lorange-bg">&nbsp;</td>
                      <td class="lorange-bg" style="text-align:center; padding-bottom:5px;padding-top:3px;"><span class="green-c"><?=$next30[0]['by_e_from_b']?></span>/<span class="orange-c"><?=$next30[0]['by_f_from_b']?></span>/<span><?=$next30[0]['by_u_from_b']?></span></td>
                      <td class="lorange-bg" style="text-align:center; padding-bottom:5px;padding-top:3px;"><span class="green-c"><?=$next30_sum['by_e_from_b']?></span>/<span class="orange-c"><?=$next30_sum['by_f_from_b']?></span>/<span><?=$next30_sum['by_u_from_b']?></span></td>
                    <? } ?>
                  </tr>
                  <? } ?>
                  <?
                    $bg = !$u_has_prm ? 'lllgray-bg' : 'lorange-bg';
                  ?>
                  
                  <? if($prm_is_CTG && !$u_has_prm) { ?>
                    <tr valign="top">
                      <td colspan="8" class="sml-s lgray-c" style="padding:10px 0 0 5px">
                        ������� ������������ � ������ ������� ���� �������� ����� � ����� ��������.<br/>
                        ���� �� ������ ����� ������ ������� ����� � ������ ��������, ������������ ���������� ��� ������.
                      </td>
                    </tr>
                  <? } ?>
                </table>
             </div>
             <div class="b-layout b-layout_inline-block b-layout_padleft_30 b-layout__one_width_full_ipad b-layout__td_pad_null_ipad" style="vertical-align:top">
                <table border="0" cellspacing="0" cellpadding="0" style="width:215px">
                  <tr class="bb gray-bc" style="height:20px; vertical-align:top">
                    <td><b>�����&nbsp;�&nbsp;��������</b></td>
                    <? if(!$u_is_pro) { ?>
                      <td style="text-align:right"><b>������</b></td>
                    <? } ?>
                    <td <?=(!$u_is_pro ? '' : ' colspan="2"')?> style="text-align:right; white-space:nowrap">
                      <?=(!$u_is_pro ? '&nbsp;' : '<b>������ � </b> ').(($u_is_profi)?view_profi():view_pro())?>
                    </td>
                  </tr>
                  <? 
                    if($u_ctlg_pos)
                    {
                      $i=0;
                      foreach($u_ctlg_pos as $p) 
                      {
                        $pt=$i?1:4;
                        if($p['link']!="") $p['link'] .= "/";
                  ?>
                    <tr style="vertical-align:top">
                      <td style="padding-top:<?=$pt?>px; white-space:nowrap; padding-bottom:4px;">
                        <div style="width:100%;text-overflow:ellipsis;overflow:hidden">
                            <a href="/freelancers/<?=$p['link'].freelancer::getPositionToPage($p['pos'])?>" title="<?=$p['prof_name']?>" class="blue"><?=LenghtFormatEx($p['prof_name'], 24, '...', 1)?></a>
                        </div>
                      </td>
                      <? if(!$u_is_pro) { ?>
                        <td style="padding-top:<?=$pt?>px; text-align:right; padding-bottom:4px;"><?=$p['pos']?></td>
                      <? } ?>
                      <td style="padding-top:<?=$pt?>px; text-align:right; padding-bottom:4px;" class="orange-c" <?=(!$u_is_pro ? '' : ' colspan="2"')?>>
                        <?=(!$u_is_pro ? $p['propos'] : $p['pos'])?>
                      </td>
                    </tr>
                    <?
                      }
                    ?>
                    <tr valign="top">
                      <td colspan="3" style="padding-top:10px" class="sml-s">
                        ����� ������� ���� ������� ����� � ��������<br />��������.
                        <? if(!$u_is_pro) { ?><span class="orange-c">� ��, ������� �� ������ ������,<br />������ ���������� <b>PRO</b></span><? } ?>
                      </td>
                    </tr>
                  <?
                    } 
                  ?>
                </table>
             </div>
          </div>
          
          <!-- WORDS STAT BEGIN -->
          <br/>
          <a href="javascript:void(0)" onclick="$('ov-pst').toggleClass('b-shadow_hide');" class="blue">���������� ��������� �� �������� ������</a>
          <?php $aWordsStat = promotion::getWordsSummary( $uid ); ?>
<script type="text/javascript">
function toggleTypeStatKeyword(type) {
    if(type == 1) {
        $$('.stat-link-disabled').removeClass('global_hide'); 
        $('l2').set('html', '��� �������� �����');
        $('l1').set('html', '<a href="javascript:void(0);" onclick="toggleTypeStatKeyword(0)">������ ��������</a>');
    } else {
        $$('.stat-link-disabled').addClass('global_hide'); 
        $('l1').set('html', '������ ��������');
        $('l2').set('html', '<a href="javascript:void(0);" onclick="toggleTypeStatKeyword(1)">��� �������� �����</a>');
    }
}
</script> 

        <div id="ov-pst" class="b-shadow b-shadow_center b-shadow_zindex_11 b-shadow_hide" style="display:block;">
          <div class="b-shadow__body b-shadow__body_bg_fff b-shadow__body_pad_15">
            <a href="javascript:void(0)" onclick="$('ov-pst').toggleClass('b-shadow_hide');"><img src="<?=WDCPREFIX?>/images/btn-remove2.png" alt="" class="ov-pst-close" /></a>
            <h4>���������� ��������� �� �������� ������</h4>
            <ul class="select-word-stat c">
                <li id="l1">������ ��������</li>
                <li id="l2"><a href="javascript:void(0);" onclick="toggleTypeStatKeyword(1)">��� �������� �����</a></li>
            </ul>
            <?php if ( $aWordsStat ): ?>
            <div class="ov-pst-tbl">
              <table>
              <thead>
              <tr>
                  <th>��������&nbsp;�����</th>
                  <td>��&nbsp;����<!-- <a href="" class="lnk-dot-666">�� ����</a> --></td>
                  <td>�����</td>
                  <td>��&nbsp;30&nbsp;����</td>
                  <td class="csum">�����</td>
              </tr>
              </thead>
              <tbody>
              <?php foreach ( $aWordsStat as $aWord ): ?>
              <tr <?= ($aWord['is_active']==null?"class='stat-link-disabled global_hide'":"")?>>
                  <th class="key-word-th"><a <?= ($aWord['is_active']==null?"title='�������������� �������� �����'":"")?> href="/freelancers/?word=<?=$aWord['word_name']?>"><?=str_replace( array('<','>'), array('&lt;','&gt;'), $aWord['word_name'])?></a></th>
                  <td><?=(int)$aWord['total_today_cnt']<0?0:intval($aWord['total_today_cnt'])?></td>
                  <td><?=(int)$aWord['total_yesterday_cnt']<0?0:intval($aWord['total_yesterday_cnt'])?></td>
                  <td><?=(int)$aWord['total_30_cnt']<0?0:intval($aWord['total_30_cnt'])?></td>
                  <td class="csum"><?=intval($aWord['total_cnt'])?></td>
              </tr>
              <?php endforeach; ?>
                                  </tbody>
              </table>
            </div>
            <?php else: ?>
            ��� ������ ��� �����������.
            <?php endif; ?>
          </div>
        </div>


      
          
          <!-- WORDS STAT END -->

        </div>

<? //// ������ �� ������� ����� ���� //////////////////////////////////////// ?>

        <div style="padding:65px 0 0 0px">
          <div class="big-s" style="padding-bottom:10px">
            ������ ��������� �� <?=$MNAMES[$MONTH-1]?>
            <? 
              if(!$u_has_prm) {
                if($prm_is_FP) print('� ��������� ��� ������� ����� �� �������');
                else if($prm_is_CTG) print('� ��������� ��� ������ ��������');
              }
            ?>
          </div>
          <div class="grafik">
            <table border="0" cellspacing="1" cellpadding="0" style="table-layout:fixed"  class="grafik-tbl">
              <? for($k=1;$k<=$MONTH_SIZE;$k++) { ?><col/><? } ?>
              <tr>
                <?
                  if(!$u_has_prm)
                  {
                    if($TODAY_DAY != $MONTH_SIZE) {
                      $noprm_cs = $TODAY_DAY;
                      $prm_cs   = $MONTH_SIZE - $noprm_cs;
                      $m_cnt_right = $prm_cs;
                      if($prm_is_PRO) {
                        $t = '<b>�������</b> ��������� � ��������� '.view_pro();
                        $t_w = 204;
                        $t_ml = -201;
                        $minc = 9; // ��� 31 ���, � ���� � ������ 30 ����, �� ����� ���� � 8 � �.�.
                      }
                      else if($prm_is_FP) {
                        $t = '<b>�������</b> ��������� � ������� ������ �� �������';
                        $t_w = 259;
                        $t_ml = -259;
                        $minc = 11;
                      }
                      else if($prm_is_CTG) {
                        $t = '<b>�������</b> ��������� � ������� ������ � ����� ��������';
                        $t_w = 295;
                        $t_ml = -295;
                        $minc = 12 + ($MONTH_SIZE==31);
                      }
                ?>
                      <td colspan="<?=$noprm_cs?>">&nbsp;</td>
                      <td colspan="<?=$prm_cs?>" style=" vertical-align:bottom;border-bottom:2px solid #ff6d1b"<?=($m_cnt_right < $minc ? ' align="right"' : '')?>>
                        <div style=" float:left;width:<?=$t_w?>px<?=($m_cnt_right < $minc ? ";margin-left:{$t_ml}px" : '')?>">
                        <span class="orange-c" style=" float:left;">
                          <?=$t?>
                        </span></div>
                      </td>
                <?  }
                  }
                  else
                  {
                    $lp_ftime = strtotime($u_last_prm_period['from_time']);
                    $noprm_cs = NULL;
                    if(date('Y-m', $lp_ftime).'-01'==$MONTHDAY)
                      $noprm_cs = date('j',$lp_ftime) - 1;
                    $prm_to = $MONTH_SIZE;
                    if(date('Y-m',$u_prm_end_time).'-01'==$MONTHDAY)
                      $prm_to = date('j', $u_prm_end_time);
                    $prm_cs   = $prm_to - $noprm_cs;
                    $m_cnt_right = $MONTH_SIZE - $noprm_cs;
                    if($prm_is_PRO) {
                      $t = '����� ������� �������� '.(($u_is_profi)?view_profi():view_pro()).'<span class="lgray-c"> �� '.date('d.m.y', $u_prm_end_time).'</span>';;
                      $t_w = 221;
                      $t_ml = -221;
                      $minc = 10;
                    }
                    else if($prm_is_FP) {
                      $t = '����� ������� ����� �� ������� <span class="lgray-c"> �� '.date('d.m.y', $u_prm_end_time).'</span>';;
                      $t_w = 229;
                      $t_ml = -229;
                      $minc = 10;
                    }
                    else if($prm_is_CTG) {
                      $t = '����� ������� ����� � �������� <span class="lgray-c"> �� '.date('d.m.y', $u_prm_end_time).'</span>';;
                      $t_w = 229;
                      $t_ml = -229;
                      $minc = 10;
                    }
                ?>
                    <? if($noprm_cs) { ?>
                      <td colspan="<?=$noprm_cs?>">&nbsp;</td>
                    <? } ?>
                    <td colspan="<?=$prm_cs?>" style=" vertical-align:bottom;border-bottom:2px solid #ff6d1b"<?=($m_cnt_right < $minc ? ' align="right"' : '')?>>
                      <div style="float:left;width:<?=$t_w?>px<?=($m_cnt_right < $minc ? ";margin-left:{$t_ml}px" : '')?>">
                      <span class="orange-c" style=" float:left;">
                        <?=$t?>
                      </span></div>
                    </td>
               <? } ?>
              </tr>
              <tr class="ac"  style="height:140px; vertical-align:bottom">
  
                <?
                  $uppc = 0;
                  $u_has_prm_period = FALSE;
                  $K_h = $cur_month_max_h ? 90 / $cur_month_max_h : 0;
  
                  // ��� ��������� ���.
                  foreach($u_month as $dnum=>$d) {
                    $cday = date('Y-m-d', strtotime($YEAR.'-'.$MONTH.'-'.$dnum));
                    if($cday==substr($u_m_prm_periods[$uppc]['from_time'],0,10)) $u_has_prm_period = TRUE;
                    print( $u_has_prm_period ? t_promotion::proCol($colh, $K_h, $d['by_e'], $d['by_f'], $d['by_u'], NULL, TRUE)
                                          : t_promotion::noProCol($colh, $K_h, $d['by_e'] + $d['by_f'] + $d['by_u'], NULL, TRUE)  );
                    if($cday==substr($u_m_prm_periods[$uppc]['to_time'],0,10)) { $u_has_prm_period = FALSE; $uppc++; }
                  }
  
                  // ����������� ����.
                  // !!! �� ��� ���, ��������, ���� ���������� �������, ���� ��� ��� ���������. ���� ���� ������� ��� ����������.
                  if($TODAY==substr($u_m_prm_periods[$uppc]['to_time'],0,10)) { $u_has_prm_period = FALSE; $uppc++; }
                  if($TODAY==substr($u_m_prm_periods[$uppc]['from_time'],0,10)) $u_has_prm_period = TRUE;
                  print( $u_has_prm_period || $u_has_prm ? t_promotion::proCol($colh, $K_h, $u_today['by_e'], $u_today['by_f'], $u_today['by_u'], NULL, TRUE)
                                                   : t_promotion::noProCol($colh, $K_h, $u_today['by_e'] + $u_today['by_f'] + $u_today['by_u'], NULL, TRUE)  );
  
                  if(!$u_has_prm) {
                    // ������� ���.
                    $ns = $MONTH_SIZE - $TODAY_DAY;
                    foreach($next30 as $d) {
                      if(--$ns<0) break;
                      print( t_promotion::proCol($colh, $K_h, $d['by_e'], $d['by_f'], $d['by_u'], NULL, TRUE) );
                    }
                  }
                  else {
                    // ��� �� ����� ������ (������).
                    // � ��� �������, �.�. �������� ��� ���������.
                    for($i=$TODAY_DAY+1;$i<=$MONTH_SIZE;$i++) {
                      $cday = date('Y-m-d', strtotime($YEAR.'-'.$MONTH.'-'.$i));
                      if($cday==substr($u_m_prm_periods[$uppc]['from_time'],0,10)) $u_has_prm_period = TRUE;
                      print( $u_has_prm_period ? t_promotion::proCol($colh, 0,0,0,0, NULL) : t_promotion::noProCol($colh, 0,0,0,0, NULL)  );
                      if($cday==substr($u_m_prm_periods[$uppc]['to_time'],0,10)) { $u_has_prm_period = FALSE; $uppc++; }
                    }
                  }
                ?>
              </tr>
              <tr><td></td></tr>
              <tr class="ac llgray-c">
                <?
                    for($i=1;$i<=$MONTH_SIZE;$i++) {
                      $week_day_now = date("w", strtotime(date("Y-m-$i")));
                      if ($week_day_now == 6 || $week_day_now == 0) $day_color = " style=\"color:#ff6d1b\"";
                      elseif ($i==$TODAY_DAY) $day_color = " style=\"color:#666666\"";
                      else $day_color = "";
                      print "<td{$day_color}>{$i}</td>";
                    }
                ?>
              </tr>
            </table>
          </div>
        </div>


<? //// ������ �� ������� ��� /////////////////////////////////////////////// ?>

        <div style="padding:65px 0 0 0px">
          <div class="big-s" style="padding-bottom:10px">
            �� <?=$YEAR?> ���
            <? 
              if(!$u_has_prm) {
                if($prm_is_FP) print('� ��������� ��� ������� ����� �� ������� �� ����� �������� ������');
                else if($prm_is_CTG) print('� ��������� ��� ������ �������� �� ����� �������� ������');
              }
            ?>
          </div>
          <? 
            $y_table_cols = '';
            $y_table_width = 0;
            for($i=0;$i<12;$i++) { 
              if($i==$MONTH-1 && !$u_has_prm) {
                $y_table_cols .= '<col style="width:'.($TODAY_DAY*2 + 1).'px"/><col style="width:'.(($MONTH_SIZE - $TODAY_DAY)*2).'px"/>';
                continue;
              }
              $y_table_cols .= '<col style="width:'.($MSIZES[$i]*2 + 1).'px"/>';
              $y_table_width += $MSIZES[$i]*2 + 1;
            }
          ?>
          <div class="grafik">
              <table border="0" cellspacing="0" cellpadding="0" style="width:<?=$y_table_width?>px;table-layout:fixed" class="grafik-tbl">
                <?=$y_table_cols?>
                <tr>
                  <? 
                    if(!$u_has_prm)
                    {
                      if(!($TODAY_DAY==$MONTH_SIZE && $MONTH==12)) {
                        $noprm_cs = $MONTH;
                        $prm_cs   = 12 - $noprm_cs + 1;
                        $m_cnt_right = 12 - $noprm_cs + ($MONTH_SIZE - $TODAY_DAY) / $MONTH_SIZE; // ������� ������� �������� �� ������� ���� �������.
                        if($prm_is_PRO) {
                          $t = '<b>�������</b> ��������� � ��������� '.view_pro();
                          $t_w = 204;
                          $t_ml = -201;
                          $minc = 3.3; // �� ����, 3.3 ������� ������, ����� ���������� ����� �������.
                        }
                        else if($prm_is_FP) {
                          $t = '<b>�������</b> ��������� � ������� ������ �� �������';
                          $t_w = 259;
                          $t_ml = -259;
                          $prm_cs = 1;
                          $minc = 4.3;
                        }
                        else if($prm_is_CTG) {
                          $t = '<b>�������</b> ��������� � ������� ������ � ����� ��������';
                          $t_w = 295;
                          $t_ml = -295;
                          $prm_cs = 1;
                          $minc = 5;
                        }
                  ?>
                        <td colspan="<?=$noprm_cs?>">&nbsp;</td>
                        <td colspan="<?=$prm_cs?>" style=" vertical-align:bottom;border-bottom:2px solid #ff6d1b"<?=($m_cnt_right < $minc ? ' align="right"' : '')?>>
                          <div style="float:left;width:<?=$t_w?>px<?=($m_cnt_right < $minc ? ";margin-left:{$t_ml}px" : '')?>">
                          <span class="orange-c" style=" float:left;">
                            <?=$t?>
                          </span></div>
                        </td>
                 <?   }
                    }
                    else
                    {
                      $u_last_prm_right = $y_table_width - $u_last_prm_left;
                      if(!$u_last_prm_width)
                        $u_last_prm_width = $u_last_prm_right;
                      if($prm_is_PRO) {
                        $t = '����� ������� �������� '.(($u_is_profi)?view_profi():view_pro()).'<span class="lgray-c"> �� '.date('d.m.y', $u_prm_end_time).'</span>';
                        $t_w = 221;
                      }
                      else if($prm_is_FP) {
                        $t = '����� ������� ����� �� ������� <span class="lgray-c"> �� '.date('d.m.y', $u_prm_end_time).'</span>';
                        $t_w = 229;
                      }
                      else if($prm_is_CTG) {
                        $t = '����� ������� ����� � �������� <span class="lgray-c"> �� '.date('d.m.y', $u_prm_end_time).'</span>';;
                        $t_w = 229;
                      }
                 ?>   
                      <td colspan="12">
                        <div style="padding-left:<?=$u_last_prm_left?>px">
                          <div class="orange-c" style="position:absolute;width:<?=$t_w?>px<?=($u_last_prm_right < $t_w ? ';margin-left:'.($u_last_prm_width - $t_w).'px' : '')?>">
                            <?=$t?>
                          </div>
                          <div style="width:<?=$u_last_prm_width?>px;margin-bottom:1px;border-bottom:2px solid #ff6d1b">&nbsp;</div>
                        </div>
                      </td>
                 <?
                    }
                 ?>
                </tr>
                <tr  style="height:140px; vertical-align:bottom">
                  <?
                    $is_y_prm_period = FALSE;
                    $uppc = 0;
                    $K_mh = $cur_year_max_h ? 60 / $cur_year_max_h : 0;
    
                    for($i=1;$i<=12;$i++)
                    { 
                      $m_count = $MSIZES[$i-1];
    
                      // 1. ���������� ������.
                      if($m = $u_year[$i])
                      {
                      
                        $by_e_arr = t_promotion::pg2php_arr($m['by_e']);
                        $by_f_arr = t_promotion::pg2php_arr($m['by_f']);
                        $by_u_arr = t_promotion::pg2php_arr($m['by_u']);
                        $by_e = array_sum($by_e_arr);
                        $by_f = array_sum($by_f_arr);
                        $by_u = array_sum($by_u_arr);
                        $by_a = $by_e + $by_f + $by_u;
                   ?>
                        <td class="lgray-bg bl white-bc">
                          <table class="table-statist" border="0" cellspacing="0" cellpadding="0"  style="height:100%">
                            <tr class="ac" style="vertical-align:bottom">
                              <?
                                $max_h = 0;
                                $pro_cnt = 0;
                                for($j=0;$j<$m_count;$j++)
                                {
                                  $cday = date('Y-m-d', strtotime($YEAR.'-'.$i.'-'.($j+1)));
                                  if($cday==substr($u_y_prm_periods[$uppc]['from_time'],0,10)) $is_y_prm_period = TRUE;
                                  $pro_cnt+=$is_y_prm_period;
                                  print( $is_y_prm_period ? t_promotion::proCol($colh, $K_mh, $by_e_arr[$j], $by_f_arr[$j], $by_u_arr[$j])
                                                          : t_promotion::noProCol($colh, $K_mh, $by_e_arr[$j] + $by_f_arr[$j] + $by_u_arr[$j])  );
                                  if($colh>$max_h)
                                    $max_h = $colh;
                                  if($cday==substr($u_y_prm_periods[$uppc]['to_time'],0,10)) { $is_y_prm_period = FALSE; $uppc++; }
                                } 
                              ?>
                            </tr>
                          </table>
                          <div style="position:absolute;width:<?=($m_count*2)?>px;text-align:center;margin-top:-<?=(($pro_cnt?3:1) * 13 + $max_h + 3)?>px">
                            <? if($pro_cnt) { ?>
                              <div class="green-c"><?=$by_e?></div>
                              <div class="orange-c"><?=$by_f?></div>
                              <div style="padding-bottom:3px"><?=$by_u?></div>
                            <? } else print($by_a); ?>
                          </div>
                        </td>
    
                   <?   continue;
    
                      }
    
    
                      // 2. ������� �����.
                      else if($i==$MONTH)
                      {
                   ?>   
                        <td class="lgray-bg bl white-bc">
                          <table class="table-statist" border="0" cellspacing="0" cellpadding="0" width="100%" style="table-layout:fixed; height:100%">
                            <? for($k=1;$k<=$m_count;$k++) { ?><col style="width:2px"/><? } // ���������� ��������� ��������������
                                                                                            // ������ ���� ������� ?>
                            <tr class="ac" style="vertical-align:bottom">
                              <?
                                $next_days = NULL;
                                $max_h = 0;
                                // �� ������������ ���.
                                foreach($u_month as $dnum=>$d)
                                {
                                  $cday = date('Y-m-d', strtotime($YEAR.'-'.$MONTH.'-'.$dnum));
                                  if($cday==substr($u_y_prm_periods[$uppc]['from_time'],0,10)) $is_y_prm_period = TRUE;
                                  print( $is_y_prm_period ? t_promotion::proCol($colh, $K_mh, $d['by_e'], $d['by_f'], $d['by_u'])
                                                          : t_promotion::noProCol($colh, $K_mh, $d['by_e'] + $d['by_f'] + $d['by_u'])  );
                                  if($colh>$max_h)
                                    $max_h = $colh;
                                  if($cday==substr($u_y_prm_periods[$uppc]['to_time'],0,10)) { $is_y_prm_period = FALSE; $uppc++; }
                                } 
    
                                // ����������� ����.
                                if($TODAY==substr($u_y_prm_periods[$uppc]['from_time'],0,10)) $is_y_prm_period = TRUE;
                                print( $is_y_prm_period ? t_promotion::proCol($colh, $K_mh, $u_today['by_e'], $u_today['by_f'], $u_today['by_u'])
                                                                   : t_promotion::noProCol($colh, $K_mh, $u_today['from_a'])  );
                                if($colh>$max_h)
                                  $max_h = $colh;
                                if($TODAY==substr($u_y_prm_periods[$uppc]['to_time'],0,10)) { $is_y_prm_period = FALSE; $uppc++; }
    
                                if($u_has_prm) {
                                  for($k=$TODAY_DAY+1;$k<=$m_count;$k++) {
                                    $cday = date('Y-m-d', strtotime($YEAR.'-'.$i.'-'.$k));
                                    if($cday==substr($u_y_prm_periods[$uppc]['from_time'],0,10)) $is_y_prm_period=true;
                                    print( $is_y_prm_period ? t_promotion::proCol($colh, 0,0,0,0)
                                                            : t_promotion::noProCol($colh, 0,0)  );
                                    if($cday==substr($u_y_prm_periods[$uppc]['to_time'],0,10)) { $is_y_prm_period=false; $uppc++; }
                                  }
                                }
    
                                if(!$u_has_prm) {
                                  // ���������� ������ �� ��� �� ����� �������� ������.
                                  $dcnt = $MONTH_SIZE - $TODAY_DAY;
                                  $next_days = t_promotion::proCol($colh, ($dcnt ? $K_mh / $dcnt : 0), $to_eom_sum['by_e'], $to_eom_sum['by_f'], $to_eom_sum['by_u']);
                                  if($colh>$max_h)
                                    $max_h = $colh;
                                }
                              ?>
                            </tr>
                          </table>
                          <div style="position:absolute;width:<?=($m_count*2)?>px;text-align:center;margin-top:-<?=(($u_has_prm?3:1)*13+$max_h+3)?>px">
                            <? if($u_has_prm) { ?>
                              <div class="green-c"><?=$u_month_sum['by_e']?></div>
                              <div class="orange-c"><?=$u_month_sum['by_f']?></div>
                              <div style="padding-bottom:3px"><?=$u_month_sum['by_u']?></div>
                            <? } else print($u_month_sum['by_a']); ?>
                          </div>
                        </td>
                   <?
                        if($next_days) {
                          // ���������� ������ �� ��� �� ����� �������� ������.
                          print($next_days);
                        }
    
                        continue;
                      }
    
    
                      // 3. ������� ������.
                      else if($i>$MONTH) {
                        if(!$u_has_prm && $prm_is_PRO) {
                          print(t_promotion::proCol($colh, $K_mh/$MSIZES[$i-1], $next_months[$i]['by_e'], $next_months[$i]['by_f'], $next_months[$i]['by_u'], NULL, TRUE, 'ac bl white-bc'));
                          continue;
                        }
                        // ����� ���� � 4.
                      }
    
    
                      // 4. ������, ��� ��� ������������ ������. ���� �� ��������� � ������ �������� ��� �������� -- ��� ��� -- ���������, ��������� �����.
                      if($u_y_prm_periods
                          && strtotime($YEAR.'-'.$i.'-'.$m_count) >= strtotime($u_y_prm_periods[0]['from_day'])
                          && strtotime($YEAR.'-'.$i.'-01') <= strtotime($u_last_prm_period['to_day'])
                        )
                      { 
                   ?>
                        <td class="lgray-bg bl white-bc">
                          <table border="0" cellspacing="0" cellpadding="0" width="100%" style="table-layout:fixed;height:140px">
                            <? for($k=1;$k<=$m_count;$k++) { ?><col style="width:2px"/><? } // ������������ ������. ?>
                            <tr class="ac" style="vertical-align:bottom">
                              <?
                                  $upp_state = $is_y_prm_period;
                                  $last_col = 0;
                                  for($k=1;$k<=$m_count;$k++) {
                                    $cday = date('Y-m-d', strtotime($YEAR.'-'.$i.'-'.$k));
                                    if($cday==substr($u_y_prm_periods[$uppc]['from_time'],0,10)) $cols[$k]=$is_y_prm_period=true;
                                    if($upp_state != $is_y_prm_period) {
                                      if($cs = $k - ($last_col+1)) {
                                        print($upp_state ? t_promotion::proCol($colh, 0,0,0,0, $cs) : t_promotion::noProCol($colh, 0,0,$cs));
                                        $last_col += $cs;
                                      }
                                    }
                                    $upp_state = $is_y_prm_period;
                                    if($cday==substr($u_y_prm_periods[$uppc]['to_time'],0,10)) { $cols[$k]=$is_y_prm_period=false; $uppc++; }
                                  }
                                  if($cs = $m_count - $last_col) {
                                    print($upp_state ? t_promotion::proCol($colh, 0,0,0,0, $cs) : t_promotion::noProCol($colh, 0,0,$cs));
                                  }
                              ?>
                            </tr>
                          </table>
                        </td>
                   <? }
                      else
                        print(t_promotion::noProCol($colh, 0,0,NULL,FALSE,'bl white-bc'));
                    } ?>
                </tr>
                <tr><td></td></tr>
                <tr class="ac llgray-c">
                  <? for($i=1;$i<=12;$i++) { ?>
                    <td<?=($i==$MONTH ? (!$u_has_prm ? ' colspan="2"' : '').' style="color:#666666"' : '')?>><?=$MNAMES[$i-1]?><div style="padding-top:2px"><? 
                      if($u_month_msgs[$i]) { ?><img src="/images/ico_mail_green.gif" alt="" />&nbsp;<b class="green-c"><?=$u_month_msgs[$i]?></b><? } 
                      ?>&nbsp;</div></td>
                  <? } ?>
                </tr>
              </table>
          </div>
        </div>

<? if($show_rating) include('graph.php'); ?>

<? //// ��� ///////////////////////////////////////////////////////////////// ?>

        <div style="margin-top:40px;padding:20px;background:#f7f7f7">
          <table class="b-layout__table" border="0" cellspacing="0" cellpadding="0">
            <col style="width:335px"/>
            <col style="width:68px"/>
            <col style="width:380px"/>
            <tr class="b-layout__tr">
              <td class="b-layout__td b-layout__td_padright_35 b-layout__td_pad_null_ipad" rowspan="8" style="vertical-align:top;">
                ���������� ��������� � ��� �������.<br/><br/>
                �������� �������� �� ������ ���������� �����, ������� �� ����������� � �����, � ������������ ���������� ���������������.<br /><br />
                ������������� ����������� ���������� 30%.
              </td>
              <td class="b-layout__td b-layout__td_width_full_ipad" style="vertical-align:middle"><span class="b-page__desktop"><div style="width:4px;height:4px;background:#c1c1c1;overflow:hidden; bottom:-1px;position:relative;"></div></span></td>
              <td class="b-layout__td sml-s lgray-c b-layout__td_width_full_ipad">
                �� ������ ���������� ���������� �����������
              </td>
            </tr>
            <tr class="b-layout__tr">
              <td class="b-layout__td b-layout__td_width_null_ipad">&nbsp;</td>
              <td class="b-layout__td sml-s lgray-c b-layout__td_padtop_10 b-layout__td_width_full_ipad">
                ��� PRO ���������� ���������� �������� ������� �� ���������� ������������
              </td>
            </tr>
            <tr class="b-layout__tr">
              <td class="b-layout__td b-layout__td_width_null_ipad" style="vertical-align:middle"><span class="b-page__desktop"><div style="width:4px;height:4px;background:#ff9c46;overflow:hidden; bottom:-1px;position:relative;"></div></span></td>
              <td class="b-layout__td sml-s orange-c b-layout__td_width_full_ipad">
                ��������� &ndash; ���� �����������
              </td>
            </tr>
            <tr class="b-layout__tr">
              <td class="b-layout__td b-layout__td_width_null_ipad" style="vertical-align:middle"><span class="b-page__desktop"><div style="width:4px;height:4px;background:#7eb710;overflow:hidden; bottom:-1px;position:relative;"></div></span></td>
              <td class="b-layout__td sml-s green-c b-layout__td_width_full_ipad">
                ������� &ndash; ���� ����������
              </td>
            </tr>
            <tr class="b-layout__tr">
              <td class="b-layout__td b-layout__td_width_null_ipad" style="vertical-align:middle"><span class="b-page__desktop"><div style="width:4px;height:4px;background:#666666;overflow:hidden; bottom:-1px;position:relative;"></div></span></td>
              <td class="b-layout__td sml-s b-layout__td_width_full_ipad">
                �����-����� &ndash; ���� ������������������ �������������
              </td>
            </tr>
            <tr class="b-layout__tr">
              <td class="b-layout__td b-layout__td_padtop_10 b-layout__td_width_full_ipad">67</td>
              <td class="b-layout__td sml-s lgray-c b-layout__td_padtop_10 b-layout__td_width_full_ipad">
                ����� ����� ���������� � �����������, ���������� �������
              </td>
            </tr>
            <tr class="b-layout__tr">
              <td class="b-layout__td b-layout__td_padtop_10 b-layout__td_width_full_ipad"><span class="green-c">20</span>/<span class="orange-c">107</span>/<span>32</span></td>
              <td class="b-layout__td sml-s lgray-c b-layout__td_padtop_10 b-layout__td_width_full_ipad">
                ��� <span class="green-c">20</span> &ndash; ���������� ���������� ��� ������� ����������,
                <span class="orange-c">107</span> &ndash; �����������,<br/>
                <span style="color:#666666">32</span>&nbsp;&ndash; ������������������ �������������
              </td>
            </tr>
            <tr class="b-layout__tr">
              <td class="b-layout__td b-layout__td_padtop_10 b-layout__td_width_full_ipad">
                <img src="/images/ico_mail_green.gif" alt="" />&nbsp;<b class="green-c"><?=intval($u_month_msgs[date('n')])?></b>
              </td>
              <td class="b-layout__td sml-s lgray-c b-layout__td_width_full_ipad" style="padding-top:12px">
                ����� ����������, ���������� � ���� ������
              </td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
  </table>