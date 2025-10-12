<?php
$sub_menu = "400200";
require_once './_common.php';

auth_check_menu($auth, $sub_menu, 'r');

$sql_common = " from {$g5['character_table']} a ";
$sql_search = " where (1) ";

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        default:
            $sql_search .= " ($sfl like '%$stx%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst  = "ch_state asc";
    $sod = "";
}
$sql_order = " order by $sst $sod ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) {
    $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
}
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$listall = '<a href="' . $_SERVER['SCRIPT_NAME'] . '" class="ov_listall">전체목록</a>';

$g5['title'] = '캐릭터 대사 관리';
require_once './admin.head.php';

$colspan = 4;

// 추가 테이블 설치 여부 확인 (테이블조회)
$ch_line = sql_fetch(" select COUNT(*) AS cnt FROM information_schema.TABLES WHERE `TABLE_NAME` = 'dr_charline' AND TABLE_SCHEMA = '".G5_MYSQL_DB."' ");
$is_ch_line = $ch_line['cnt'];

?>

<?php if($is_ch_line > 0) { ?>

<div class="local_ov01 local_ov">
    <?php echo $listall ?>
    <span class="btn_ov01"><span class="ov_txt">생성된 캐릭터수</span><span class="ov_num"> <?php echo number_format($total_count) ?>개</span></span>
</div>

<form name="fsearch" id="fsearch" class="local_sch01 local_sch" method="get">
    <label for="sfl" class="sound_only">검색대상</label>
    <select name="sfl" id="sfl">
        <option value="ch_name" <?php echo get_selected($sfl, "ch_name"); ?>>캐릭터명</option>
        <option value="mb_id" <?php echo get_selected($sfl, "bo_subject"); ?>>오너 아이디</option>
    </select>
    <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
    <input type="text" name="stx" value="<?php echo $stx ?>" id="stx" required class="required frm_input">
    <input type="submit" value="검색" class="btn_submit">
</form>

<form name="fcharacterlist" id="fcharacterlist" action="./character_list_update.php" onsubmit="return fcharacterlist_submit(this);" method="post">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="token" value="<?php echo isset($token) ? $token : ''; ?>">
    <input type="hidden" name="ch_id" value="<?php echo $ch_id ?>">
    <input type="hidden" name="install" value="1" id="install">

    <div class="tbl_head01 tbl_wrap">
        <table>
            <caption><?php echo $g5['title']; ?> 목록</caption>
            <thead>
                <tr>
                    <th scope="col"><?php echo subject_sort_link('ch_name') ?>캐릭터명</a></th>
                    <th scope="col"><?php echo subject_sort_link('mb_id') ?>오너 아이디</a></th>
                    <th scope="col">대사 수</th>
                    <th scope="col">관리</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $row = sql_fetch_array($result); $i++) {
                    $one_update = '<a href="./character_form.php?w=u&amp;ch_id=' . $row['ch_id'] . '&amp;' . $qstr . '" class="btn btn_03">수정</a>';

                    $bg = 'bg' . ($i % 2);
                ?>

                    <tr class="<?php echo $bg; ?>">
                        <td>
                            <input type="hidden" name="character_table[<?php echo $i ?>]" value="<?php echo $row['ch_name'] ?>">
                            <?php echo $row['ch_name'] ?>
                        </td>
                        <td>
                            <input type="hidden" name="character_table[<?php echo $i ?>]" value="<?php echo $row['mb_id'] ?>">
                            <?php echo $row['mb_id'] ?>
                        </td>
                        <td>
                            대사수 출력
                        </td>
                        <td class="td_mng td_mng_m">
                            <?php echo $one_update ?>
                            <?php echo $one_delete ?>
                        </td>
                    </tr>
                <?php
                }
                if ($i == 0) {
                    echo '<tr><td colspan="' . $colspan . '" class="empty_table">등록된 캐릭터가 없습니다.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="btn_fixed_top">
        <?php if ($is_admin == 'super') { ?>
            <input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value" class="btn_02 btn">
            <a href="./character_form.php" id="ch_add" class="btn_01 btn">캐릭터 추가</a>
        <?php } ?>
    </div>

</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'] . '?' . $qstr . '&amp;page='); ?>

<?php } else { ?>

<section>
    
    <h2 class="h2_frm">페어/커플홈 테마용 추가환경 설치안내</h2>

    <div class="local_desc01 local_desc">
       
        <br><strong>캐릭터 대사 등록 및 관리 기능에 필요한 추가 DB테이블 설치가 필요합니다.</strong><br><br>
        다음 목록과 동일한 테이블명이 이미 존재할 경우 테이블 생성이 되지 않을 수 있습니다.<br>
        - dr_charline<br><br>
        
        이슈 발생 시 해당 프로젝트의 <a href="https://github.com/dr9632/g5pp/issues">Github 이슈란</a>에 등록 부탁드립니다.<br><br>
    </div>

</section>

<section>
    <form name="dradd_form" id="dradd_form" action="./character_line_list_update.php" method="post">
        <div class="btn_confirm01 btn_confirm">
            <input type="submit" value="DB 테이블 설치하기" class="btn_submit btn">
        </div>
    </form>
</section>

<script>
        $(document).ready(function() {
            $("#dradd_form").on("submit", function(event) {
                return true;
            });
        });
</script>

<?php } ?>

<script>
    function fbcharacterlist_submit(f) {
        if (!is_checked("chk[]")) {
            alert(document.pressed + " 하실 항목을 하나 이상 선택하세요.");
            return false;
        }

        if (document.pressed == "선택삭제") {
            if (!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
                return false;
            }
        }

        return true;
    }
</script>

<?php
require_once './admin.tail.php';
