<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <link href="css/bootstrap-4.3.1.css" rel="stylesheet" type="text/css">
    <style type="text/css">
    </style>
  </head>
  <body>
    <div class="container" style="width: 930px">
      <header>
        <img src="images/banner.jpg" width="900" height="200" alt="" />
      </header>
      <?php
        require_once 'nav.php';
        ?>
      <section style="margin-top: 20px">
        <form action="update.php" method="post">
          <div class="form-group row">
            <label for="patrolCarId" class="col-sm-4 col-form-label">
            Enter Patrol's Car Number 
            </label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="patrolCarId"
                     name="patrolCarId">
            </div>
             <div class="col-sm-2">
              <input class="btn btn-primary" name="btnSearch" type="submit"
                     value="Search">
            </div>
          </div>
        </form>
      </section>
      <footer
              class="page-footer font-small blue pt-4
                     footer-copyright text-center py-3">
            � 2020 Copyright:
            <a href="https://www.ite.edu.sg"> ITE </a>
      </footer>
    </div>
    <script type="text/javascript" src="js/jquery-3.3.1.min.js">
    </script>
    <script type="text/javascript" src="js/popper.min.js">
    </script>
    <script type="text/javascript" src="js/bootstrap-4.3.1.js">
    </script>
    <script type="text/javascript">
</script>
</body>
</html>




  