<?php
/**
 * ����������� �������������
 * */
ini_set('max_execution_time', '0');
ini_set('memory_limit', '512M');

require_once '../classes/stdf.php';
require_once '../classes/memBuff.php';
require_once '../classes/smtp2.php';


/**
 * ����� ������������ �� ���� �������������� ��������
 * 
 */
//$sender = 'jb_admin';
$sender = 'admin';

$sql = "SELECT uid, email, login, uname, usurname, subscr FROM freelancer WHERE substring(subscr from 8 for 1)::integer = 1 AND is_banned = B'0'";

//$sql = "SELECT uid, email, login, uname, usurname FROM users WHERE email in ('jb@x13-net.ru', 'jb.x13@mail.ru', 'stoiss@yandex.ru')"; 


$pHost = str_replace("http://", "", $GLOBALS['host']);
if ( defined('HTTP_PREFIX') ) {
    $pHttp = str_replace("://", "", HTTP_PREFIX); // ������� � ������ ���� ����������� ��������� HTTPS �� �������� (��� ����� � ��)
} else {
    $pHttp = 'http';
}
$eHost = $GLOBALS['host'];

$pMessage = "
������������!

������ ���� ������������ ������� ������� ����������� ������������ ���������� �� �����. ���� ������ ����� ��� ���, � �� ������������ � ����. � ������������ ��� ���������� � http:/{��������� PRO}/{$pHost}/payed/?utm_source=newsletter4&utm_medium=email&utm_campaign=new_pro_freelancer ����� ��������� ���������� ���������� (�������, e-mail, icq, Skype � �.�.) � ����� �������, ����������, ������� �� ������� � ��������. 

������ ������������ PRO:

<ul><li>���������� ������� �������� �����������,</li><li>�������������� ���������� ������� �� �������,</li><li>����������� ����������� �� ������� � �������� ������� ��� PRO�, ������ ������� �� 30% ���� ��������� ��������,</li><li>������� �������������� �� ������� � ����������� ��������������,</li><li>�� ������ �������� ����������� PRO ��� �������.</li></ul>����� �������� ���� ��������, ��� ������ �������� ��������� ��� ������� ������������ � ����������, �� ����������� ���� ������������� � ��� �������. ����� ���� ���������� � ���, ��� �������������� ��������� �� ������� �� �����, � �� �������������� �������� ������� �� ����������� ������, ����������� ��������� ������� ����� �http:/{������ ��� �����}/{$pHost}/sbr/?utm_source=newsletter4&utm_medium=email&utm_campaign=new_pro_freelancer<span>�</span>. 

����� �������� � ������������� ������� � �http:/{������}/{$pHost}/blogs/?utm_source=newsletter4&utm_medium=email&utm_campaign=new_pro_freelancer<span>�</span>, � � PRO &ndash; � ������� �http:/{������}/{$pHost}/help/?q=789&utm_source=newsletter4&utm_medium=email&utm_campaign=new_pro_freelancer<span>�</span>. 

�� ���� ����������� �������� �� ������ ���������� � ���� http:/{������ ���������}/{$pHost}/help/?all<i>.</i>
�� ������ ��������� ����������� ��http:/{�������� &laquo;�����������/��������&raquo;}/{$pHost}/users/%USER_LOGIN%/setup/mailer/<span> ������</span> ��������.

�������� ������,
������� http:/{Free-lance.ru}/{$pHost}/
";



$mail = new smtp2;

$cid1  = $mail->cid();
$cid2  = $mail->cid();
$cid3  = $mail->cid();
$cid4  = $mail->cid();
$cid5  = $mail->cid();
$cid6  = $mail->cid();
$cid7  = $mail->cid();
$cid8  = $mail->cid();
$cid9  = $mail->cid();
$cid10 = $mail->cid();
$cid11 = $mail->cid();

