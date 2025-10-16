<?php
$sub_menu = "400100";
require_once './_common.php';
include_once(G5_LIB_PATH.'/character.lib.php');

check_demo();
check_admin_token();
if (!(isset($_POST['chk']) && is_array($_POST['chk']))) {
    alert($_POST['act_button'] . " 하실 항목을 하나 이상 체크하세요.");
}

$post_count_chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? count($_POST['chk']) : 0;
$chk            = (isset($_POST['chk']) && is_array($_POST['chk'])) ? $_POST['chk'] : array();
$act_button     = isset($_POST['act_button']) ? strip_tags($_POST['act_button']) : '';

if ($act_button === "선택삭제") {
    auth_check_menu($auth, $sub_menu, 'd');

    for ($i = 0; $i < $post_count_chk; $i++) {
        // 실제 번호를 넘김
        $k = isset($chk[$i]) ? (int) $chk[$i] : 0;

        $ch_data[] = $ch = get_character($_POST['ch_id'][$k]);
		
		if (!$ch['ch_id']) {
			$msg .= $ch['ch_id'].' : 캐릭터 자료가 존재하지 않습니다.\\n';
		} else {
			// 캐릭터자료 삭제
            character_delete($ch['ch_id']);
		}
    }
}

if ($msg) {
    alert($msg);
}

run_event('admin_character_list_update', $_POST['act_button'], $ch_data);

goto_url('./character_list.php');
