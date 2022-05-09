<?php

$lang['copyright'] = 'Pesan Lokal';
$lang['tagline'] = 'Easy Selling for FnB Business!';
if (getenv("CI_ENVIRONMENT") == 'production') {
    $lang['link_merchant'] = 'pesan.to';
    $lang['quicklink'] = 'quicklink.bio';
} else {
    $lang['link_merchant'] = 'site-test.pesanlokal.com';
    $lang['quicklink'] = 'link-test.pesanlokal.com';
}
$lang['css_primary'] = '#45eba5';
$lang['css_success'] = '#21aba5';
$lang['css_info'] = '#1d566e';
$lang['css_warning'] = '#163a5f';
$lang['css_orange'] = '#ffd201';
$lang['css_danger'] = '#ed5565';
$lang['onboarding'] = 'OB';