$mail->attach(ABS_PATH . '/images/mailer/30/1.png', $cid1);
$mail->attach(ABS_PATH . '/images/mailer/30/2.png', $cid2);
$mail->attach(ABS_PATH . '/images/mailer/30/3.png', $cid3);
$mail->attach(ABS_PATH . '/images/mailer/30/4.png', $cid4);
$mail->attach(ABS_PATH . '/images/mailer/30/5.png', $cid5);
$mail->attach(ABS_PATH . '/images/mailer/30/6.png', $cid6);
$mail->attach(ABS_PATH . '/images/mailer/30/7.png', $cid7);
$mail->attach(ABS_PATH . '/images/mailer/30/8.png', $cid8);
$mail->attach(ABS_PATH . '/images/mailer/30/9.png', $cid9);
$mail->attach(ABS_PATH . '/images/mailer/30/10.png', $cid10);
//$mail->attach(ABS_PATH . '/images/mailer/30/11.gif', $cid11);

$eSubject = "���������� ���� ������ �������� �� Free-lance.ru";

$eMessage = '
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title></title>
</head>
<body bgcolor="#ffffff" marginwidth="0" marginheight="0" link="#396ea9"  bottommargin="0" topmargin="0" rightmargin="0" leftmargin="0" style="margin:0">

<table bgcolor="#ffffff" width="100%">
<tbody><tr>
<td bgcolor="#ffffff">
<center>
<table style="margin-top: 0pt; margin-left: auto; margin-right: auto; background-color: #ffffff; text-align:left"  bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="700">
    <tbody><tr>
        <td bgcolor="#ffffff" width="20"></td>
        <td height="20" width="20"></td>
        <td height="20" width="20"></td>
        <td bgcolor="#ffffff" width="20"></td>
    </tr>
</tbody>
</table>
<table style="margin-top: 0pt; margin-left: auto; margin-right: auto; background-color: #ffffff; text-align:left" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="700">
    <tbody><tr>
        <td bgcolor="#ffffff" width="20"></td>
        <td width="20"></td>
        <td ><font color="#000000" size="6" face="tahoma,sans-serif">������� �������!</font></td>
        <td></td>
        <tdwidth="20"></td>
        <td bgcolor="#ffffff" width="20"></td>
    </tr>
</tbody>
</table>

<table border=0 style="margin-top: 0pt; margin-left: auto; margin-right: auto; background-color: #ffffff; text-align:left"  bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="700">
    <tbody><tr>
        <td bgcolor="#ffffff" height="10" width="20"></td>
        <td width="20"></td>
        <td></td>
        <td width="20"></td>
        <td bgcolor="#ffffff" width="20"></td>
  </tr>
    <tr valign="middle">
        <td bgcolor="#ffffff" width="20"></td>
        <td width="20"></td>
        <td>
            <table border=0 cellpadding=0 cellspacing=0 width="100%">
            <tr valign=middle>
                <td><a href="https://free-lance.ru" target="_blank"><img src="cid:'.$cid1.'" width="197" height="27" style="margin-bottom: 5px" alt="Free-lance.ru" title="Free-lance.ru" border="0"></a></td>
                <td>&#160;<font color="#5e5e5e" size="5" face="tahoma,sans-serif" style="white-space:nowrap;">���������� �������� ���</font>&#160;</td>
                <td><img src="cid:'.$cid2.'" width="104" height="45" alt="PRO" title="PRO"></td>
            </tr>
            </table>
        <td width="20"></td>
        <td bgcolor="#ffffff" width="20"></td>
  </tr>
    <tr>
        <td bgcolor="#ffffff" width="20" height="20"></td>
        <td width="20"></td>
        <td></td>
        <td width="20"></td>
        <td bgcolor="#ffffff" width="20"></td>
  </tr>
</tbody>
</table>


