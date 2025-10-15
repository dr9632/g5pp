<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$outlogin_skin_url.'/style.css">', 0);
?>

<!-- 로그인 후 아웃로그인 시작 { -->
<section id="ol_after" class="ol">
    <header id="ol_after_hd">
        <h2>나의 회원정보</h2>
        <a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=register_form.php" title="정보수정">
            <span class="profile_img">
                <?php echo get_member_profile_img($member['mb_id']); ?>
            </span>
            <strong><?php echo $nick ?></strong>
        </a>
        <?php if ($is_admin == 'super' || $is_auth) {  ?><a href="<?php echo correct_goto_url(G5_ADMIN_URL); ?>" class="btn_admin btn" title="관리자"><i class="fa fa-cog fa-spin fa-fw"></i><span class="sound_only">관리자</span></a><?php }  ?>
    </header>
    <ul id="ol_after_private">
        <li>
            <a href="<?php echo G5_BBS_URL ?>/memo.php" target="_blank" id="ol_after_memo" class="win_memo">
                <i class="fa fa-envelope-o" aria-hidden="true"></i><span class="unread_badge"><strong><?php echo $memo_not_read; ?></strong></span>
            </a>
        </li>
        <li>
            <a href="<?php echo G5_BBS_URL ?>/mypage.php" target="_blank" id="ol_after_scrap" class="win_mypage">
                <i class="fa fa-user" aria-hidden="true"></i>
            </a>
        </li>
        <li>
            <a href="<?php echo G5_BBS_URL ?>/scrap.php" target="_blank" id="ol_after_scrap" class="win_scrap">
                <i class="fa fa-thumb-tack" aria-hidden="true"></i>
            </a>
        </li>
        <li>
            <a href="<?php echo G5_BBS_URL ?>/logout.php" id="ol_after_logout"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
        </li>
    </ul>
</section>

<script>
// 탈퇴의 경우 아래 코드를 연동하시면 됩니다.
function member_leave()
{
    if (confirm("정말 회원에서 탈퇴 하시겠습니까?"))
        location.href = "<?php echo G5_BBS_URL ?>/member_confirm.php?url=member_leave.php";
}
</script>
<!-- } 로그인 후 아웃로그인 끝 -->
