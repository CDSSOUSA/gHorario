<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">

    <div class="wrapper">

        <!-- <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="<?php //base_url()
                                                ?>/assets/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
        </div> -->
        <?= view('layouts2/menu-top'); ?>


        <aside class="main-sidebar sidebar-no-expand sidebar-dark-primary elevation-4">

            <a href="index3.html" class="brand-link">
                <img src="<?=base_url();?>/assets/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">AdminLTE 3</span>
            </a>

            <div class="sidebar">

                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?=base_url();?>/assets/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">Alexander Pierce</a>
                    </div>
                </div>

                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Professor
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <?=anchor('/professor','<i class="far fa-circle nav-icon"></i><p>Cadastrar</p>',['class'=>'nav-link']);?>
                                    
                                </li>
                                <li class="nav-item">
                                    <?=anchor('/professor/list','<i class="far fa-circle nav-icon"></i><p>Listar</p>',['class'=>'nav-link']);?>
                                    
                                </li>                               
                            </ul>
                        </li>
                        <li class="nav-item menu-open">
                           
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Horário
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?=base_url().'/'?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Visualizar</p>
                                    </a>
                                </li>

                               
                            </ul>
                      
                        </li>
                        
                       
                    </ul>
                </nav>

            </div>

        </aside>
        <div class="content-wrapper">
            <hr>
            <section class="content">
                <?= $this->renderSection('content'); ?>
            </section>
        </div>