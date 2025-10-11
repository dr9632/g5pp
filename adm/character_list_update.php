<?php
$sub_menu = "400100";
require_once './_common.php';
include_once(G5_LIB_PATH.'/character.lib.php');

check_demo();

$post_count_chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? count($_POST['chk']) : 0;
$chk            = (isset($_POST['chk']) && is_array($_POST['chk'])) ? $_POST['chk'] : array();
$act_button     = isset($_POST['act_button']) ? strip_tags($_POST['act_button']) : '';
$character_table    = (isset($_POST['character_table']) && is_array($_POST['character_table'])) ? $_POST['character_table'] : array();

if (!$post_count_chk) {
    alert($act_button . " 하실 항목을 하나 이상 체크하세요.");
}

check_admin_token();

if ($act_button === "선택삭제") {
    if ($is_admin != 'super') {
        alert('캐릭터 삭제는 최고관리자만 가능합니다.');
    }

    auth_check_menu($auth, $sub_menu, 'd');

    // _BOARD_DELETE_ 상수를 선언해야 board_delete.inc.php 가 정상 작동함
    /* 확인필요 22.05.27
    A file should declare new symbols (classes, functions, constants, etc.) and cause no other side effects,
    or it should execute logic with side effects, but should not do both.*/
    define('_CHARACTER_DELETE_', true);

    for ($i = 0; $i < $post_count_chk; $i++) {
        // 실제 번호를 넘김
        $k = isset($_POST['chk'][$i]) ? (int) $_POST['chk'][$i] : 0;

        $ch = get_character($_POST['ch_id'][$k]);
		
		if (!$ch['ch_id']) {
			$msg .= $ch['ch_id'].' : 캐릭터 자료가 존재하지 않습니다.\\n';
		} else {
			$sql = " delete from {$g5['character_table']} where ch_id = '" . $ch_id;
			sql_query($sql);
		}
    }
}

run_event('admin_character_list_update', $act_button, $chk, $character_table, $qstr);

goto_url('./character_list.php?' . $qstr);
