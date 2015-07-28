<?
require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/users.php");

pg_query(DBConnect(),"BEGIN;");

$r = pg_query(DBConnect(), "SELECT MAX(id) AS max_id FROM opros");
$m = pg_fetch_array($r);
pg_query(DBConnect(),"ALTER SEQUENCE opros_id_seq RESTART WITH ".($m['max_id']+1));

$r = pg_query(DBConnect(), "SELECT MAX(id) AS max_id FROM opros_questions");
$m = pg_fetch_array($r);
pg_query(DBConnect(),"ALTER SEQUENCE opros_questions_id_seq RESTART WITH ".($m['max_id']+1));

$r = pg_query(DBConnect(), "SELECT MAX(id) AS max_id FROM opros_answers");
$m = pg_fetch_array($r);
pg_query(DBConnect(),"ALTER SEQUENCE opros_answers_id_seq RESTART WITH ".($m['max_id']+1));

$r = pg_query(DBConnect(),"INSERT INTO opros (name, descr, flags, is_active, is_multi_page) VALUES ('���������� ������� ����������', '<p>��������� ������������!</p><p>���������� ��� �� ��, ��� �� ����������� ������� ������� � ����� ������������.</p><p>�� ����������� ������ ��� ������������ ������� � ���������� ������, ���� ����� �������������, ������� �� �������, �, �� �����������, ����������� ��������.<br />��� ����� ��������� � ���������� ������ ����� ������������ ������ � ���������� ���� ��� ������� ����������������� �����.</p><p>������� �������!!!</p>', B'1101', true, true) RETURNING id;");
$opros_id = pg_fetch_result($r,0,0);

// 101
$r = pg_query(DBConnect(),"INSERT INTO opros_questions (name, opros_id, max_answer, page_num, num, type) VALUES ('����������� �� �� ����� ��� ���� ����������� ����������� (����������� ������������) ��� ���������� ��������� �����, � ���� ��, �� ��������� ��������� �� ��� �������?', $opros_id, 0, 1, 1, 2) RETURNING id;");
$q101 = pg_fetch_result($r,0,0);

// 102
$r = pg_query(DBConnect(),"INSERT INTO opros_questions (name, opros_id, max_answer, page_num, num, type) VALUES ('��� ���������� ����� ������ ����� �� ����������� �����������?', $opros_id, 0, 2, 1, 1) RETURNING id;");
$q102 = pg_fetch_result($r,0,0);

// 103
$r = pg_query(DBConnect(),"INSERT INTO opros_questions (name, opros_id, max_answer, page_num, num, type) VALUES ('����� ������� �� ������ �������� ����������� ��� ���������� ������?', $opros_id, 0, 2, 2, 1) RETURNING id;");
$q103 = pg_fetch_result($r,0,0);

// 104
$r = pg_query(DBConnect(),"INSERT INTO opros_questions (name, opros_id, max_answer, page_num, num, type) VALUES ('������� ������� � ������� ��� ��������� ��� ������ ������� �����������?', $opros_id, 0, 2, 3, 2) RETURNING id;");
$q104 = pg_fetch_result($r,0,0);

// 105
$r = pg_query(DBConnect(),"INSERT INTO opros_questions (name, opros_id, max_answer, page_num, num, type) VALUES ('����� �������������� ����������� �������� ��� ��� <u>�������� �������</u>, ����� �� ����������� �� � ��������������, ��������� �� ���������� ������?', $opros_id, 0, 3, 1, 1) RETURNING id;");
$q105 = pg_fetch_result($r,0,0);

// 106
$r = pg_query(DBConnect(),"INSERT INTO opros_questions (name, opros_id, max_answer, page_num, num, type) VALUES ('� ����� �������������� ����������� ��� <u>���������� �� ����������</u>, �� ����� ��� ��� �������� ��������, ����� �� ����������� �� � ��������������, ��������� �� ���������� ������?', $opros_id, 0, 3, 2, 1) RETURNING id;");
$q106 = pg_fetch_result($r,0,0);

// 107
$r = pg_query(DBConnect(),"INSERT INTO opros_questions (name, opros_id, max_answer, page_num, num, type) VALUES ('�� ��������� ������������ ��� ����������� �������� ����������� ��� (� ���� 2009 ����)? (������� � ���� ������ ������������ ������)', $opros_id, 0, 4, 1, 2) RETURNING id;");
$q107 = pg_fetch_result($r,0,0);

// 108
$r = pg_query(DBConnect(),"INSERT INTO opros_questions (name, opros_id, max_answer, page_num, num, type) VALUES ('������� �������� �������� �� �������� (������ �� ����������) ����������� ����������� ��� (� ���� 2009 ����)?', $opros_id, 0, 4, 2, 2) RETURNING id;");
$q108 = pg_fetch_result($r,0,0);

// 109
$r = pg_query(DBConnect(),"INSERT INTO opros_questions (name, opros_id, max_answer, page_num, num, type) VALUES ('����� ������� ��, ��� �������, ����������� ������������� � ������������?', $opros_id, 0, 4, 3, 2) RETURNING id;");
$q109 = pg_fetch_result($r,0,0);

// 110
$r = pg_query(DBConnect(),"INSERT INTO opros_questions (name, opros_id, max_answer, page_num, num, type) VALUES ('������������ �� �� <u>�� ��������� ���</u> � ����������, ����� ��������� ������� �������������� ��������������? ���� ��, �� � ��� ��� ����������?', $opros_id, 0, 4, 4, 1) RETURNING id;");
$q110 = pg_fetch_result($r,0,0);

