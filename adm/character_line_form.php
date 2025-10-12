<?php
$sub_menu = "400200";
include_once('./_common.php');
include_once(G5_LIB_PATH.'/character.lib.php');
include_once(G5_LIB_PATH.'/character_line.lib.php');

auth_check($auth[$sub_menu], 'w');
$ch = get_character($ch_id);
$cl = get_character_line($ch_id);

if ($w == '')
{
	if (!$ch['ch_id'])
	alert('존재하지 않는 캐릭터입니다.');
	$html_title = $ch['ch_name'];
}
else
	alert('제대로 된 값이 넘어오지 않았습니다.');

$g5['title'] .= $html_title.' 대사 목록';
include_once('./admin.head.php');

// add_javascript('js 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_javascript(G5_POSTCODE_JS, 0);    //다음 주소 js
?>

<form name="fcharacterline" id="fcharacterline" action="./character_line_form_update.php" onsubmit="return fcharacter_submit(this);" method="post" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">
<input type="hidden" name="ch_id" value="<?php echo $ch_id ?>">

<div class="tbl_frm01 tbl_wrap">
	<table>
	<caption><?php echo $g5['title']; ?></caption>
	<colgroup>
		<col class="grid_4">
		<col>
		<col class="grid_4">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row"><label for="ch_name">캐릭터 이름<?php echo $sound_only ?></label></th>
		<td><?php echo $ch['ch_name'] ?></td>
		<th scope="row"><label for="mb_id">오너 아이디<?php echo $sound_only ?></label></th>
		<td><?php echo $ch['mb_id'] ?></td>
	</tr>
	<tr>
		<th scope="row"><label for="cl_text">신규 등록</label></th>
		<td colspan="3">
            <input type="text" name="cl_text" id="cl_text" class="frm_input" size="120">&nbsp;&nbsp;<input type="submit" value="추가" class="btn_submit" style="padding: 8px 12px; border: 0px;" accesskey='s'>
		</td>
	</tr>
    <tr>
		<th scope="row"><label for="ch_head">등록 목록</label></th>
		<td colspan="3">
            <? if(isset($cl)) {
				for($i=0; $le=$cl[$i];$i++){
					$one_update = '<a href="./character_line_form_update.php?w=u&amp;cl_id=' . $le['cl_id'] . '&amp;' . $qstr . '" class="btn btn_01" style="padding:0px 6px; height:24px; line-height:23px">수정</a>';
					$one_delete = '<a href="./character_line_delete.php?cl_id=' . $le['cl_id'] . '&amp;ch_id=' . $le['ch_id'] . '" class="btn btn_01" style="padding:0px 6px; height:24px; line-height:23px">삭제</a>';
					echo $one_delete." ".$le['cl_text']."<br/>";
				}
			} else {?>
				등록된 대사가 없습니다.
			<? } ?>
		</td>
	</tr>
	</tbody>
	</table>
</div>

<div class="btn_confirm01 btn_confirm">
	<a href="./character_list.php?<?php echo $qstr ?>">목록</a>
</div>
</form>

<script>
function fcharacter_submit(f)
{
	return true;
}
</script>

<?php
include_once('./admin.tail.php');
?>