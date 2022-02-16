  
   <?=view("main/header"); ?>  
   <main id="main" class="main">
    <div class="pagetitle">
        <h1><?=$title;?></h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Pages</li>
                <li class="breadcrumb-item active">Blank</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
   <?=$this->renderSection('content');?>
        </div>
    </section>
   </main>
   <?=view("main/footer"); ?>  

  