// 111
$r = pg_query(DBConnect(),"INSERT INTO opros_questions (name, opros_id, max_answer, page_num, num, type) VALUES ('� �������, ����� �� ������������ � ������������� �������������� ���������������, ��������� �� ��� ��������� ��������, � ���� ��, �� ����� �������?', $opros_id, 0, 4, 5, 1) RETURNING id;");
$q111 = pg_fetch_result($r,0,0);

// 112
$r = pg_query(DBConnect(),"INSERT INTO opros_questions (name, opros_id, max_answer, page_num, num, type) VALUES ('����� ������� �� ������ ������������ ����������� ������ �� ����������� ������?', $opros_id, 0, 5, 1, 1) RETURNING id;");
$q112 = pg_fetch_result($r,0,0);

// 113
$r = pg_query(DBConnect(),"INSERT INTO opros_questions (name, opros_id, max_answer, page_num, num, type) VALUES ('��� �� �������������� �� �������������� (��� ������������� �����������) �����������, ������� �������� �� ��� (���� �����)?', $opros_id, 0, 5, 2, 1) RETURNING id;");
$q113 = pg_fetch_result($r,0,0);

// 114
$r = pg_query(DBConnect(),"INSERT INTO opros_questions (name, opros_id, max_answer, page_num, num, type) VALUES ('���� �� ������, ����� �� ����� ����� ������ ����������� � ���� ��������?', $opros_id, 0, 5, 3, 2) RETURNING id;");
$q114 = pg_fetch_result($r,0,0);

// 115
$r = pg_query(DBConnect(),"INSERT INTO opros_questions (name, opros_id, max_answer, page_num, num, type) VALUES ('��� ��� (���� �����������) ������ ����� <u>����������</u> �������������� � ������������ (����������� � �������������� ������� ������������)?', $opros_id, 0, 6, 1, 1) RETURNING id;");
$q115 = pg_fetch_result($r,0,0);

// 116
$r = pg_query(DBConnect(),"INSERT INTO opros_questions (name, opros_id, max_answer, page_num, num, type) VALUES ('��� ��� (����� �����������) ������ ����� <u>�� ��������</u> ��� ������ � ������������?', $opros_id, 0, 6, 2, 1) RETURNING id;");
$q116 = pg_fetch_result($r,0,0);

// 117
$r = pg_query(DBConnect(),"INSERT INTO opros_questions (name, opros_id, max_answer, page_num, num, type) VALUES ('�������, ����������, ��� ���', $opros_id, 0, 7, 1, 2) RETURNING id;");
$q117 = pg_fetch_result($r,0,0);

// 118
$r = pg_query(DBConnect(),"INSERT INTO opros_questions (name, opros_id, max_answer, page_num, num, type) VALUES ('������� ��� ��� �����������?', $opros_id, 0, 7, 2, 3) RETURNING id;");
$q118 = pg_fetch_result($r,0,0);

// 119
$r = pg_query(DBConnect(),"INSERT INTO opros_questions (name, opros_id, max_answer, page_num, num, type) VALUES ('����������� �� ��� �����-������ � ����� ����� �������� � �������� ����������?', $opros_id, 0, 7, 3, 2) RETURNING id;");
$q119 = pg_fetch_result($r,0,0);

// 120
$r = pg_query(DBConnect(),"INSERT INTO opros_questions (name, opros_id, max_answer, page_num, num, type) VALUES ('�������, ����������, ����� ������������, � ������� ��������� �� (���� �����������)?', $opros_id, 0, 7, 4, 1) RETURNING id;");
$q120 = pg_fetch_result($r,0,0);

// 121
$r = pg_query(DBConnect(),"INSERT INTO opros_questions (name, opros_id, max_answer, page_num, num, type) VALUES ('�������, ����������, ��� ����� �����������.', $opros_id, 0, 7, 5, 2) RETURNING id;");
$q121 = pg_fetch_result($r,0,0);

// 122
$r = pg_query(DBConnect(),"INSERT INTO opros_questions (name, opros_id, max_answer, page_num, num, type) VALUES ('������ ���� ���������, ��������� ���������?', $opros_id, 0, 8, 1, 2) RETURNING id;");
$q122 = pg_fetch_result($r,0,0);

// 123
$r = pg_query(DBConnect(),"INSERT INTO opros_questions (name, opros_id, max_answer, page_num, num, type) VALUES ('�������, ����������, ����� ������� ����������� � ����� �����������, ������� ���.', $opros_id, 0, 8, 2, 2) RETURNING id;");
$q123 = pg_fetch_result($r,0,0);

// 124
$r = pg_query(DBConnect(),"INSERT INTO opros_questions (name, opros_id, max_answer, page_num, num, type) VALUES ('�������, ����������, ������, � ������� ��������� ����������� ���� ����� �������� (��� ���� ����� ����������, ���� �� � ���������� ����)?', $opros_id, 0, 8, 3, 2) RETURNING id;");
$q124 = pg_fetch_result($r,0,0);

// 125
$r = pg_query(DBConnect(),"INSERT INTO opros_questions (name, opros_id, max_answer, page_num, num, type) VALUES ('� ����� ������� ��������� ����������� ���� ����� �������� (��� ���� ����� ����������, ���� �� � ���������� ����)?', $opros_id, 0, 8, 4, 4) RETURNING id;");
$q125 = pg_fetch_result($r,0,0);


