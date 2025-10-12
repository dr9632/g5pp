<?php
$sub_menu = "400200";
require_once "./_common.php";
require_once G5_LIB_PATH . "/character.lib.php";
require_once G5_LIB_PATH . "/character_line.lib.php";

if ($w == 'u') {
    check_demo();
}

auth_check_menu($auth, $sub_menu, 'w');
check_admin_token();

$ch_id = trim($_POST['ch_id']);
$cl_text = isset($_POST['cl_text']) ? trim(strip_tags($_POST['cl_text'])) : '';

if ($w == '') {
	$sql_common = "  ch_id = '{$ch_id}',
					cl_text = '{$cl_text}'";

    sql_query(" insert into dr_charline set {$sql_common} ");
} elseif ($w == 'u') {
	$cl_id = trim($_POST['cl_id']);
    $cl = get_character_line('',$cl_id);
    if (!(isset($cl['cl_id']) && $cl['cl_id'])) {
        alert('존재하지 않는 대사 자료입니다.');
    }

    // 현재 데이터 조회
    $row = sql_fetch("select * from dr_charline where cl_id = '{$cl_id}' ");
    
    $sql = " update dr_charline
                set cl_text = '{$cl_text}'
                where cl_id = '{$cl_id}' ";
	
    sql_query($sql);
} else {
    alert('제대로 된 값이 넘어오지 않았습니다.');
}

run_event('admin_character_line_form_update', $w, $ch_id);

goto_url('./character_line_form.php?' . $qstr . '&amp;w=&amp;ch_id=' . $ch_id, false);
