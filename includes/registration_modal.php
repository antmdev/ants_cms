
<div class="container">
  <!-- <h2>Login</h2>
   Trigger the modal with a button NOT USING THIS CODE-->
  <!-- <button type="button" class="btn btn-default btn-lg" id="myBtn">Login</button>  -->

  <!-- Modal -->
  <div class="modal fade" id="regModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        <form action="includes/registration.php" method="post"> 
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 style="color:purple; text-align:center;" ><span class="glyphicon glyphicon-lock"></span> REGISTER</h4>
        </div>
        <div class="modal-body">
          <form role="form">
            <div class="form-group">
              <label for="usrname"><span class="glyphicon glyphicon-user"></span> REGISTER</label>
              <input  name="username" type="text" class="form-control" id="usrname" placeholder="Enter email">
            </div>
            <div class="form-group">
              <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Password</label>
              <input name="password" type="text" class="form-control" id="psw" placeholder="Enter password">
            </div>
            <!-- <div class="checkbox">
              <label><input type="checkbox" value="" checked>Remember me</label>
            </div> -->
            <button type="submit" name="login" class="btn btn-default btn-success btn-block"><span class="glyphicon glyphicon-off" ></span> Login</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-default btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
         <p>Not a member? <a href="#">Sign Up</a></p>
          <!-- <p>Forgot <a href="#">Password?</a></p> -->
        </div>
      </div>
    </div>
    </form>
  </div> 
</div>