<table style="margin-top: 0pt; margin-left: auto; margin-right: auto; background-color: #ffffff; text-align:left"  bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="700">
    <tbody><tr>
        <td bgcolor="#ffffff" height="10" width="20"></td>
        <td width="20"></td>
        <td></td>
        <td width="20"></td>
        <td bgcolor="#ffffff" width="20"></td>
  </tr>
    <tr>
        <td bgcolor="#ffffff" width="20"></td>
        <td width="20"></td>
        <td bbackground="cid:'.$cid11.'" bgcolor="#F0F2F3" style="border-left:1px solid #e6e8e9; border-right:1px solid #e6e8e9;background-color:#f0f2f3;">
        <table style="margin-top: 0pt; text-align:left"  border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody>
            	<tr>
                    <td colspan="3" height="1" style="background:#d0d4d7;"  ></td>
          		</tr>
            	<tr>
                    <td colspan="3" height="1" style="background:#e5e6e7;"  ></td>
          		</tr>
            	<tr>
                    <td width="20" height="20"></td>
                    <td></td>
                    <td width="20"></td>
          		</tr>
            	<tr>
                    <td width="60"></td>
                    <td>
                        <font color="#444444" size="3" face="tahoma,sans-serif">� ������������ ��� ���������� � <a href="'.$eHost.'/payed/?utm_source=newsletter4&utm_medium=email&utm_campaign=new_pro_freelancer" style="color:#0f71c8" target="_blank">���������</a>  <img src="cid:'.$cid3.'" width="26" height="11" border="0" alt="PRO" title="PRO"> ����� ��������� ���������� ����������</font><br>
                        <font color="#444444" size="1" face="tahoma,sans-serif">(�������, e-mail, icq, Skype) � ����� �������, ����������, ������� �� ������� � ��������.</font>
                    </td>
                    <td  width="60"></td>
          		</tr>
            	<tr>
                    <td width="20" height="30"></td>
                    <td></td>
                    <td width="20"></td>
          		</tr>
            	<tr>
                    <td width="20" ></td>
                    <td>
                      <table style="margin-top: 0pt; text-align:left"  border="0" cellpadding="0" cellspacing="0" width="100%">
                          <tbody>
                              <tr>
                                  <td width="50" align="center"><a href="'.$eHost.'/payed/?utm_source=newsletter4&utm_medium=email&utm_campaign=new_pro_freelancer" target="_blank"><img width=39 height=39 src="cid:'.$cid4.'"  border="0"></a></td>
                                  <td width="50"></td>
                                  <td width="50" align="center"><a href="'.$eHost.'/payed/?utm_source=newsletter4&utm_medium=email&utm_campaign=new_pro_freelancer" target="_blank"><img width=42 height=26 src="cid:'.$cid5.'"  border="0"></a></td>
                                  <td width="50"></td>
                                  <td width="50" align="center"><a href="'.$eHost.'/payed/?utm_source=newsletter4&utm_medium=email&utm_campaign=new_pro_freelancer" target="_blank"><img width=43 height=45 src="cid:'.$cid6.'"  border="0"></a> </td>
                                  <td width="50"></td>
                                  <td width="50" align="center"><a href="'.$eHost.'/payed/?utm_source=newsletter4&utm_medium=email&utm_campaign=new_pro_freelancer" target="_blank"><img width=41 height=41 src="cid:'.$cid7.'"  border="0"></a></td>
                                  <td width="40"></td>
                                  <td width="80" align="center"><a href="'.$eHost.'/payed/?utm_source=newsletter4&utm_medium=email&utm_campaign=new_pro_freelancer" target="_blank"><img width=42 height=43 src="cid:'.$cid8.'"  border="0"></a></td>
                                  <td  ></td>
                              </tr>
                              <tr>
                                  <td align="center">
                                  	<font color="#444444" size="1" face="tahoma,sans-serif">�������</font>
                                  </td>
                                  <td ></td>
                                  <td align="center">
                                  	<font color="#444444" size="1" face="tahoma,sans-serif">E-mail</font>
                                  </td>
                                  <td ></td>
                                  <td align="center">
                                  	<font color="#444444" size="1" face="tahoma,sans-serif">ICQ</font>
                                  </td>
                                  <td ></td>
                                  <td align="center">
                                  	<font color="#444444" size="1" face="tahoma,sans-serif">Skype</font>
                                  </td>
                                  <td ></td>
                                  <td align="center">
                                  	<font color="#444444" size="1" face="tahoma,sans-serif">� ��� ���������</font>
                                  </td>
                                  <td ></td>
                              </tr>
                          </tbody>
                      </table>
                    </td>
                    <td  width="20"></td>
          		</tr>
            	<tr>
                    <td width="20" height="30"></td>
                    <td  ></td>
                    <td width="20"></td>
          		</tr>
        	</tbody>
        </table>
        </td>
        <td width="20"></td>
        <td bgcolor="#ffffff" width="20"></td>
  </tr>
    <tr>
        <td bgcolor="#ffffff" width="20" height="20"></td>
        <td width="20"></td>
        <td></td>
        <td width="20"></td>
        <td bgcolor="#ffffff" width="20"></td>
  </tr>
