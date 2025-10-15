<?php
require_once "./_common.php";
require_once G5_LIB_PATH . "/character.lib.php";
require_once G5_LIB_PATH . "/character_line.lib.php";

$ch_id = trim($_POST['ch_id']);
if(!$ch_id) $ch_id = trim($_GET['ch_id']);
$ch = get_character($ch_id);
$mb_id = trim($_POST['mb_id']);
if(!$mb_id) $mb_id = trim($_GET['mb_id']);

if(!$mb_id) {
	alert('존재하지 않는 회원 정보 입니다.');
}
else if(!($mb_id ==$ch['mb_id'])) {
	alert('수정 권한이 없는 캐릭터 입니다.');
}

$cl_text = isset($_POST['cl_text']) ? trim(strip_tags($_POST['cl_text'])) : '';

if ($w == 'c') {
	$sql_common = "  ch_id = '{$ch_id}',
					cl_text = '{$cl_text}'";

    sql_query(" insert into dr_charline set {$sql_common} ");
} elseif ($w == 'cu') {
	$cl_id = trim($_GET['cl_id']);
    
    if (!(isset($cl['cl_id']) && $cl['cl_id'])) {
        alert('존재하지 않는 대사 자료입니다.');
    }

    // 현재 데이터 조회
    $row = sql_fetch("select * from dr_charline where cl_id = '{$cl_id}' ");
    
    $sql = " update dr_charline
                set cl_text = '{$cl_text}'
                where cl_id = '{$cl_id}' ";
	
    sql_query($sql);
} elseif ($w == 'cd') {
    $cl_id = trim($_GET['cl_id']);

    $sql = " delete from dr_charline where  cl_id = '{$cl_id}' ";
	sql_query($sql);
} else {
    alert('제대로 된 값이 넘어오지 않았습니다.');
}

goto_url('./character.php?ch_id=' . $ch_id, false);
