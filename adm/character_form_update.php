<?php
$sub_menu = "400100";
require_once "./_common.php";
require_once G5_LIB_PATH . "/character.lib.php";
require_once G5_LIB_PATH . '/thumbnail.lib.php';

if ($w == 'u') {
    check_demo();
}

auth_check_menu($auth, $sub_menu, 'w');

check_admin_token();

$ch_id = trim($_POST['ch_id']);
$mb = get_member($mb_id);
if(!$mb['mb_id']) {
	alert('존재하지 않는 회원 정보 입니다.');
}

$character_image_path = G5_DATA_PATH."/character/".$ch_id;
$character_image_url = G5_DATA_URL."/character/".$ch_id;

// 캐릭터 디렉토리 생성
@mkdir($character_image_path, G5_DIR_PERMISSION);
@chmod($character_image_path, G5_DIR_PERMISSION);


$mb_id = isset($_POST['mb_id']) ? trim($_POST['mb_id']) : '';
$ch_name = isset($_POST['ch_name']) ? trim(strip_tags($_POST['ch_name'])) : '';

$sql_common = "  ch_name = '{$ch_name}',
                 mb_id = '{$mb_id}'";

// 이미지 등록
// -- 두상
if($_FILES['ch_thumb_file']['name']) {
	// 확장자 따기
	$exp = explode(".", $_FILES['ch_thumb_file']['name']);
	$exp = $exp[count($exp)-1];

	$image_name = "thumb_".time().".".$exp;
	upload_file($_FILES['ch_thumb_file']['tmp_name'], $image_name, $character_image_path);
	$ch_thumb = $character_image_url."/".$image_name;
}
$sql_common .= " , ch_thumb = '{$ch_thumb}'";

// -- 흉상
if($_FILES['ch_head_file']['name']) {
	// 확장자 따기
	$exp = explode(".", $_FILES['ch_head_file']['name']);
	$exp = $exp[count($exp)-1];

	$image_name = "head_".time().".".$exp;
	upload_file($_FILES['ch_head_file']['tmp_name'], $image_name, $character_image_path);
	$ch_head = $character_image_url."/".$image_name;
}
$sql_common .= " , ch_head = '{$ch_head}'";

// -- 전신
if($_FILES['ch_body_file']['name']) {
	// 확장자 따기
	$exp = explode(".", $_FILES['ch_body_file']['name']);
	$exp = $exp[count($exp)-1];

	$image_name = "body_".time().".".$exp;
	upload_file($_FILES['ch_body_file']['tmp_name'], $image_name, $character_image_path);
	$ch_body = $character_image_url."/".$image_name;
}
$sql_common .= " , ch_body = '{$ch_body}'";

if ($w == '') {
    sql_query(" insert into {$g5['character_table']} set {$sql_common} ");

    $ch_id = sql_insert_id();
	if($mb['ch_id'] == "") sql_query("update {$g5['member_table']} set ch_id = '{$ch_id}' where mb_id = '{$mb['mb_id']}'");
} elseif ($w == 'u') {
    $ch = get_character($ch_id);
    if (!(isset($ch['ch_id']) && $ch['ch_id'])) {
        alert('존재하지 않는 캐릭터 자료입니다.');
    }

    // 현재 데이터 조회
    $row = sql_fetch("select * from {$g5['character_table']} where ch_id = '{$ch_id}' ");
    $agree_items = [];
    
    $sql = " update {$g5['character_table']}
                set {$sql_common}
                where ch_id = '{$ch_id}' ";
    sql_query($sql);
} else {
    alert('제대로 된 값이 넘어오지 않았습니다.');
}

run_event('admin_character_form_update', $w, $ch_id);

goto_url('./character_form.php?' . $qstr . '&amp;w=u&amp;ch_id=' . $ch_id, false);