</tbody>
</table>



<table style="margin-top: 0pt; margin-left: auto; margin-right: auto; background-color: #ffffff; text-align:left" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="700">
    <tbody><tr>
        <td bgcolor="#ffffff" height="10" width="20"></td>
        <td width="20"></td>
        <td></td>
        <td width="20"></td>
        <td bgcolor="#ffffff" width="20"></td>
  </tr>
    <tr>
        <td bgcolor="#ffffff" width="20"></td>
        <td width="20"></td>
        <td><font color="#444444" size="2" face="tahoma,sans-serif">������ ������������ PRO:</font></td>
        <td width="20"></td>
        <td bgcolor="#ffffff" width="20"></td>
  </tr>
    <tr>
        <td bgcolor="#ffffff" width="20" height="20"></td>
        <td width="20"></td>
        <td></td>
        <td width="20"></td>
        <td bgcolor="#ffffff" width="20"></td>
  </tr>
</tbody>
</table>
<table style="margin-top: 0pt; margin-left: auto; margin-right: auto; background-color: #ffffff; text-align:left"  bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="700">
    <tbody>
    <tr>
        <td bgcolor="#ffffff" width="20"></td>
        <td width="80"></td>
        <td width="20" valign="top"><img src="cid:'.$cid9.'" width="15" height="15" style="margin-top:3px;" border="0" alt="+" title="+"></td>
        <td><font color="#444444" size="3" face="tahoma,sans-serif">���������� ������� �������� �����������.</font></td>
        <td width="20"></td>
        <td bgcolor="#ffffff" width="20"></td>
  </tr>
    <tr>
        <td bgcolor="#ffffff" width="20" height="5"></td>
        <td width="80"></td>
        <td width="20"></td>
        <td></td>
        <td width="20"></td>
        <td bgcolor="#ffffff" width="20"></td>
  </tr>
    <tr>
        <td bgcolor="#ffffff" width="20"></td>
        <td width="80"></td>
        <td width="20" valign="top"><img src="cid:'.$cid9.'" width="15" height="15" style="margin-top:3px;" border="0" alt="+" title="+"></td>
        <td valign="top"><font color="#444444" size="3" face="tahoma,sans-serif">�������������� ���������� ������� �� �������.</font></td>
        <td width="20"></td>
        <td bgcolor="#ffffff" width="20"></td>
  </tr>
    <tr>
        <td bgcolor="#ffffff" width="20" height="10"></td>
        <td width="80"></td>
        <td width="20"></td>
        <td></td>
        <td width="20"></td>
        <td bgcolor="#ffffff" width="20"></td>
  </tr>
    <tr>
        <td bgcolor="#ffffff" width="20"></td>
        <td width="80"></td>
        <td width="20" valign="top"><img src="cid:'.$cid9.'" width="15" height="15" style="margin-top:3px;" border="0" alt="+" title="+"></td>
        <td valign="top"><font color="#444444" size="3" face="tahoma,sans-serif">����������� ����������� �� ������� � �������� ������� ��� PRO�, ������ ������� �� 30% ���� ��������� ��������.</font></td>
        <td width="20"></td>
        <td bgcolor="#ffffff" width="20"></td>
  </tr>
    <tr>
        <td bgcolor="#ffffff" width="20" height="10"></td>
        <td width="80"></td>
        <td width="20"></td>
        <td></td>
        <td width="20"></td>
        <td bgcolor="#ffffff" width="20"></td>
  </tr>
    <tr>
        <td bgcolor="#ffffff" width="20"></td>
        <td width="80"></td>
        <td width="20" valign="top"><img src="cid:'.$cid9.'" width="15" height="15" style="margin-top:3px;" border="0" alt="+" title="+"></td>
        <td valign="top"><font color="#444444" size="3" face="tahoma,sans-serif">������� �������������� �� ������� � ����������� ��������������.</font></td>
        <td width="20"></td>
        <td bgcolor="#ffffff" width="20"></td>
  </tr>
    <tr>
        <td bgcolor="#ffffff" width="20" height="10"></td>
        <td width="80"></td>
        <td width="20"></td>
        <td></td>
        <td width="20"></td>
        <td bgcolor="#ffffff" width="20"></td>
  </tr>
    <tr>
        <td bgcolor="#ffffff" width="20"></td>
        <td width="80"></td>
        <td width="20" valign="top"><img src="cid:'.$cid9.'" width="15" height="15" style="margin-top:3px;" border="0" alt="+" title="+"></td>
        <td valign="top"><font color="#444444" size="3" face="tahoma,sans-serif">�� ������ �������� ����������� PRO ��� �������.</font></td>
        <td width="20"></td>
        <td bgcolor="#ffffff" width="20"></td>
    </tr>
    <tr>
        <td bgcolor="#ffffff" width="20" height="30"></td>
        <td width="80"></td>
        <td width="20"></td>
        <td></td>
        <td width="20"></td>
        <td bgcolor="#ffffff" width="20"></td>
  </tr>
    <tr>
        <td bgcolor="#ffffff" width="20" ></td>
        <td width="80"></td>
        <td colspan="2"><a href="'.$eHost.'/payed/?utm_source=newsletter4&utm_medium=email&utm_campaign=new_pro_freelancer" target="_blank"><img src="cid:'.$cid10.'" width="231" height="36" border="0" alt="��������� �� �������� PRO" title="��������� �� �������� PRO"></a></td>
        <td width="20"></td>
        <td bgcolor="#ffffff" width="20"></td>
  </tr>
    <tr>
        <td bgcolor="#ffffff" width="20" height="40"></td>
        <td width="80"></td>
        <td width="20"></td>
        <td></td>
        <td width="20"></td>
        <td bgcolor="#ffffff" width="20"></td>
  </tr>
