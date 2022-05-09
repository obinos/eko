<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="shortcut icon" href="<?= base_url('assets/'); ?>img/iconarata.svg">
    <link rel="shortcut icon" sizes="192x192" href="<?= base_url('assets/'); ?>img/iconarata.svg">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('assets/'); ?>img/iconarata.svg">

    <title><?= $title; ?></title>

    <link href="<?= base_url('assets/'); ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/'); ?>css/animate.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/'); ?>css/style.css" rel="stylesheet">
    <link href="<?= base_url('assets/'); ?>css/<?= getenv("APP_BRAND") ?>.css" rel="stylesheet">

</head>

<body class="fixed-sidebar" id="page-top">
    <div class="flash-data" data-title="<?= $this->session->flashdata('title'); ?>" data-text="<?= $this->session->flashdata('text'); ?>" data-type="<?= $this->session->flashdata('type'); ?>" data-show="<?= $this->session->flashdata('show'); ?>" data-link="<?= $this->session->flashdata('link'); ?>"></div>
    <div id="wrapper">