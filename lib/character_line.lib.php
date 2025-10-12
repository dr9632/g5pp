<?php
if (!defined('_GNUBOARD_')) exit;

/*************************************************************************
**
**  캐릭터 대사 관련 함수 모음
**
*************************************************************************/

// 등록된 캐릭터 대사 수 가져오기
function get_character_line_cnt($ch_id)
{
	$cl_cnt = sql_fetch("select count(*) as cnt from dr_charline where ch_id = '{$ch_id}'");

	return $cl_cnt['cnt'];
}

// 캐릭터 대사 가져오기
// (변수 지정되지 않았을 시 전체를 불러옴)
function get_character_line($ch_id='',$cl_id='') {
	if($cl_id) {
		$sql_common = "select * from dr_charline where cl_id = '{$cl_id}'";
	} else if($ch_id) {
		$sql_common = "select * from dr_charline where ch_id = '{$ch_id}'";
	} else {
		$sql_common = "select * from dr_charline";
	}

	$result = sql_query($sql_common);
	for($i=0; $row=sql_fetch_array($result); $i++) {
		$cl_line[] = $row;
	}

	return $cl_line;
}
?>