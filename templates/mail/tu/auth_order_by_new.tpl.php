<?php
/**
 * ������ ������ ����������� ��������� � �������� ������ ������ (��-1-1)
 */

/**
 * ���� ������
 */
$smail->subject = "����������� � ����� ������";

$tu_url = $GLOBALS['host'] . tservices_helper::card_link($tu_id, $tu_title);
$new_order_url = $GLOBALS['host'] . tservices_helper::getNewOrderUrl($code);

?>
������������.<br/>
<p>�� �������� ��� ������, �.�. ��� e-mail ����� ��� ������ �� ����� FL.ru ��� ����������� � ������ ������ &laquo;<a href="<?=$tu_url?>"><?=$tu_title?></a>&raquo;.</p>
<p>��� ���������� ����������� � ���������� ������, ����������, ��������� �� ������ <?php echo $new_order_url ?> ��� ���������� �� � �������� ������ ��������.</p>
<p>���� �� �� ���������� ������ �� ����� FL.ru � �� ��������� ���� e-mail � ������ �������������� ������. ��������, ���� �� ����� ������������� ������ �������.</p>
<br/>
<br/>
� ���������, 
<br/>
������� <a href="<?php echo "{$GLOBALS['host']}/"; ?>">FL.ru</a>