<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="/docs/4.1/assets/img/favicons/favicon.ico">

  <title>Starter Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->

  <link rel="stylesheet" href="<?php echo base_url("assets/dist/css/bootstrap.min.css"); ?>" >
  
  <!-- Custom styles for this template -->
  <style>
    body {
      padding-top: 5rem;
    }
    .starter-template {
      padding: 3rem 1.5rem;
      text-align: center;
    }
  </style>
   


</head>

<body>

  <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
                            <?= anchor('horario', 
                       '<span data-feather="calendar"></span> Horário', 
                        array('class'=>'nav-link'))?>
                        </li>     
                        
                        <li class="nav-item">
                            <?= anchor('alocacao', 
                       '<span data-feather="user-check"></span> Alocar Professor', 
                        array('class'=>'nav-link'))?>
                        </li>


        <li class="nav-item">
          <a class="nav-link disabled" href="#">Disabled</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="https://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
          <div class="dropdown-menu" aria-labelledby="dropdown01">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>
    </div>
  </nav>

  <main role="main" class="">

    <div class="starter-template">      
         <?= $this->renderSection('content');?>
    </div>


  

  </main><!-- /.container -->

  <!-- Bootstrap core JavaScript
    ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->


  <script src="<?= base_url("assets/dist/js/jquery-3.3.1.slim.min.js") ?>" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

  <script>
    window.jQuery || document.write('<script src="<?= base_url("assets/dist/js/jquery-3.3.1.slim.min.js") ?>"><\/script>')
  </script>
  <script src="<?= base_url("assets/dist/js/popper.min.js") ?>"></script>
  <script src="<?= base_url("assets/dist/js/bootstrap.min.js") ?>"></script>
  <script src="<?=base_url("assets/dist/js/dashboard.js")?>"></script>
  <script src="<?=base_url("assets/js/script.js")?>"></script>
</body>

</html>