<?php
$sub_menu = "100110";
require_once './_common.php';

check_demo();

auth_check_menu($auth, $sub_menu, 'w');

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}

$sql = " select * from {$g5['config_table']} limit 1";
$ori_config = sql_fetch($sql);

$cf_title = isset($_POST['cf_title']) ? strip_tags(clean_xss_attributes($_POST['cf_title'])) : '';

$mb = get_member($cf_admin);

check_admin_token();

$sql = " update {$g5['config_table']}
            set cf_title = '{$cf_title}',
                cf_public = '{$_POST['cf_public']}',
                cf_open_register = '{$_POST['cf_open_register']}',
                cf_bgm = '{$_POST['cf_bgm']}'";
sql_query($sql);

//sql_query(" OPTIMIZE TABLE `$g5[config_table]` ");

run_event('admin_env_config_form_update');

update_rewrite_rules();

goto_url('./env_config_form.php', false);
