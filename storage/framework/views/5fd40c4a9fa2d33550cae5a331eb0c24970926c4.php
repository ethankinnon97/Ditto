<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>CSV upload</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>
    <?
    error_reporting();
     ?>
<div id="app">
  <input-form></input-form>
</div>


  <script src="<?php echo e(mix('js/app.js')); ?>"></script>

  </body>
</html>
<?php /**PATH /var/www/html/myProject/resources/views/form.blade.php ENDPATH**/ ?>