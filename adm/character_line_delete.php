<?php
$sub_menu = "400100";
require_once "./_common.php";
include_once(G5_LIB_PATH.'/character_line.lib.php');

if (!defined('_GNUBOARD_')) {
    exit;
}

$ch_id = trim($_GET['ch_id']);
$cl_id = trim($_GET['cl_id']);
$cl = get_character_line('',$cl_id);
$cl = $cl[0];

if (!(isset($cl['cl_id']))) {
        alert('존재하지 않는 대사 ID입니다.');
} else {
	$sql = " delete from dr_charline where  cl_id = '{$cl_id}' ";
	sql_query($sql);
}

goto_url('./character_line_form.php?' . $qstr . '&amp;w=&amp;ch_id=' . $ch_id, false);