</tbody>
</table>

<table style="margin-top: 0pt; margin-left: auto; margin-right: auto; background-color: #ffffff; text-align:left;"  bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="700">
    <tbody>
    <tr>
        <td bgcolor="#ffffff" width="20"></td>
        <td width="20"></td>
        <td><font color="#444444" size="2" face="tahoma,sans-serif">����� �������� ���� ��������, ��� ������ �������� ��������� ��� ������� ������������ � ����������, �� ����������� ���� ������������� � ��� �������. ����� ���� ���������� � ���, ��� �������������� ��������� �� ������� �� �����, � �� �������������� �������� ������� �� ����������� ������, ����������� ��������� ������� ����� �<a target="_blank" style="color:#0f71c8" href="'.$eHost.'/sbr/?utm_source=newsletter4&utm_medium=email&utm_campaign=new_pro_freelancer">������ ��� �����</a>�.</font></td>
        <td width="20"></td>
        <td bgcolor="#ffffff" width="20"></td>
  </tr>
    <tr>
        <td bgcolor="#ffffff" width="20" height="20"></td>
        <td width="20"></td>
        <td></td>
        <td width="20"></td>
        <td bgcolor="#ffffff" width="20"></td>
  </tr>
    <tr>
        <td bgcolor="#ffffff" width="20"></td>
        <td width="20"></td>
        <td><font color="#444444" size="2" face="tahoma,sans-serif">����� �������� � ������������� ������� � �<a target="_blank" style="color:#0f71c8" href="'.$eHost.'/blogs/free-lanceru/719815/ostavlyayte-svoi-pryamyie-kontaktyi.html?utm_source=newsletter4&utm_medium=email&utm_campaign=new_pro_freelancer">������</a>�, � � PRO � � ������� �<a target="_blank" style="color:#0f71c8" href="'.$eHost.'/help/?q=789&utm_source=newsletter4&utm_medium=email&utm_campaign=new_pro_freelancer">������</a>�.</font></td>
        <td width="20"></td>
        <td bgcolor="#ffffff" width="20"></td>
  </tr>
    <tr>
        <td bgcolor="#ffffff" width="20" height="20"></td>
        <td width="20"></td>
        <td></td>
        <td width="20"></td>
        <td bgcolor="#ffffff" width="20"></td>
  </tr>
</tbody>
</table>

