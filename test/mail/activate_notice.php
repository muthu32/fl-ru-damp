<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/config.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/smail.php");

if ($_GET['login']) {
    $mail = new smail();

    $mail->activateAccountNotice();
}

?>
�������� ����������� � ������������� ������������ �������<br />
��������, <strong>?debug=1&activate=1&login=danil5</strong>