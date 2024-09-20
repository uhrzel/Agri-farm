<?php require_once('../config.php') ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<?php require_once('inc/header.php') ?>

<body class="hold-transition login-page">
  <script>
    function start_loader() {
      // Your loader start code here
    }

    function end_loader() {
      // Your loader end code here
    }

    start_loader();
  </script>
  <style>
    body {
      background-image: url("<?php echo validate_image($_settings->info('cover')) ?>");
      background-size: cover;
      background-repeat: no-repeat;
      backdrop-filter: contrast(1);
    }

    #page-title {
      text-shadow: 6px 4px 7px black;
      font-size: 3.5em;
      color: #fff4f4 !important;
      background: #8080801c;
    }
  </style>
  <h1 class="text-center text-white px-4 py-5" id="page-title"><b><?php echo $_settings->info('name') ?></b></h1>
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-primary my-2">
      <div class="card-body">
        <p class="login-box-msg">ATI - Login</p>
        <form id="login-ati" action="" method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="username" autofocus placeholder="Username">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <a href="#" id="signup-link">Sign Up</a>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
        <!-- /.social-auth-links -->

        <!-- <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p> -->

      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <!-- Sign Up Modal -->
  <div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="signupModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="signupModalLabel">Sign Up</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Sign Up Form or Content Here -->
          <form id="signup-frm" action="" method="post">
            <div class="form-group">
              <label for="ati-firstname">ATI Firstname</label>
              <input type="text" class="form-control" id="ati-firstname" name="firstname" placeholder="Enter your firstname">
            </div>
            <div class="form-group">
              <label for="ati-lastname">ATI Lastname</label>
              <input type="text" class="form-control" id="ati-lastname" name="lastname" placeholder="Enter your lastname">
            </div>
            <div class="form-group">
              <label for="ati-username">ATI Username</label>
              <input type="text" class="form-control" id="ati-username" name="username" placeholder="Enter your username">
            </div>
            <div class="form-group">
              <label for="ati-password">ATI Password</label>
              <input type="password" class="form-control" id="ati-password" name="password" placeholder="Enter your password">
            </div>
            <button type="submit" class="btn btn-primary">Sign Up</button>
          </form>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- jQuery -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

  <script>
    $(document).ready(function() {
      end_loader();

      // jQuery for showing the modal
      $('#signup-link').on('click', function(e) {
        e.preventDefault(); // Prevent default link behavior
        $('#signupModal').modal('show'); // Show the modal
      });
      $('#signup-frm').submit(function(e) {
        e.preventDefault();
        start_loader()
        if ($('.err-msg').length > 0)
          $('.err-msg').remove();
        $.ajax({
          url: _base_url_ + "classes/Master.php?f=ati_register",
          method: "POST",
          data: $(this).serialize(),
          dataType: "json",
          error: err => {
            console.log(err)
            alert_toast("an error occured", 'error')
            end_loader()
          },
          success: function(resp) {
            if (typeof resp == 'object' && resp.status == 'success') {
              location.reload()
            } else if (resp.status == 'failed' && !!resp.msg) {
              var _err_el = $('<div>')
              _err_el.addClass("alert alert-danger err-msg").text(resp.msg)
              $('[name="password"]').after(_err_el)
              end_loader()
            } else {
              console.log(resp)
              alert_toast("an error occured", 'error')
              end_loader()
            }
          }
        })
      })
    });
  </script>
</body>

</html>