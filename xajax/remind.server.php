<?
$rpath = "../";
require_once($_SERVER['DOCUMENT_ROOT'] . "/xajax/remind.common.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/smail.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/users.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/captcha.php");

function RemindByEmail($email, $rnd, $captchanum, $role){
    global $DB;
	session_start();
	$objResponse = new xajaxResponse();
    $captcha = new captcha($captchanum);

    $error_type = '';
    $show_role = false;

    if(!$captcha->checkNumber(trim($rnd))) {
        $error = "�� ����� �������� ���������� ��������. ���������� ��� ���";
        $error_type = 'captcha';
    } else {
        require_once($_SERVER['DOCUMENT_ROOT'] . '/classes/sbr_meta.php');
        require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/sms_gate_a1.php");
        $email = trim(stripslashes($email));
        if (preg_match( "/^[-^!#$%&'*+\/=?`{|}~.\w]+@[-a-zA-Z0-9]+(\.[-a-zA-Z0-9]+)+$/", $email) ) {
            $error_type = 'email';
            $ok_type = 'email';
            // email
            require_once ($_SERVER['DOCUMENT_ROOT'] . '/classes/users.php');
            $u = new users();
            $u->GetUser($email, true, $email);
            if (!$u->uid) {
                $error = "E-mail �� ���������������. ������� ���������� �����/�������/e-mail.";
            } else {
                if($u->is_banned) {
                    $error = "������� � ���� ������� ������������. � ���������, �� �� ������ ������������ � ���� ������.";
                } else {
                    if($u->isRemindByPhoneOnly($u->login)) {
                        $ok_type = 'phone';
                        $reqv = sbr_meta::getUserReqvs($u->uid);
                        $ureqv = $reqv[$reqv['form_type']];
                        $phone = $ureqv['mob_phone'];
                        $passwd   = users::ResetPasswordSMS($u->uid, $phone);
                        $sms_gate = new sms_gate_a1($phone);
                        $sms_gate->sendSMS( preg_replace("/-LOGIN-/",$u->login,$sms_gate->getTextMessage(sms_gate::TYPE_PASS, $passwd)) );

                        if($sms_gate->getHTTPCode() == 200) {
                            // OK �������
                        } else {
                            $error = '������ �������� ��� �� ��������� �����';
                        }
                    } else {
                        $sm = new smail();
                        $sm->remind($u->email);
                    }
                }
            }
        } elseif(preg_match("/^\+\d{1,}$/", $email) || preg_match("/^\d{1,}$/", $email)) {
            $error_type = 'email';
            $ok_type = 'phone';
            // �������
            if(!preg_match("/^\+\d{1,}$/", $email)) {
                $email = "+".$email;
            }
            $phone = $email;
            $safety_frl = ((int)$role !== 2) ? sbr_meta::findSafetyPhone($phone, 'frl') : array();
            $safety_emp = ((int)$role !== 1) ? sbr_meta::findSafetyPhone($phone, 'emp') : array();
            $safety = null;
            if (!empty($safety_emp) && !empty($safety_frl)) {
                $error = '����� �������� �������� � ���� ���������. ����������, �������, � ������ �������� �� ������ ������������ ������.';
                $show_role = true;
            } elseif(empty($safety_emp) && empty($safety_frl)) {
                $error = "����� �� ������ �� � ����� ���������. ������� ���������� �����/�������/e-mail.";
            } else {
                $safety = !empty($safety_frl) ? $safety_frl : $safety_emp;
                $u = new users();
                $u->GetUserByUID($safety['uid']);
                if($u->is_banned) {
                    $error = "������� � ���� ������� ������������. � ���������, �� �� ������ ������������ � ���� ������.";
                } else {
                    $passwd   = users::ResetPasswordSMS($safety['uid'], $phone);
                    $sms_gate = new sms_gate_a1($phone);
                    $sms_gate->sendSMS( preg_replace("/-LOGIN-/",$u->login,$sms_gate->getTextMessage(sms_gate::TYPE_PASS, $passwd)) );

                    if($sms_gate->getHTTPCode() == 200) {
                        // OK �������
                    } else {
                        $error = '������ �������� ��� �� ��������� �����';
                    }
                }
            }
        } else {
            $error_type = 'email';
            $ok_type = 'email';
            // �����
            require_once ($_SERVER['DOCUMENT_ROOT'] . '/classes/users.php');
            $login = $email;
            $u = new users();
            $u->GetUser($login);
            if (!$u->uid) {
                $error = "����� �� ���������������. ������� ���������� �����/�������/e-mail.";
            } else {
                if($u->is_banned) {
                    $error = "������� � ���� ������� ������������. � ���������, �� �� ������ ������������ � ���� ������.";
                } else {
                    if($u->isRemindByPhoneOnly($u->login)) {
                        $ok_type = 'phone';
                        $error_type = 'email';
                        $reqv = sbr_meta::getUserReqvs($u->uid);
                        $ureqv = $reqv[$reqv['form_type']];
                        $phone = $ureqv['mob_phone'];
                        $passwd   = users::ResetPasswordSMS($u->uid, $phone);
                        $sms_gate = new sms_gate_a1($phone);
                        $sms_gate->sendSMS( preg_replace("/-LOGIN-/",$u->login,$sms_gate->getTextMessage(sms_gate::TYPE_PASS, $passwd)) );

                        if($sms_gate->getHTTPCode() == 200) {
                            // OK �������
                        } else {
                            $error = '������ �������� ��� �� ��������� �����';
                        }
                    } else {
                        $sm = new smail();
                        $sm->remind($u->email);
                    }
                }
            }
        }
    }
    if($error) {
        
        if (!$show_role) {
            $captcha->setNumber();
            $objResponse->assign('image_rnd', 'src', '/image.php?num='.$captchanum.'&t='.time());
            $objResponse->assign('remind_captcha', 'value', '');
        }
        
        $objResponse->assign('remind_'.$error_type.'_error_txt', 'innerHTML', $error);
        $objResponse->script('$("remind_'.$error_type.'_error").removeClass("b-shadow_hide");');
        
        $objResponse->assign('remind_email', 'value', $email);
        $objResponse->script("$('remind_button_email').addClass('b-button_disabled')");
        $objResponse->script('$("block_role").'.($show_role?'remove':'add').'Class("b-layout_hide");');
        
    } else {
        switch($ok_type) {
            case 'phone':
                $objResponse->script("$('email_remind').hide();");
                $objResponse->script("$('remind_ok_phone').show();");
                $objResponse->script("$('remind_ok_phone_txt').set('html', '".preg_replace("/^(\+\d{1,})\d{4}(\d{2})$/", "$1****$2", $phone)."');");
                break;
            case 'email':
                $objResponse->script("$('email_remind').hide();");
                $objResponse->script("$('remind_ok_email').show();");
                $a = explode('@',$u->email);
                $b = explode('.',$a[1]);
                $c = substr($b[0],0,1).'****'.substr($b[0],strlen($b[0])-1,1);
                if($b[1]) { foreach($b as $k=>$v) { if($k!=0) { $c.= ".".$b[$k]; } } }
                $email = substr($a[0],0,2).'****'.substr($a[0],strlen($a[0])-2,2).'@'.$c;
                $objResponse->script("$('remind_ok_email_txt').set('html', '".$email."');");
                break;
        }
    }

	return $objResponse;
}

