<?php
    $ci = get_instance();
    $ci->load->model('BasicModel','basic');
    $basic = $ci->basic->getAllRow();
?>
