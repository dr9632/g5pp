<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/character.lib.php');

$ch_id = trim($_POST['ch_id']);
$ch = get_character($ch_id);
$mb_id = trim($_POST['mb_id']);

if(!$mb_id)
	alert('존재하지 않는 회원 정보 입니다.');

$ch_name = isset($_POST['ch_name']) ? trim(strip_tags($_POST['ch_name'])) : '';
$sql_common = "  ch_name = '{$ch_name}'";

$character_image_path = G5_DATA_PATH."/character/".$mb_id;
$character_image_url = G5_DATA_URL."/character/".$mb_id;

if ($_POST['w'] == 'a') {
	// 캐릭터 디렉토리 생성
	@mkdir($character_image_path, G5_DIR_PERMISSION);
	@chmod($character_image_path, G5_DIR_PERMISSION);

	$sql_common .= ", mb_id = '{$mb_id}'";
}

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

if ($_POST['w'] == 'a') {
    sql_query(" insert into {$g5['character_table']} set {$sql_common} ");
	$ch_id = sql_insert_id();
}
else if($_POST['w'] == 'u') {
	if(!($mb_id ==$ch['mb_id']))
		alert('수정 권한이 없는 캐릭터 입니다.');

	$sql = " update {$g5['character_table']}
                set {$sql_common}
                where ch_id = '{$ch_id}' ";
    sql_query($sql);
}

goto_url('./character.php?ch_id=' . $ch_id, false);