function RemindByPhone($phone, $rnd, $captchanum) {
    session_start();
    $objResponse = new xajaxResponse();
    $captcha = new captcha($captchanum);

    if(!$captcha->checkNumber(trim($rnd))) {
        $error = "�� ����� �������� ���������� ����";
        $captcha->setNumber();
        $objResponse->assign('image_rnd2', 'src', '/image.php?num='.$captchanum.'&t='.time());
        $objResponse->assign('remind_phone_error', 'innerHTML', $error);
        $objResponse->assign('remind_rnd2', 'value', '');
        $objResponse->script("$('remind_button_phone').removeClass('b-button_rectangle_color_disable');
                              $('remind_phone_msg').removeClass('b-layout__txt_hide');  
        ");
    } else {
        $phone = trim($phone);
        $i_phone = users::CheckSafetyPhone($phone);
        if($i_phone['error_flag'] || trim($phone)=='') {
            $captcha->setNumber();
            $objResponse->assign('remind_phone_error', 'innerHTML', '�� ����� ������� � ������������ �������');
            $objResponse->assign('image_rnd2', 'src', '/image.php?num=2&t='.time());
            $objResponse->assign('remind_rnd2', 'value', '');
            $objResponse->assign('remind_phone', 'value', $phone);
            $objResponse->script("$('remind_button_phone').removeClass('b-button_rectangle_color_disable');
                                  $('remind_phone_msg').removeClass('b-layout__txt_hide');  
            ");
        } else {
            require_once ($_SERVER['DOCUMENT_ROOT'] . '/classes/sms_gate_a1.php');
            require_once ($_SERVER['DOCUMENT_ROOT'] . '/classes/sbr_meta.php');
            require_once ($_SERVER['DOCUMENT_ROOT'] . '/classes/users.php');
            
            $safety = sbr_meta::findSafetyPhone($phone);
            if($safety['safety_only_phone'] == 'f' || empty($safety)) {
                $error  = '���� ����� �������� �� ������ �� � ����� ���������. ���������� ������������ ������ �����  <a class="b-layout__link b-layout__link_bordbot_dot_0f71c8" href="#">����� ��� email</a>';
                $captcha->setNumber();
                $objResponse->assign('remind_phone_error', 'innerHTML', $error);
                $objResponse->assign('image_rnd2', 'src', '/image.php?num='.$captchanum.'&t='.time());
                $objResponse->assign('remind_rnd2', 'value', '');
                $objResponse->assign('remind_phone', 'value', $phone);
                $objResponse->script("$('remind_button_phone').removeClass('b-button_rectangle_color_disable');
                                      $('remind_phone_msg').removeClass('b-layout__txt_hide');  
                ");
            } else {
                $passwd   = users::ResetPasswordSMS($safety['uid'], $phone);
                $sms_gate = new sms_gate_a1($phone);
                $sms_gate->sendSMS($sms_gate->getTextMessage(sms_gate::TYPE_PASS, $passwd));
                
                if($sms_gate->getHTTPCode() == 200) {
                    $html = '<span class="b-icon b-icon_sbr_gattent"></span>�� ��������� ���� ����� ������ ����� ������ ��� ����� � �������.';
                    if(SMS_GATE_DEBUG) {
                        $html .= ' <strong style="color:red">(DEBUG TEST: ' . $passwd . ')</strong>';
                    }
                    $objResponse->script("$('remind_button_phone').removeClass('b-button_rectangle_color_disable');
                                          $('remind_phone_msg').addClass('b-layout__txt_hide');
                                          var e = new Element('div', {html: '{$html}', class: 'b-layout__txt b-layout__txt_padtop_15'});
                                          $('sms_remind').getElement('table').destroy();
                                          $('sms_remind').getElement('h3').grab(e, 'after');
                    ");
                } else {
                    $error = '������ �������� ��� �� ��������� �����';
                    $captcha->setNumber();
                    $objResponse->assign('remind_phone_error', 'innerHTML', $error);
                    $objResponse->assign('image_rnd2', 'src', '/image.php?num='.$captchanum.'&t='.time());
                    $objResponse->assign('remind_rnd2', 'value', '');
                    $objResponse->assign('remind_phone', 'value', $phone);
                    $objResponse->script("$('remind_button_phone').removeClass('b-button_rectangle_color_disable');
                                          $('remind_phone_msg').removeClass('b-layout__txt_hide');  
                    ");
                }
            }
        }
    }
    return $objResponse;
}

/**
 * ����������� ������ ����� ������� � �����
 * @param $phone
 * @param $login
 * @param $rnd
 * @param $captchanum
 * @return xajaxResponse
 */
function RemindByPhoneAndLogin ($phone, $login, $rnd, $captchanum) {
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/classes/sms_gate_a1.php');
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/classes/sbr_meta.php');
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/classes/users.php');

    session_start();
    $objResponse = new xajaxResponse();

    $phone = trim($phone);
    $login = trim($login);

    // �������� �����
    $captcha = new captcha($captchanum);
    if (!$captcha->checkNumber(trim($rnd))) {
        $captcha->setNumber();
        $error = '�� ����� �������� ���������� ����';
        sendPhoneRemindError($objResponse, $error, $captchanum, 'captcha');
        return $objResponse;
    }

    // �������� ������������ ���������� ������
    $i_phone = users::CheckSafetyPhone($phone);
    if($phone && $i_phone['error_flag']) {
        $captcha->setNumber();
        $error = '�� ����� ������� � ������������ �������';
        sendPhoneRemindError($objResponse, $error, $captchanum, 'phone');
        return $objResponse;
    }

    // �������� ������� ������ � ����
    if ($phone) {
        $safetyPhones = sbr_meta::findSafetyPhones($phone);

        if (!count($safetyPhones)) {
            $error  = '���� ����� �������� �� ������ �� � ����� ���������. ���������� ������������ ������ ����� ����� ��� email';
            $captcha->setNumber();
            sendPhoneRemindError($objResponse, $error, $captchanum, 'phone');
            return $objResponse;
        }
        foreach ($safetyPhones as $safetyPhone) {
            $checkUser = new users();
            $checkUser->GetUser($safetyPhone["login"]);
            if ($checkUser->is_banned) {
                $error  = '������� � ��������� ������� �������� ������������ ��� ������.\n��������, �� ������������ ������ � ���� � ������ ������ ������.';
	            $captcha->setNumber();
	            sendPhoneRemindError($objResponse, $error, $captchanum, 'login');
	            return $objResponse;
            }
        }
        // ���� �� ���� ����� ��������� ��������� � ����� �� ������
        if (count($safetyPhones) > 1 && !$login) {
            $captcha->setNumber();
            $error  = '�� �� ������� �����. ���� ����������� ��� ����������, �.�. ����� �������� �������� � ���������� ���������';
            sendPhoneRemindError($objResponse, $error, $captchanum, 'login');
            return $objResponse;
        }

        // ���� ����� �� ���������� � ������ �����
        if (count($safetyPhones) > 1 || $login) {
            foreach ($safetyPhones as $value) {
                if ($value['login'] == $login) {
                    $safety = $value;
                    break;
                }
            }
            if (!$safety) {
                $error  = '���� ����� � ����� �������� �� �������. ���������� ������������ ������ ����� ����� ��� email';
                $captcha->setNumber();
                sendPhoneRemindError($objResponse, $error, $captchanum, 'phone login');
                return $objResponse;
            }
        }

        if (count($safetyPhones) === 1 && !$login) {
            $safety = $safetyPhones[0];
        }
    }

    // ���� ������ ����� � �� ������ �����
    if ($login && !$phone) {

        // ��������� ���������� �� ������������ � ����� �������
        $user = new users();
        $user->GetUser($login);
        if (!$user->uid) {
            $error  = '�� ������� ������������ �����';
            $captcha->setNumber();
            sendPhoneRemindError($objResponse, $error, $captchanum, 'login');
            return $objResponse;
        }
       if ($user->is_banned) {
            $error  = '������� � ��������� ������� ������������ ��� ������.\n��������, �� ������������ ������ � ���� � ������ ������ ������.';
            $captcha->setNumber();
            sendPhoneRemindError($objResponse, $error, $captchanum, 'login');
            return $objResponse;
        }
        
        $safety = sbr_meta::findSafetyPhoneByLogin($login);

        if (!$safety) {
            $error  = '���� ����� �� ������ �� � ����� ������� ��������. ���������� ������������ ������ ����� ����� ��� email';
            $captcha->setNumber();
            sendPhoneRemindError($objResponse, $error, $captchanum, 'login');
            return $objResponse;
        }
        $phone = $safety['phone'];
    }

    $passwd   = users::ResetPasswordSMS($safety['uid'], $phone);
    $sms_gate = new sms_gate_a1($phone);
    $sms_gate->sendSMS($sms_gate->getTextMessage(sms_gate::TYPE_PASS, $passwd));


    if ($sms_gate->getHTTPCode() != 200) {
        $error = '������ �������� ��� �� ��������� �����';
        $captcha->setNumber();
        sendPhoneRemindError($objResponse, $error, $captchanum);
        return $objResponse;
    }


    $html = '<span class="b-icon b-icon_sbr_gattent"></span>�� ��������� ���� ����� ������ ����� ������ ��� ����� � �������.';
    if(SMS_GATE_DEBUG) {
        $html .= ' <strong style="color:red">(DEBUG TEST: ' . $passwd . ')</strong>';
    }
    $objResponse->script("
        $('remind_button_phone').removeClass('b-button_rectangle_color_disable');
        $('remind_phone_msg').addClass('b-layout__txt_hide');
        var e = new Element('div', {html: '{$html}', class: 'b-layout__txt b-layout__txt_padtop_15'});
        $('sms_remind').getElement('table').destroy();
        $('sms_remind').getElement('h3').grab(e, 'after');");

    return $objResponse;
}

function sendPhoneRemindError (&$objResponse, $errorMessage, $captchanum, $errorType = '') {
    //$objResponse->assign('remind_phone_error', 'innerHTML', $errorMessage);
    $objResponse->assign('image_rnd2', 'src', '/image.php?num='.$captchanum.'&t='.time());
    $objResponse->assign('remind_rnd2', 'value', '');
    $objResponse->script("$('remind_phone_msg').removeClass('b-layout__txt_hide');");
    $objResponse->script("$('remind_phone_msg').set('error_type', '$errorType');");
    $objResponse->script("alert('{$errorMessage}');");
}

$xajax->processRequest();
?>
