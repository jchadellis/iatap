<?= view_cell('App\Cells\Template\HeaderCell', ['title' => (isset($title)) ? $title : 'New Page']); ?>

<?= view_cell('App\Cells\Template\CustomCssCell'); ?>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        <img src="<?= base_url(ASSETSPATH.'/img/iatap_logo.svg')?>" alt="" style="height: 65px;" >
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="mainNavbar">
        <ul class="navbar-nav ms-auto">
          <!-- <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Features</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Pricing</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Contact</a></li> -->
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="row p-2 m-2">
    <div class="col-6">
        <h5 class="h5 text-end">Display Name:</h5> 
    </div>
    <div class="col">
        <?= ($asset->display_name) ?? '' ?>
    </div>
  </div>
  <div class="row p-2 m-2">
    <div class="col-6">
        <h5 class="h5 text-end">Network Name:</h5> 
    </div>
    <div class="col">
        <?= ($asset->network_name) ?? '' ?>
    </div>
  </div>
  <div class="row p-2 m-2">
    <div class="col-6">
        <h5 class="h5 text-end">Type:</h5> 
    </div>
    <div class="col">
        <?= ($asset->type) ?? '' ?>
    </div>
  </div>
  <div class="row p-2 m-2">
    <div class="col-6">
        <h5 class="h5 text-end">IP Address:</h5> 
    </div>
    <div class="col">
        <?= ($asset->ip_address) ?? '' ?>
    </div>
  </div>
  <div class="row p-2 m-2">
    <div class="col-6">
        <h5 class="h5 text-end">Manufacturer:</h5> 
    </div>
    <div class="col">
        <?= ($asset->make) ?? '' ?> 
        <?= ($asset->model) ?? '' ?>
    </div>
  </div>
  <div class="row p-2 m-2">
    <div class="col-6">
        <h5 class="h5 text-end">Department:</h5> 
    </div>
    <div class="col">
        <?= ($asset->department) ?? '' ?> 
    </div>
  </div>
  </div>
  <div class="row p-2 m-2">
    <div class="col-6">
        <h5 class="h5 text-end">Switch:</h5> 
    </div>
    <div class="col">
        <?= ($asset->switch_name) ?? '' ?>
        Port # <?= ($asset->switch_port_no) ?? '' ?>
    </div>
  </div>

  <div class="row p-2 m-2">
    <div class="col-6">
        <h5 class="h5 text-end">OS:</h5> 
    </div>
    <div class="col">
        <?= ($asset->operating_system) ?? '' ?> <?= ($asset->version) ?? '' ?>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>