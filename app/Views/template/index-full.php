
<?= view_cell('App\Cells\Template\HeaderCell', ['title' => $title]); ?>
<?= view_cell('App\Cells\Template\CustomCssCell'); ?>
<style>
  .btn-outline-orange{
    border-color: #e1883a; 
    color: #e1883a; 
  }
  .btn-outline-orange.active{
    background-color: #e1883a;
    border-color: #e1883a;
    color: var(--bs-btn-active-color);
  }
  .btn-outline-orange:hover{
    background-color: #e1883a;
    border-color: #e1883a;
    color: var(--bs-btn-active-color);
  }

</style>
</head>
<body class="">
    <div class="wrapper">
        <div class="content">
            <!-- Sidebar -->
            <nav class="d-flex flex-column flex-shrink-0 p-3 sidebar">
                <?= view_cell('App\Cells\Template\SideBarCell'); ?>
            </nav>
            
            <!-- Main content -->
            <div class="main-content">
                <!-- Top Navbar -->
                <nav class="navbar navbar-expand-lg navbar-light bg-light shadow">
                    <div class="container-fluid">
                        <?= view_cell('App\Cells\Template\TopNavBarCell') ?> 
                        <?= view_cell('App\Cells\Template\UserCell') ?>
                    </div>
                </nav>
                
                <main class="mt-4 px-4 ">

                    <?= view_cell('App\Cells\Template\BreadCrumbsCell', ['breadcrumbs' => $breadcrumbs ]) ?>

                    <div class="row">
                        <div class="col-12 px-5">
                            <div class="row hide-scrollbar">
                                <?= (isset($content)) ?$content : '' ?>
                            </div>
                        </div>
                    </div>
                </main>
                
                <!-- Sticky Footer -->
                <footer class="footer text-body-tertiary"><span>Copyright &copy; <?= (isset($site_name)) ? $site_name : ''  ?> <?= date('Y'); ?></span></footer>
            </div>
        </div>
    </div>
    
<?= view_cell('App\Cells\Template\FooterCell') ?>

<script>
    $(document).ready(function(){
        function updateDateTime()
        {
            var now = new Date(); 
            var hours = now.getHours(); 
            var mins = now.getMinutes().toString().padStart(2,'0'); 
            var secs = now.getSeconds().toString().padStart(2,'0');
            var day = now.getDate(); 
            var month = now.getMonth();
            var year = now.getFullYear();
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July' , 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            const daysOfWeek = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
            const hourFormat = [ '1','2','3','4','5','6','7','8','9','10','11','12','1','2','3','4','5','6','7','8','9','10','11','12'];

            str = months[month] + " " + day + ", " + year + " - " + hourFormat[hours-1] + ":" + mins + ":" + secs; 
            $('#navbar_time').text(str);
            
        }
        updateDateTime(); 
        setInterval(updateDateTime, 1000);
    })
</script>


<?= isset($js)? $js : ''  ?>



