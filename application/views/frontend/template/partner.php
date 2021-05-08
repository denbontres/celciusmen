<?php
    $ci = get_instance();
    $ci->load->model('BrandModel','brand');
    $brand = $ci->brand->getAll();
?>
