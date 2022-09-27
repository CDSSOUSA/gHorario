<!DOCTYPE html>
<html lang="pb-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Dashboard</title>

    <?php
    //dd($css);    
   foreach ($css as $path) : ?>
      <link rel="stylesheet" href="<?= $path; ?>">
   <?php endforeach; ?>
    
</head>
