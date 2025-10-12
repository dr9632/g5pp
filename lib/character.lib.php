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
?>