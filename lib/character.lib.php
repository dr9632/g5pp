<?php
if (!defined('_GNUBOARD_')) exit;

/*************************************************************************
**
**  캐릭터 관련 함수 모음
**
*************************************************************************/

// 캐릭터 기본 정보 가져오기
function get_character($ch_id)
{
	global $g5;
	$character = sql_fetch("select * from {$g5['character_table']} where ch_id = '{$ch_id}'");
	
	return $character;
}

// 캐릭터 목록 가져오기
function get_character_list() {
	global $g5;

	$character = array();

	// $sql_search = '';

	$sql_common = "select *
			from	{$g5['character_table']}
			order by ch_id asc";

	$result = sql_query($sql_common);

	for($i=0; $row=sql_fetch_array($result); $i++) {
		$character[] = $row;
	}

	return $character;
}
// 캐릭터 삭제
function character_delete($ch_id)
{
    global $config;
    global $g5;

    $sql = " select ch_id from {$g5['character_table']} where ch_id= '".$ch_id."' ";
    $ch = sql_fetch($sql);

    // 캐릭터와 연결된 대사 삭제
	sql_query(" delete from dr_charline where ch_id = '$ch_id' ");

    // 디렉토리 삭제
    @unlink(G5_DATA_PATH.'/character/'.$ch_id);

	// 캐릭터 삭제
	sql_query(" delete from {$g5['character_table']} where ch_id = '$ch_id' ");

    run_event('character_delete_after', $ch_id);
}
?>