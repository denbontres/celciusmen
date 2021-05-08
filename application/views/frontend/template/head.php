<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Fashi Template">
    <meta name="keywords" content="Fashi, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=$title?></title>

    <link rel="stylesheet" href="<?=base_url('asset/frontend/assets/')?>bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=base_url('asset/frontend/assets/')?>fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="<?=base_url('asset/frontend/assets/')?>fonts/font-awesome.min.css">
    <link rel="stylesheet" href="<?=base_url('asset/frontend/assets/')?>fonts/ionicons.min.css">
    <link rel="stylesheet" href="<?=base_url('asset/frontend/assets/')?>fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="<?=base_url('asset/frontend/assets/')?>fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="<?=base_url('asset/frontend/assets/')?>css/Accordion.css">
    <link rel="stylesheet" href="<?=base_url('asset/frontend/assets/')?>css/back-top.css">
    <link rel="stylesheet" href="<?=base_url('asset/frontend/assets/')?>css/filter.css">
    <link rel="stylesheet" href="<?=base_url('asset/frontend/assets/')?>css/footer-clean.css">
    <link rel="stylesheet" href="<?=base_url('asset/frontend/assets/')?>css/g-style-text-input.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/css/lightbox.min.css">
    <link rel="stylesheet" href="<?=base_url('asset/frontend/')?>css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?=base_url('asset/frontend/assets/')?>css/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?=base_url('asset/frontend/assets/')?>css/steps-progressbar.css">
    <link rel="stylesheet" href="<?=base_url('asset/frontend/assets/')?>css/styles.css">
    <link rel="stylesheet" href="<?=base_url('asset/frontend/')?>css/custom-aden.css">
    <link rel="stylesheet" href="<?=base_url('asset/frontend/assets/')?>css/tabs-arrow.css">

    <!--<link rel="stylesheet" href="<?=base_url('asset/frontend/')?>css/style.css" type="text/css">-->
    <!-- Jquery -->
    <script src="<?=base_url('asset/frontend/')?>js/jquery-3.3.1.min.js"></script>

    <!-- Toastr -->
    <link rel="stylesheet" href="<?=base_url('asset/backend/')?>plugins/toastr/toastr.min.css">
</head>

<body data-email="<?=$this->session->userdata('email')?$this->session->userdata('email'):''?>">