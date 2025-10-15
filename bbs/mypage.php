<?php
include_once('./_common.php');

if (!$is_member)
    goto_url(G5_BBS_URL."/login.php?url=".urlencode(G5_BBS_URL."/mypage.php"));

if (G5_IS_MOBILE) {
    include_once(G5_MOBILE_PATH.'/mypage.php');
    return;
}

// 테마에 mypage.php 있으면 include
if(defined('G5_THEME_PATH')) {
    $theme_mypage_file = G5_THEME_PATH.'/mypage.php';
    if(is_file($theme_mypage_file)) {
        include_once($theme_mypage_file);
        return;
        unset($theme_mypage_file);
    }
}

$g5['title'] =  $member['mb_name'].' 마이페이지';
include_once('./_head.php');

?>

<!-- 마이페이지 시작 { -->
<div id="smb_my">

    <!-- 회원정보 개요 시작 { -->
    <section id="smb_my_ov">
        <h2>회원정보 개요</h2>
        <strong class="my_ov_name"><?php echo get_member_profile_img($member['mb_id']); ?> <?php echo $member['mb_name']; ?></strong>
        <dl class="cou_pt">
            <dt>보유포인트</dt>
            <dd><a href="<?php echo G5_BBS_URL; ?>/point.php" target="_blank" class="win_point"><?php echo number_format($member['mb_point']); ?></a> 점</dd>
        </dl>
        <div id="smb_my_act">
            <ul>
                <?php if ($is_admin == 'super') { ?><li><a href="<?php echo G5_ADMIN_URL; ?>/" class="btn_admin">관리자</a></li><?php } ?>
                <li><a href="<?php echo G5_BBS_URL; ?>/character.php" class="btn01">보유 캐릭터</a></li>
                <li><a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=register_form.php" class="btn01">회원정보수정</a></li>
                <li><a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=member_leave.php" onclick="return member_leave();" class="btn01">회원탈퇴</a></li>
            </ul>
        </div>

        <dl class="op_area">
            <dt>E-Mail</dt>
            <dd><?php echo ($member['mb_email'] ? $member['mb_email'] : '미등록'); ?></dd>
            <dt>최종접속일시</dt>
            <dd><?php echo $member['mb_today_login']; ?></dd>
            <dt>회원가입일시</dt>
            <dd><?php echo $member['mb_datetime']; ?></dd>
        </dl>
        <div class="my_ov_btn"><button type="button" class="btn_op_area"><i class="fa fa-caret-down" aria-hidden="true"></i><span class="sound_only">상세정보 보기</span></button></div>

    </section>
    <script>

        $(".btn_op_area").on("click", function() {
            $(".op_area").toggle();
            $(".fa-caret-down").toggleClass("fa-caret-up")
        });

    </script>
    <!-- } 회원정보 개요 끝 -->

    <!-- 최근 호출 내역 시작 { -->
    <section id="smb_my_wish">
        <h2>최근 호출 내역</h2>

        <div class="list_02">
            <ul>

            <?php
            $sql = " select *
                      from {$g5['call_table']}
                      where re_mb_id = '{$member['mb_id']}'
                      order by bc_datetime desc
                      limit 0, 8 ";
            $result = sql_query($sql);

            for($i = 0; $row = sql_fetch_array($result); $i++) { ?>
            <li>
                <div class="smb_my_img"><?php echo $row['mb_name']; ?></div>
                <div class="smb_my_tit"><a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$row['bo_table']?>&amp;log=<?=$row['wr_num'] * -1?>"><?=$row['memo']?></a></div>
                <div class="smb_my_date"><?php echo $row['bc_datetime']; ?></div>
            </li>
            <? }
            if($i == 0) echo '<li class="empty_li">호출 내역이 없습니다.</li>'; ?>
            </ul>
        </div>

        <div class="smb_my_more">
            <!-- <a href="./wishlist.php">더보기</a> -->
        </div>
    </section>
    <!-- } 최근 호출 내역 끝 -->
</div>

<script>
function member_leave()
{
    return confirm('정말 회원에서 탈퇴 하시겠습니까?')
}
</script>
<!-- } 마이페이지 끝 -->

<?php
include_once("./_tail.php");