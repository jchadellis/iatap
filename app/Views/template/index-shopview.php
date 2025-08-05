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
        
    <style>

        .bg-color-1{
            background-color: #2196F3;
        }
        .bg-color-2{
            background-color: #FFFFFF;
        }
        .bg-color-3{
            background-color: #dddddd;
        }
        .bg-color-4{
            background-color: #F1F0E8;
        }
        .header{
            position: sticky; top: 0px; 
        }
        .bg-info{
            background-color: #cde6edff !important; 
        }

    </style>
    </head>    
    <body> 
        <!-- Begin page content -->
        <main class="container-fluid m-0 g-0">
            <?= ($content) ?? '' ?>
        </main>    
        <!-- footer start: place footer elements, scripts, and addtitional components (modals, popup, alerts, etc...) here --> 
            
        <!-- Bootstrap core JavaScript-->
        <script src="<?= base_url(MANAGEDASSETS.'jquery/dist/jquery.js') ?>"></script>
        <script src="<?= base_url(MANAGEDASSETS.'bootstrap/dist/js/bootstrap.bundle.js') ?>"></script>

        <script>
            $(document).ready(function(){
                $('.part-row').click(function(){
                    if($(this).hasClass('border-primary bg-info'))
                    {
                        $(this).removeClass('border-primary bg-info'); 
                        return;
                    }
                    $(this).addClass("border-primary bg-info");

                })

                $('.check').click(function(){
                    if($(this).hasClass('bi-circle'))
                    {
                        $(this).removeClass('bi-circle'); 
                        $(this).addClass('bi-check-circle-fill text-success');    
                        return;
                    }
                    $(this).removeClass('bi-check-circle-fill text-success');
                    $(this).addClass('bi-circle');
                })
            })
        </script>    
    </body>
</html>