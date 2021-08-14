<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
  <head> 
    
    <!-- Dropzone CSS & JS -->
    <link href='<?= base_url() ?>resources/dropzone-5.7.0/dist/dropzone.css' type='text/css' rel='stylesheet'>
    <script src='<?= base_url() ?>resources/dropzone-5.7.0/dist/dropzone.js' type='text/javascript'></script>
    
    <!-- Dropzone CDN -->
     
    <link href='https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.css' type='text/css' rel='stylesheet'>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js' type='text/javascript'></script>
    
    <script>
    // Add restrictions
    Dropzone.options.fileupload = {
      acceptedFiles: 'image/*',
      maxFilesize: 1,
      parallelUploads: 1
    };

    
    
    </script>
    <style>

      .dropzone{
        width:70%;
        margin-left:15%;
        margin-top:1.5%;
        border:none;
        background-color:transparent;
        color:white;
        border-bottom:3px solid white;
        font-size:1.2em;
      }
      .dropzone:hover{
        background-color:rgba(191, 191, 191,0.3);
        border-top-left-radius:12px;
        border-top-right-radius:12px;
      }

      .title{
        font-size:1.3em;
        margin-left:15%;
        color:white;
      }
      .tips{
        margin-left:15%;
        color:white;
        margin-top:1%;
      }
    </style>
  </head>
  <body>
      <div class="title">Upload the cover image of your post in the drop area.</div>
      <div class="tips">(if you processing more than one post, please upload your cover with the same order)</div>
    <div class='content'>
      <!-- Dropzone -->
      <form action="<?= base_url('index.php/Drag_images/dragfileUpload') ?>" class="dropzone" id="fileupload">
      
      </form> 
    </div>



  </body>
</html>