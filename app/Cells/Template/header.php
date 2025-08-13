<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= (isset($title)) ? $title : ''  ?></title>
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url(ASSETSPATH.'img/iatap.png') ?>">
    
    <!-- Bootstrap CSS -->
    <link href="<?= base_url(ASSETSPATH.'css/custom-bootstrap.css')?>" rel="stylesheet" >
     
    <link href="<?= base_url(MANAGEDASSETS.'bootstrap-icons/font/bootstrap-icons.css') ?>" rel="stylesheet">
    <link href="<?= base_url(MANAGEDASSETS.'fontawesome-free/css/all.css') ?>" rel="stylesheet">

    <!-- <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet"> -->

    <!-- DataTables Styles --> 
    <link rel="stylesheet" href="<?= base_url(MANAGEDASSETS.'datatables.net-bs5/css/dataTables.bootstrap5.css')?>">
    <link rel="stylesheet" href="<?= base_url(MANAGEDASSETS.'datatables.net-buttons-bs5/css/buttons.bootstrap5.css')?>">
    <link rel="stylesheet" href="<?= base_url(MANAGEDASSETS.'datatables.net-responsive-bs5/css/responsive.bootstrap5.css')?>">
    <link rel="stylesheet" href="<?= base_url(MANAGEDASSETS.'datatables.net-select-bs5/css/select.bootstrap5.css')?>">

    <!-- Plugin Style Sheets --> 
    <link rel="stylesheet" href="<?= base_url(MANAGEDASSETS.'bootstrap-datepicker/dist/css/bootstrap-datepicker.css')?>">
    <link rel="stylesheet" href="<?= base_url(MANAGEDASSETS.'bootstrap5-toggle/css/bootstrap5-toggle.css')?>">

    <link rel="stylesheet" href="<?= base_url(MANAGEDASSETS.'flatpickr/dist/flatpickr.css')?>">
    <link rel="stylesheet" href="<?= base_url(MANAGEDASSETS.'sweetalert2/dist/sweetalert2.min.css')?>">
    <link rel="stylesheet" href="<?= base_url(MANAGEDASSETS.'trumbowyg/dist/ui/trumbowyg.min.css')?>">
    
    <style>
        .text-bg-lite-blue{
            background-color: #dbedfe;
        }
    </style>