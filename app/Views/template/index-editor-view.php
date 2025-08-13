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
    <link rel="stylesheet" href="<?= base_url(MANAGEDASSETS.'trumbowyg/dist/ui/trumbowyg.min.css')?>">
          
    </head>    
    <body> 
        <!-- Begin page content -->
        <main class="container-fluid m-0 g-0">
            <div class="row">
                <div class="col-10 mx-auto">
                    <?= ($content) ?? '' ?>
                </div>
            </div>
        </main>    
        <!-- footer start: place footer elements, scripts, and addtitional components (modals, popup, alerts, etc...) here --> 
            
        <!-- Bootstrap core JavaScript-->
        <script src="<?= base_url(MANAGEDASSETS.'jquery/dist/jquery.js') ?>"></script>
        <script src="<?= base_url(MANAGEDASSETS.'bootstrap/dist/js/bootstrap.bundle.js') ?>"></script>
        <script src="<?= base_url(MANAGEDASSETS.'trumbowyg/dist/trumbowyg.min.js')?>"></script>

        <script>
            $(document).ready(function(){
                $('#start-message').trumbowyg({
                    btns: [ 
                        ['undo', 'redo'], 
                        ['formatting'],
                        ['strong', 'em', 'del'],
                        ['link'],
                    ],
                    height: 50,
                    autogrow: true,
                });
                $('#end-message').trumbowyg({
                    btns: [ 
                        ['undo', 'redo'], 
                        ['formatting'],
                        ['strong', 'em', 'del'],
                        ['link'],
                    ],

                });
            })
        </script>
    </body>
</html>