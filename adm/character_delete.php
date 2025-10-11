<?php
$sub_menu = "400100";
require_once "./_common.php";
include_once(G5_LIB_PATH.'/character.lib.php');

if (!defined('_GNUBOARD_')) {
    exit;
}

$ch = isset($_GET['ch_id']) ? get_character($_GET['ch_id']) : array();

if (!(isset($ch['ch_id']))) {
    alert("캐릭터 자료가 존재하지 않습니다.");
} else {
    $prev_file_path = str_replace(G5_URL, G5_PATH, $ch['ch_thumb']);
	@unlink($prev_file_path);
	$prev_file_path = str_replace(G5_URL, G5_PATH, $ch['ch_head']);
	@unlink($prev_file_path);
	$prev_file_path = str_replace(G5_URL, G5_PATH, $ch['ch_body']);
	@unlink($prev_file_path);

	$sql = " delete from {$g5['character_table']} where  ch_id = '{$ch['ch_id']}' ";
	sql_query($sql);

    $sql = " update {$g5['member_table']}
				set ch_id = ''
				where mb_id = '{$ch['mb_id']}' and ch_id = '{$ch['ch_id']}' ";
	sql_query($sql);
}

goto_url("./character_list.php");