// 126
$r = pg_query(DBConnect(),"INSERT INTO opros_questions (name, opros_id, max_answer, page_num, num, type) VALUES ('� ��� ��� ���������� ���� �������� � � ������������ �� ������ ������� ��� �� � ������������, ������������ � ������ �������� (�������)?', $opros_id, 0, 8, 5, 1) RETURNING id;");
$q126 = pg_fetch_result($r,0,0);

// 127
$r = pg_query(DBConnect(),"INSERT INTO opros_questions (name, opros_id, max_answer, page_num, num, type) VALUES ('� ��� ��� ���������� ���� �������� � � ������������ �� ����� ������ ��� �� � ������������, ������������ � ������ �������?', $opros_id, 0, 8, 6, 1) RETURNING id;");
$q127 = pg_fetch_result($r,0,0);


// Answers

$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����������� ������� �� ����������, �� ��������� ��� ������ � ���� ���������', $q109, false, 2, 0, 3, 3, 3, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a366 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('��������� ����� ����������', $q105, false, 1, 0, 5, 7, 7, false, NULL, NULL, false, NULL, NULL, 319) RETURNING id;");
$a302 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����� ���������� ����������', $q106, false, 0, 0, 2, 6, 6, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a318 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������������ �������', $q125, false, 0, 0, 0, 65, 65, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a520 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�������� � ����������� ������, ��������� ����������� ������', $q110, false, 1, 0, 4, 1, 1, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a339 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����� 1 ������', $q104, false, 0, 0, 2, 7, 7, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a293 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������', $q103, false, 0, 0, 2, 10, 10, true, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a286 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� ����� ����� �������� ������', $q105, false, 1, 0, 1, 9, 9, false, NULL, NULL, false, NULL, NULL, 321) RETURNING id;");
$a304 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���� ������ �� �������������', $q105, false, 0, 0, 5, 5, 5, false, NULL, NULL, false, NULL, NULL, 317) RETURNING id;");
$a300 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������', $q109, false, 1, 0, 1, 5, 5, true, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a338 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� �������� ��� ���������� ������������ ��������', $q105, false, 0, 0, 3, 8, 8, false, NULL, NULL, false, NULL, NULL, 320) RETURNING id;");
$a303 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����������� �������', $q125, false, 0, 0, 0, 64, 64, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a519 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������������� ������ �� ������ �������� ������', $q105, false, 0, 0, 2, 11, 11, false, NULL, NULL, false, NULL, NULL, 323) RETURNING id;");
$a306 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�� ��� ����������� ��������������', $q104, false, 0, 0, 0, 8, 8, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a294 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('��������� �������', $q125, false, 0, 0, 0, 40, 40, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a495 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� �������', $q125, false, 0, 0, 0, 41, 41, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a496 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�������� ����', $q125, false, 0, 0, 0, 42, 42, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a497 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�������� �� ���������, ��������', $q115, false, 0, 0, 4, 6, 6, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a374 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������������� ��������� � ����������� � ������� ������� �������', $q110, false, 3, 0, 1, 5, 5, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a343 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�������� �����, �������������� � ���������', $q105, false, 0, 1, 7, 2, 2, false, NULL, NULL, false, NULL, NULL, 314) RETURNING id;");
$a297 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���, �� ����������� ���, �� ������ � ����� �������', $q110, false, 0, 0, 1, 8, 8, false, NULL, NULL, true, '{111}', NULL, NULL) RETURNING id;");
$a346 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���, ������� �� ������� � �������� ����������', $q119, false, 2, 0, 12, 3, 3, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a397 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������', $q112, false, 0, 0, 1, 4, 4, true, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a357 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�� 1 ������', $q104, false, 2, 0, 6, 4, 4, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a290 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�����-���������', $q125, false, 1, 0, 1, 2, 2, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a438 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�������� ������ ������� �����������', $q115, false, 0, 0, 3, 3, 3, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a371 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������', $q125, false, 1, 1, 3, 1, 1, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a437 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����������', $q102, false, 0, 0, 3, 4, 4, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a271 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('��������, ���������� ��� �������� ���������', $q112, false, 3, 0, 12, 1, 1, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a354 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����������� ��������', $q105, false, 0, 0, 4, 17, 17, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a312 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� � ��������� ���-������', $q102, false, 1, 0, 9, 1, 1, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a268 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������� �����', $q113, false, 1, 0, 7, 1, 1, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a358 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����������������', $q102, false, 0, 1, 8, 2, 2, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a269 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������� / ��������� / ����������', $q102, false, 2, 0, 3, 8, 8, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a275 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������', $q116, false, 1, 0, 6, 10, 10, true, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a391 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('��������� ����������� ��������� (������ �����)', $q101, false, 9, 0, 14, 1, 1, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a263 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����� ������, �����, ���������� ���� � ���������', $q103, false, 3, 0, 6, 5, 5, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a281 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����� ����� ��������� ������ ��� ����������� (Free-Lance, Weblancer, Elance ��.�.)', $q103, false, 3, 0, 4, 4, 4, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a280 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������', $q102, false, 0, 0, 1, 9, 9, true, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a276 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������', $q124, false, 2, 0, 10, 1, 1, false, NULL, NULL, false, '{127}', NULL, NULL) RETURNING id;");
$a432 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������', $q106, false, 0, 0, 1, 16, 16, true, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a328 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����� ������������ ����� ����� �����������', $q103, false, 2, 0, 2, 6, 6, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a282 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����������� ��������', $q106, false, 1, 0, 6, 17, 17, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a329 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����������� ��������', $q127, false, 3, 0, 1, 5, 5, false, NULL, NULL, true, NULL, NULL, NULL) RETURNING id;");
$a448 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������ / �������', $q102, false, 0, 0, 6, 3, 3, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a270 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�� ��������', $q116, false, 0, 0, 3, 11, 11, false, NULL, NULL, true, NULL, NULL, NULL) RETURNING id;");
$a392 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����� �� ����������', $q115, false, 0, 0, 3, 13, 13, false, NULL, NULL, true, NULL, NULL, NULL) RETURNING id;");
$a381 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������ / �������� / ��������', $q102, false, 5, 0, 2, 7, 7, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a274 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����� ������������� ����� (HeadHunter, Job, SuperJob ��.�.)', $q103, false, 0, 0, 2, 3, 3, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a279 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�����, ����������', $q120, false, 0, 0, 3, 6, 6, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a403 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�������������� ���������� ��������� �������� � ���� ���������� ������', $q110, false, 2, 0, 2, 4, 4, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a342 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����������� ��������', $q108, false, 3, 0, 15, 2, 2, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a333 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������� � ������� ����������� (���, ���������� �������������)', $q105, false, 1, 0, 3, 4, 4, false, NULL, NULL, false, NULL, NULL, 316) RETURNING id;");
$a299 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����� / �����', $q102, false, 4, 0, 3, 6, 6, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a273 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����', $q102, false, 3, 0, 6, 5, 5, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a272 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('2-3 ���', $q104, false, 1, 0, 4, 3, 3, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a289 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���, �� ��������� � �� �������� ���������� ����������� ��� ������', $q101, false, 1, 0, 12, 4, 4, false, -1, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a266 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������������ ��� ������� ������������ (�������, ������ � �.�.)', $q113, false, 2, 0, 2, 3, 3, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a360 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����� ���� ����������� ���� (���� ����� ��������)', $q103, false, 0, 1, 7, 2, 2, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a278 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������� �������� �������� �� ����� ��������� ������ (PRO � �.�.)', $q106, false, 0, 1, 3, 3, 3, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a315 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� �������', $q125, false, 0, 0, 0, 66, 66, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a521 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�������������� ����', $q125, false, 0, 0, 0, 67, 67, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a522 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� �������', $q125, false, 0, 0, 0, 68, 68, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a523 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�������� �������', $q125, false, 0, 0, 0, 69, 69, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a524 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������� �������', $q125, false, 0, 0, 0, 70, 70, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a525 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������� � ���������� ������� �������� � ���� ������', $q106, false, 0, 0, 0, 15, 15, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a327 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���, �� ����������� ���, � �� ������ � ����� �������', $q110, false, 0, 0, 0, 9, 9, false, NULL, NULL, true, '{111}', NULL, NULL) RETURNING id;");
$a347 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������', $q113, false, 0, 0, 0, 8, 8, true, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a365 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������������� �������', $q125, false, 0, 0, 0, 5, 5, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a460 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������', $q110, false, 1, 0, 2, 7, 7, true, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a345 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�������', $q117, false, 5, 1, 15, 2, 2, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a394 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����������� �����������', $q113, false, 2, 0, 1, 6, 6, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a363 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�������, ���������, PR', $q120, false, 0, 0, 1, 7, 7, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a404 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('101-250 �������', $q123, false, 2, 0, 0, 6, 6, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a430 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�� 2 ������', $q104, false, 0, 0, 1, 5, 5, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a291 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������ ������������', $q113, false, 1, 0, 1, 4, 4, true, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a361 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�������������', $q120, false, 1, 0, 1, 13, 13, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a410 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�������� �����, �������������� � ���������', $q106, false, 1, 0, 3, 2, 2, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a314 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������������� ���������� ����� ��������� ������', $q110, false, 1, 0, 6, 6, 6, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a344 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����������� ��������', $q104, false, 0, 0, 1, 9, 9, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a295 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�������� �� ������������ ������� ����', $q115, false, 3, 0, 4, 5, 5, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a373 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� ��������� ������� �����', $q105, false, 0, 0, 4, 10, 10, false, NULL, NULL, false, NULL, NULL, 322) RETURNING id;");
$a305 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������� ��������� ����� �����������', $q116, false, 0, 1, 6, 2, 2, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a383 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������������ �����, ������� �� ������ �����, ������� ���������', $q105, false, 1, 0, 4, 12, 12, false, NULL, NULL, false, NULL, NULL, 324) RETURNING id;");
$a307 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������������', $q120, false, 2, 0, 1, 10, 10, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a407 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�� ����� �������� ���������', $q126, false, 0, 0, 2, 4, 4, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a442 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������������ �����, ����� �������������� �������� ������� ����������', $q105, false, 1, 0, 3, 13, 13, false, NULL, NULL, false, NULL, NULL, 325) RETURNING id;");
$a308 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�� 1 ������', $q104, false, 3, 0, 0, 6, 6, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a292 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������� �� ������ �������� ������', $q106, false, 0, 0, 2, 1, 1, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a313 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('��������� ��� �������', $q112, false, 2, 0, 1, 3, 3, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a356 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('��������� ��������� ����� �����������', $q115, false, 0, 0, 4, 4, 4, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a372 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('51-100 �������', $q123, false, 0, 0, 2, 5, 5, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a429 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�� ����� �������� ��������� (������ ����)', $q126, false, 3, 0, 4, 3, 3, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a441 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������', $q101, false, 0, 0, 8, 5, 5, true, 115, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a267 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('��������� ����� ����������', $q106, false, 2, 0, 3, 7, 7, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a319 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� ������������� ������� � ������ ������� ����������', $q105, false, 1, 0, 1, 14, 14, false, NULL, NULL, false, NULL, NULL, 326) RETURNING id;");
$a309 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���, �������� � �������� ����� �� ���� ���������', $q111, false, 1, 0, 3, 6, 6, false, NULL, NULL, true, NULL, NULL, NULL) RETURNING id;");
$a353 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�����������', $q120, false, 1, 0, 2, 8, 8, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a405 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('��������, ���������', $q120, false, 0, 0, 4, 11, 11, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a408 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���� ������ �� �������������', $q106, false, 0, 0, 2, 5, 5, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a317 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������������ ������������', $q120, false, 1, 0, 5, 5, 5, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a402 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����������� ����� ����������� �� ��������� ������', $q115, false, 1, 0, 3, 11, 11, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a379 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('��������� ���������', $q113, false, 0, 0, 4, 7, 7, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a364 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�������������� ��� ���� �����', $q109, false, 3, 0, 3, 4, 4, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a337 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('��, ���� ����������� � ������������', $q111, false, 1, 0, 3, 1, 1, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a348 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������������, ���. ������������ �����������, ����������', $q122, false, 1, 0, 4, 1, 1, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a421 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('��, ������� � ��������� �������� �� ��� ���', $q119, false, 3, 0, 9, 1, 1, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a395 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������ �� ������������', $q113, false, 2, 0, 3, 9, 9, false, NULL, NULL, true, NULL, NULL, NULL) RETURNING id;");
$a366 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������', $q120, false, 0, 0, 8, 4, 4, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a401 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������� � ���������� ������� �������� � ���� ������', $q105, false, 0, 0, 3, 15, 15, false, NULL, NULL, false, NULL, NULL, 327) RETURNING id;");
$a310 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('', $q107, false, 1, 1, 8, 1, 1, true, NULL, NULL, false, NULL, true, NULL) RETURNING id;");
$a330 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� ����� ����� �������� ������', $q106, false, 3, 0, 2, 9, 9, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a321 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����� ����������� ��������� ������� (WebMoney, ������.������ ��.�.)', $q112, false, 2, 1, 10, 2, 2, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a355 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�� ������������ ����� ������������, ���������', $q103, false, 2, 0, 3, 7, 7, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a283 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������������ �������������, ���. ������������ �������������', $q122, false, 1, 1, 3, 2, 2, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a422 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�����', $q120, false, 2, 0, 1, 9, 9, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a406 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������� � ������� ����������� (���, ���������� �������������)', $q106, false, 0, 0, 2, 4, 4, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a316 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('', $q108, false, 1, 1, 7, 1, 1, true, NULL, NULL, false, NULL, true, NULL) RETURNING id;");
$a332 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� ������������� ������� � ������ ������� ����������', $q106, false, 0, 0, 2, 14, 14, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a326 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� ��������� ������', $q115, false, 2, 0, 3, 9, 9, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a377 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������', $q115, false, 0, 0, 5, 12, 12, true, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a380 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������ � ��������', $q113, false, 1, 0, 0, 5, 5, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a362 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����������, ��������� � ����������� ���-������', $q120, false, 0, 0, 5, 3, 3, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a400 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('��������� (�������)', $q113, false, 1, 1, 5, 2, 2, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a359 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('��, ����� ��������� � �������� ���������', $q111, false, 1, 0, 2, 3, 3, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a350 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�������� � ������������, ������������ ��������� ����� � ����������', $q116, false, 0, 0, 4, 3, 3, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a384 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����������� ��������', $q107, false, 3, 0, 14, 2, 2, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a331 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('��', $q114, false, 4, 0, 9, 1, 1, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a367 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� �������� ��� ���������� ������������ ��������', $q106, false, 1, 0, 2, 8, 8, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a320 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������������ �������', $q125, false, 0, 0, 0, 7, 7, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a462 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������������ �������', $q125, false, 0, 0, 0, 9, 9, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a464 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� ����', $q125, false, 0, 0, 0, 43, 43, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a498 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('��������� �������', $q125, false, 0, 0, 0, 44, 44, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a499 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� ������', $q125, false, 0, 0, 0, 45, 45, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a500 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� ������������', $q125, false, 0, 0, 0, 46, 46, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a501 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����������� �������', $q125, false, 0, 0, 0, 12, 12, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a467 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('��������� ���������� �������', $q125, false, 0, 0, 0, 13, 13, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a468 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������������� ����', $q125, false, 0, 0, 0, 14, 14, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a469 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� �������', $q125, false, 0, 0, 0, 15, 15, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a470 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('��������� �������', $q125, false, 0, 0, 0, 16, 16, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a471 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('��������������� �������', $q125, false, 0, 0, 0, 18, 18, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a473 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������-���������� ����������', $q125, false, 0, 0, 0, 21, 21, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a476 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����������� �������', $q125, false, 0, 0, 0, 22, 22, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a477 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('��������� �������', $q125, false, 0, 0, 0, 23, 23, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a478 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����������� �������', $q125, false, 0, 0, 0, 24, 24, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a479 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������������� ����', $q125, false, 0, 0, 0, 25, 25, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a480 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������������ ����', $q125, false, 0, 0, 0, 26, 26, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a481 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� �������', $q125, false, 0, 0, 0, 27, 27, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a482 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������� �������', $q125, false, 0, 0, 0, 28, 28, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a483 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������������� �������', $q125, false, 0, 0, 0, 29, 29, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a484 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�������� �������', $q125, false, 0, 0, 0, 30, 30, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a485 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����������� �������', $q125, false, 0, 0, 0, 31, 31, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a486 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� �������', $q125, false, 0, 0, 0, 32, 32, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a487 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� �������', $q125, false, 0, 0, 0, 33, 33, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a488 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�������� ���������� �����', $q125, false, 0, 0, 0, 34, 34, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a489 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������������� �������', $q125, false, 0, 0, 0, 35, 35, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a490 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������������ �������', $q125, false, 0, 0, 0, 36, 36, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a491 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������������� �������', $q125, false, 0, 0, 0, 37, 37, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a492 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������ �������', $q125, false, 0, 0, 0, 38, 38, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a493 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������������ �������', $q125, false, 0, 0, 0, 39, 39, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a494 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� �������', $q125, false, 0, 0, 0, 47, 47, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a502 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� ��������', $q125, false, 0, 0, 0, 48, 48, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a503 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� ���������', $q125, false, 0, 0, 0, 49, 49, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a504 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� ��������', $q125, false, 0, 0, 0, 50, 50, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a505 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� �������', $q125, false, 0, 0, 0, 51, 51, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a506 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� ����', $q125, false, 0, 0, 0, 52, 52, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a507 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� ����� ��', $q125, false, 0, 0, 0, 53, 53, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a508 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� ��������', $q125, false, 0, 0, 0, 54, 54, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a509 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� ���� (������)', $q125, false, 0, 0, 0, 55, 55, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a510 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� �������� ������ � ������', $q125, false, 0, 0, 0, 56, 56, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a511 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� ���������', $q125, false, 0, 0, 0, 57, 57, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a512 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� ����', $q125, false, 0, 0, 0, 58, 58, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a513 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� �������', $q125, false, 0, 0, 0, 59, 59, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a514 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('��������� �������', $q125, false, 0, 0, 0, 61, 61, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a516 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('��������� �������', $q125, false, 0, 0, 0, 62, 62, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a517 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����������� �������', $q125, false, 0, 0, 0, 63, 63, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a518 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� �������', $q125, false, 0, 0, 0, 60, 60, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a515 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� ����', $q125, false, 0, 0, 0, 20, 20, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a475 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����������� �������', $q125, false, 0, 0, 0, 11, 11, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a466 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�������� �������', $q125, false, 0, 0, 0, 71, 71, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a526 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('��������� �������', $q125, false, 0, 0, 0, 72, 72, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a527 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� ����������', $q125, false, 0, 0, 0, 73, 73, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a528 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����������� �������', $q125, false, 0, 0, 0, 74, 74, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a529 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����������� ����', $q125, false, 0, 0, 0, 75, 75, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a530 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����������� �������', $q125, false, 0, 0, 0, 77, 77, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a532 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('��������� ����������', $q125, false, 0, 0, 0, 78, 78, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a533 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('��������� ����������', $q125, false, 0, 0, 0, 79, 79, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a534 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('��������� ���������� �����', $q125, false, 0, 0, 0, 80, 80, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a535 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�����-�������� ���������� �����', $q125, false, 0, 0, 0, 81, 81, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a536 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����������� �������', $q125, false, 0, 0, 0, 82, 82, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a537 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�������� �������', $q125, false, 0, 0, 1, 8, 8, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a463 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������������� �������', $q125, false, 0, 0, 1, 10, 10, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a465 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������', $q124, false, 3, 0, 4, 4, 4, false, NULL, NULL, false, '{125,126}', NULL, NULL) RETURNING id;");
$a435 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������-���������� ����������', $q125, false, 0, 0, 1, 17, 17, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a472 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����� 250 �������', $q123, false, 0, 0, 2, 7, 7, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a431 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�� ������ �������', $q126, false, 2, 0, 6, 1, 1, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a439 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�������� �������', $q125, false, 0, 0, 1, 4, 4, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a459 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������� ��� ������� �����������', $q121, false, 2, 0, 12, 1, 1, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a417 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������������, ��������� ������������������', $q110, false, 0, 0, 3, 3, 3, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a341 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�� ����� ������', $q127, false, 0, 0, 4, 1, 1, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a444 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('16-50 �������', $q123, false, 0, 0, 2, 4, 4, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a428 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('��������� �������', $q125, false, 0, 0, 1, 19, 19, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a474 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���', $q114, false, 3, 0, 10, 2, 2, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a368 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������������ �������', $q125, false, 0, 0, 1, 6, 6, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a461 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� ��������� ������� �����', $q106, false, 0, 0, 3, 10, 10, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a322 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('6-15 �������', $q123, false, 2, 0, 2, 3, 3, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a427 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�� ������', $q127, false, 2, 1, 6, 2, 2, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a445 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('��������������, ����������������� �����������, �������� ������', $q116, false, 0, 0, 4, 4, 4, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a385 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�� ����� �������� ���������', $q127, false, 0, 0, 4, 4, 4, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a447 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�� ������ ����� �������� ��������� (������ ����)', $q127, false, 1, 0, 3, 3, 3, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a446 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('��������� ����', $q125, false, 0, 0, 1, 3, 3, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a458 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����� 1 ���', $q104, false, 1, 0, 4, 1, 1, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a287 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������', $q120, false, 0, 0, 4, 19, 19, true, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a419 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����������� ����������� �� �������� ��������� � ������� �����', $q115, false, 0, 0, 2, 10, 10, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a378 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������������ �����, ������� �� ������ �����, ������� ���������', $q106, false, 0, 0, 2, 12, 12, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a324 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� ��������� ������ ���������� �����', $q116, false, 1, 0, 2, 8, 8, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a389 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�������', $q120, false, 2, 0, 2, 15, 15, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a412 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� ��������� ��������', $q115, false, 0, 0, 3, 8, 8, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a376 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� ������������ �����������', $q120, false, 0, 1, 5, 2, 2, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a399 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����������� ������� ���������� �������', $q109, false, 1, 0, 7, 1, 1, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a334 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�������������� (������, �������, ������������, ����������, ������� ��.�.)', $q120, false, 0, 0, 1, 12, 12, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a409 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������, �����', $q120, false, 0, 0, 1, 14, 14, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a411 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����� ������', $q121, false, 1, 1, 6, 2, 2, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a418 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������� �� ������ �������� ������', $q105, false, 1, 0, 8, 1, 1, false, NULL, NULL, false, NULL, NULL, 313) RETURNING id;");
$a296 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('��������� � ������������ ������������� � �������� ������������', $q120, false, 1, 0, 9, 1, 1, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a398 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('��������� ����������� ������, ����� �� �������', $q101, false, 3, 1, 9, 2, 2, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a264 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�������', $q124, false, 1, 1, 3, 2, 2, false, NULL, NULL, false, '{125,126}', NULL, NULL) RETURNING id;");
$a433 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������', $q122, false, 0, 0, 2, 4, 4, true, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a424 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('1 �������', $q123, false, 1, 0, 5, 1, 1, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a425 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� ���������� �������������� (��������� ������)', $q103, false, 1, 0, 9, 1, 1, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a277 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����������� ��������', $q126, false, 1, 0, 4, 5, 5, false, NULL, NULL, true, NULL, NULL, NULL) RETURNING id;");
$a443 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������������� ������ �� ������ �������� ������', $q106, false, 1, 0, 1, 11, 11, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a323 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���� ��� �� ��������� �����������, �� ��������� � �������', $q101, false, 0, 0, 4, 3, 3, false, 115, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a265 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������������� ����������� �������� ��� ����� ������', $q116, false, 2, 0, 6, 5, 5, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a386 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������ ������', $q124, false, 0, 0, 3, 5, 5, true, NULL, NULL, false, '{125,126}', NULL, NULL) RETURNING id;");
$a436 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����������', $q122, false, 1, 0, 2, 3, 3, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a423 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����������� ���������� �� �������� ����� ������ ����������������� ������������', $q115, false, 1, 0, 7, 1, 1, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a369 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�������� �� ����������� ����������� (���������, ����������, ���������)', $q115, false, 0, 0, 5, 7, 7, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a375 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����� ���������� ����������', $q105, false, 2, 0, 5, 6, 6, false, NULL, NULL, false, NULL, NULL, 318) RETURNING id;");
$a301 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('����������� ���������� �� �������� ����� ����� ����������������� ���������� ��� ���������� ������������������� �����', $q115, false, 0, 1, 6, 2, 2, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a370 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�������������� ���������� ������, �������', $q110, false, 1, 1, 4, 2, 2, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a340 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�������������� ��������������� (������������������)', $q121, false, 0, 0, 6, 3, 3, false, NULL, NULL, false, '{122}', NULL, NULL) RETURNING id;");
$a419 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('��, ������ ��������', $q111, false, 0, 0, 4, 5, 5, true, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a352 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������� � ������ � ���� �� ������������ ������ �����', $q103, false, 0, 0, 2, 9, 9, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a285 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�������', $q117, false, 1, 0, 16, 1, 1, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a393 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������������ �����, ����� �������������� �������� ������� ����������', $q106, false, 1, 0, 2, 13, 13, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a325 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('2-5 �������', $q123, false, 1, 1, 3, 2, 2, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a426 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�����-���������� ���������� ����� � ����', $q125, false, 0, 0, 1, 76, 76, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a531 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������ ����������', $q120, false, 1, 0, 2, 18, 18, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a415 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������� �����, ����������� ������ �� ������� ����������', $q116, false, 0, 0, 5, 7, 7, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a388 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�� ������������ ������, ��������', $q103, false, 3, 0, 1, 8, 8, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a284 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('1 ����', $q104, false, 2, 1, 2, 2, 2, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a288 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������������������ �����������, ����������������', $q116, false, 2, 0, 3, 6, 6, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a387 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('��������', $q124, false, 1, 0, 1, 3, 3, false, NULL, NULL, false, '{125,126}', NULL, NULL) RETURNING id;");
$a434 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('��������', $q120, false, 2, 0, 1, 16, 16, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a413 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('�� ������ �������� ������', $q126, false, 0, 0, 7, 2, 2, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a440 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������������� ��������� ���������� ������� ����� �����������', $q116, false, 1, 0, 7, 1, 1, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a382 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('', $q118, false, 12, 1, 43, 1, 1, true, NULL, NULL, false, NULL, true, NULL) RETURNING id;");
$a550 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('��, � �������������� ����� � �������� �������', $q111, false, 3, 0, 5, 4, 4, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a351 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������� ������������', $q120, false, 1, 0, 1, 17, 17, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a414 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������� �������� �������� �� ����� ��������� ������ (PRO � �.�.)', $q105, false, 0, 0, 4, 3, 3, false, NULL, NULL, false, NULL, NULL, 315) RETURNING id;");
$a298 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������� ���� (�� ��������������� � �������� ���������������)', $q121, false, 2, 0, 7, 4, 4, false, NULL, NULL, false, '{122,123}', NULL, NULL) RETURNING id;");
$a420 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������� ������, �� ������ ��� ���������', $q119, false, 2, 1, 11, 2, 2, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a396 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������������� ������������� ���������� (�� �������� �� ������ � ������)', $q116, false, 0, 0, 5, 9, 9, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a390 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('���������� � ������ �������������� ���������� �������', $q109, false, 1, 1, 7, 2, 2, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a335 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('��, � �������� ������������� ����� ��������� ������', $q111, false, 1, 1, 9, 2, 2, false, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a349 = pg_fetch_result($r,0,0);
$r = pg_query(DBConnect(),"INSERT INTO opros_answers (name, question_id, is_other, e_count, f_count, u_count, value, num, is_m_other, move_question_id, orig_answer_id, is_m_block, block_questions, is_m_number, block_answer) VALUES ('������', $q105, false, 0, 0, 3, 16, 16, true, NULL, NULL, false, NULL, NULL, NULL) RETURNING id;");
$a311 = pg_fetch_result($r,0,0);

pg_query(DBConnect(), "UPDATE opros_answers SET e_count=0, f_count=0, u_count=0 WHERE question_id IN (SELECT id FROM opros_questions WHERE opros_id=$opros_id);");
pg_query(DBConnect(), "UPDATE opros_answers SET block_answer=$a319 WHERE id=$a302;");
pg_query(DBConnect(), "UPDATE opros_answers SET block_answer=$a321 WHERE id=$a304;");
pg_query(DBConnect(), "UPDATE opros_answers SET block_answer=$a317 WHERE id=$a300;");
pg_query(DBConnect(), "UPDATE opros_answers SET block_answer=$a320 WHERE id=$a303;");
pg_query(DBConnect(), "UPDATE opros_answers SET block_answer=$a323 WHERE id=$a306;");
pg_query(DBConnect(), "UPDATE opros_answers SET block_answer=$a314 WHERE id=$a297;");
pg_query(DBConnect(), "UPDATE opros_answers SET block_questions='{".$q111."}' WHERE id=$a346;");
pg_query(DBConnect(), "UPDATE opros_answers SET block_questions='{".$q127."}' WHERE id=$a432;");
pg_query(DBConnect(), "UPDATE opros_answers SET block_answer=$a316 WHERE id=$a299;");
pg_query(DBConnect(), "UPDATE opros_answers SET move_question_id=-1 WHERE id=$a266;");
pg_query(DBConnect(), "UPDATE opros_answers SET block_questions='{".$q111."}' WHERE id=$a347;");
pg_query(DBConnect(), "UPDATE opros_answers SET block_answer=$a322 WHERE id=$a305;");
pg_query(DBConnect(), "UPDATE opros_answers SET block_answer=$a324 WHERE id=$a307;");
pg_query(DBConnect(), "UPDATE opros_answers SET block_answer=$a325 WHERE id=$a308;");
pg_query(DBConnect(), "UPDATE opros_answers SET move_question_id=$q115 WHERE id=$a267;");
pg_query(DBConnect(), "UPDATE opros_answers SET block_answer=$a326 WHERE id=$a309;");
pg_query(DBConnect(), "UPDATE opros_answers SET block_answer=$a327 WHERE id=$a310;");
pg_query(DBConnect(), "UPDATE opros_answers SET block_answer=$a325 WHERE id=$a308;");
pg_query(DBConnect(), "UPDATE opros_answers SET block_questions='{".$q125.",".$q126."}' WHERE id=$a435;");
pg_query(DBConnect(), "UPDATE opros_answers SET block_answer=$a313 WHERE id=$a296;");
pg_query(DBConnect(), "UPDATE opros_answers SET block_questions='{".$q125.",".$q126."}' WHERE id=$a433;");
pg_query(DBConnect(), "UPDATE opros_answers SET move_question_id=$q115 WHERE id=$a265;");
pg_query(DBConnect(), "UPDATE opros_answers SET block_questions='{".$q125.",".$q126."}' WHERE id=$a436;");
pg_query(DBConnect(), "UPDATE opros_answers SET block_answer=$a318 WHERE id=$a301;");
pg_query(DBConnect(), "UPDATE opros_answers SET block_questions='{".$q122."}' WHERE id=$a419;");
pg_query(DBConnect(), "UPDATE opros_answers SET block_questions='{".$q125.",".$q126."}' WHERE id=$a434;");
pg_query(DBConnect(), "UPDATE opros_answers SET block_answer=$a315 WHERE id=$a298;");
pg_query(DBConnect(), "UPDATE opros_answers SET block_questions='{".$q122.",".$q123."}' WHERE id=$a420;");

pg_query(DBConnect(),"COMMIT;");

echo "<a href='/opros/?id=$opros_id'>/opros/?id=$opros_id</a>";

?>