<table style="margin-top: 0pt; margin-left: auto; margin-right: auto; background-color: #ffffff; text-align:left;"  bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="700">
    <tbody>
    <tr>
        <td bgcolor="#ffffff" width="20"></td>
        <td bgcolor="#ffffff" width="20"></td>
        <td bgcolor="#ffffff">
            <font color="#4d4d4d" size="1" face="tahoma,sans-serif">�� ���� ����������� �������� �� ������ ���������� � ���� <a target="_blank" style="color:#0f71c8;" href="'.$eHost.'/help/?all">������ ���������</a>.<br>
�� ������ ��������� ����������� �� �������� �<a target="_blank" style="color:#0f71c8;" href="'.$eHost.'/users/%%%USER_LOGIN%%%/setup/mailer/">�����������/��������</a>� ������ ��������.</font>
        </td>
        <td bgcolor="#ffffff" width="20"></td>
        <td bgcolor="#ffffff" width="20"></td>
  </tr>
    <tr>
        <td bgcolor="#ffffff" width="20"></td>
        <td bgcolor="#ffffff" height="20" width="20"></td>
        <td bgcolor="#ffffff"></td>
        <td bgcolor="#ffffff" width="20"></td>
        <td bgcolor="#ffffff" width="20"></td>
  </tr>
    <tr>
        <td bgcolor="#ffffff" width="20"></td>
        <td bgcolor="#ffffff" width="20"></td>
        <td bgcolor="#ffffff">
            <font color="#4d4d4d" size="1" face="tahoma,sans-serif">�������� ������!<br>������� <a target="_blank" style="color:#0f71c8;" href="'.$eHost.'">Free-lance.ru</a></font>
        </td>
        <td bgcolor="#ffffff" width="20"></td>
        <td bgcolor="#ffffff" width="20"></td>
  </tr>
    <tr>
        <td bgcolor="#ffffff" width="20"></td>
        <td bgcolor="#ffffff" height="20" width="20"></td>
        <td bgcolor="#ffffff"></td>
        <td bgcolor="#ffffff" width="20"></td>
        <td bgcolor="#ffffff" width="20"></td>
  </tr>
</tbody>
</table>

</center>
</td>
</tr>
</tbody></table>

</body>
</html>
';

// ----------------------------------------------------------------------------------------------------------------
// -- �������� ----------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------
$DB = new DB('plproxy');
$master = new DB('master');
$cnt = 0;


$sender = $master->row("SELECT * FROM users WHERE login = ?", $sender);
if (empty($sender)) {
    die("Unknown Sender\n");
}

echo "Send personal messages\n";

// �������������� ��������
$msgid = $DB->val("SELECT masssend(?, ?, '{}', '')", $sender['uid'], $pMessage);
if (!$msgid) die('Failed!');

// ��������, �� �������� ��������� � ������-�� �������
$i = 0;
while ($users = $master->col("{$sql} LIMIT 30000 OFFSET ?", $i)) {
    $DB->query("SELECT masssend_bind(?, {$sender['uid']}, ?a)", $msgid, $users);
    $i = $i + 30000;
}
// �������� �������� � �����
$DB->query("SELECT masssend_commit(?, ?)", $msgid, $sender['uid']); 
echo "Send email messages\n";


$mail->subject = $eSubject;  // ��������� ������
$mail->message = $eMessage; // ����� ������
$mail->recipient = ''; // �������� '����������' ��������� ������
$spamid = $mail->masssend();
if (!$spamid) die('Failed!');
// � ����� ������� �������� �������, �� ��� ������ �� ����������!
// �������� ��� ����� �������� ������ ����������� � ������-���� �������
$i = 0;
$mail->recipient = array();
$res = $master->query($sql);
while ($row = pg_fetch_assoc($res)) {
    $mail->recipient[] = array(
        'email' => "{$row['uname']} {$row['usurname']} [{$row['login']}] <{$row['email']}>",
        'extra' => array('USER_LOGIN' => $row['login'])
    );
    if (++$i >= 30000) {
        $mail->bind($spamid);
        $mail->recipient = array();
        $i = 0;
    }
    $cnt++;
}
if ($i) {
    $mail->bind($spamid);
    $mail->recipient = array();
}

echo "OK. Total: {$cnt} users\n";
