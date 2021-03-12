<?php 

    session_start();
    include "include_view.php";   

?>

<div class="container" style='margin-top:0px !important;'>
  <div class="d-flex align-self-center">
    <div class="col-lg-6 col-lg-offset-3 text-center well" style='margin-top: 20px;'>
      <!-- <div class='center-block text-center'>
        <img src='/img/logo.jpg' class="img-rounded" style='margin-bottom: 15px;height: 50px;'>
      </div> -->
      <form class="form-horizontal" role="form"  method='post'>
        <div class="form-group">
          <label class="control-label col-sm-2" for="email">Email:</label>
          <div class="col-sm-10">
            <input type="email" class="form-control" id="email" name="email" placeholder="Insert your email">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="pwd">Password:</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" id="password" name="password" placeholder="Insert your password">
          </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-8">
              <input type="hidden" name="saveSession" value=0>
              <input type="checkbox" name="saveSession" value="1">&nbsp;Stay Connection
            </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-8">
            <button type="submit" name="submit" class="btn btn-primary">Enter</button>
          </div>
        </div>
      </form>
      </div>
  </div>
</div>

<?php 

  include "../include/footer.php"; 

?>