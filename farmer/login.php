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

    .custom-alert {
      width: 300px;
      /* Set your desired width */
      padding: 20px;
      /* Add some padding */
      border-radius: 10px;
      /* Optional: round the corners */
    }

    .custom-alert h2 {
      font-size: 18px;
      /* Adjust the title font size */
    }

    .custom-alert p {
      font-size: 14px;
      /* Adjust the text font size */
    }
  </style>
  <h1 class="text-center text-white px-4 py-5" id="page-title"><b><?php echo $_settings->info('name') ?></b></h1>
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-primary my-2">
      <div class="card-body">
        <p class="login-box-msg">Farmers - Login</p>
        <form id="login-frm-farmer" action="" method="post">
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
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
            <!-- /.col -->
          </div>

          <div class="row mt-2">
            <div class="col-12 text-center">
              <a href="#" id="forgot-password-link" data-toggle="modal" data-target="#forgotPasswordModal">Forgot Password?</a>

            </div>
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
          <form id="signup-frm" action="" method="post">
            <!-- Farmer Details -->
            <div class="form-group">
              <label for="farmer-firstname">Farmer Firstname</label>
              <input type="text" class="form-control" id="farmer-firstname" name="firstname" placeholder="Enter your firstname">
            </div>
            <div class="form-group">
              <label for="farmer-lastname">Farmer Lastname</label>
              <input type="text" class="form-control" id="farmer-lastname" name="lastname" placeholder="Enter your lastname">
            </div>
            <div class="form-group">
              <label for="farmer-username">Farmer Username</label>
              <input type="text" class="form-control" id="farmer-username" name="username" placeholder="Enter your username">
            </div>
            <div class="form-group">
              <label for="farmer-password">Farmer Password</label>
              <input type="password" class="form-control" id="farmer-password" name="password" placeholder="Enter your password">
            </div>

            <!-- Additional Fields -->
            <div class="form-group">
              <label>Type of Application</label><br>
              <input type="checkbox" id="new-application" name="type_application[]" value="New">
              <label for="new-application">New</label>
              <input type="checkbox" id="renewal-application" name="type_application[]" value="Renewal">
              <label for="renewal-application">Renewal PhilGap</label>
            </div>

            <div class="form-group">
              <label for="farm-name">Farm Name</label>
              <input type="text" class="form-control" id="farm-name" name="farm_name" placeholder="Enter your farm name">
            </div>
            <div class="form-group">
              <label for="email-address">Email Address</label>
              <input type="email" class="form-control" id="email-address" name="email_address" placeholder="Enter your email address">
            </div>
            <div class="form-group">
              <label for="mobile-number">Mobile Number</label>
              <input type="text" class="form-control" id="mobile-number" name="mobile_number" placeholder="Enter your mobile number">
            </div>

            <label>Farm Size and Address 1</label>
            <div class="form-group">
              <label for="hectarage-farm-size">Hectarage (Farm Size)</label>
              <input type="number" class="form-control" id="hectarage-farm-size" name="hectarage_farm_size" placeholder="Enter farm size in hectares">
            </div>
            <div class="form-group">
              <label for="street">Street</label>
              <input type="text" class="form-control" id="street" name="street" placeholder="Enter street">
            </div>
            <div class="form-group">
              <label for="barangay">Barangay</label>
              <input type="text" class="form-control" id="barangay" name="barangay" placeholder="Enter barangay">
            </div>
            <div class="form-group">
              <label for="city">City</label>
              <input type="text" class="form-control" id="city" name="city" placeholder="Enter city">
            </div>
            <div class="form-group">
              <label for="province">Province</label>
              <input type="text" class="form-control" id="province" name="province" placeholder="Enter province">
            </div>


            <label>Farm Size and Address 2</label>
            <div class="form-group">
              <label for="hectarage-farm-size2">Hectarage (Farm Size)</label>
              <input type="number" class="form-control" id="hectarage-farm-size2" name="hectarage_farm_size2" placeholder="Enter farm size in hectares">
            </div>
            <div class="form-group">
              <label for="street2">Street</label>
              <input type="text" class="form-control" id="street2" name="street2" placeholder="Enter street">
            </div>
            <div class="form-group">
              <label for="barangay2">Barangay</label>
              <input type="text" class="form-control" id="barangay2" name="barangay2" placeholder="Enter barangay">
            </div>
            <div class="form-group">
              <label for="city2">City</label>
              <input type="text" class="form-control" id="city2" name="city2" placeholder="Enter city">
            </div>
            <div class="form-group">
              <label for="province2">Province</label>
              <input type="text" class="form-control" id="province2" name="province2" placeholder="Enter province">
            </div>

            <label>Farm Size and Address 3</label>
            <div class="form-group">
              <label for="hectarage-farm-size3">Hectarage (Farm Size)</label>
              <input type="number" class="form-control" id="hectarage-farm-size3" name="hectarage_farm_size3" placeholder="Enter farm size in hectares">
            </div>
            <div class="form-group">
              <label for="street3">Street</label>
              <input type="text" class="form-control" id="street3" name="street3" placeholder="Enter street">
            </div>
            <div class="form-group">
              <label for="barangay3">Barangay</label>
              <input type="text" class="form-control" id="barangay3" name="barangay3" placeholder="Enter barangay">
            </div>
            <div class="form-group">
              <label for="city3">City</label>
              <input type="text" class="form-control" id="city3" name="city3" placeholder="Enter city">
            </div>
            <div class="form-group">
              <label for="province3">Province</label>
              <input type="text" class="form-control" id="province3" name="province3" placeholder="Enter province">
            </div>

            <label>Crops Applied for PhilGap Certification</label>
            <div class="form-group">
              <label for="crop">Crop</label>
              <input type="text" class="form-control" id="crop" name="crop" placeholder="Enter crop">
            </div>
            <div class="form-group">
              <label for="variety">Variety</label>
              <input type="text" class="form-control" id="variety" name="variety" placeholder="Enter variety">
            </div>
            <div class="form-group">
              <label for="hectarage-crop">Hectarage (Crop)</label>
              <input type="number" class="form-control" id="hectarage-crop" name="hectarage_crop" placeholder="Enter crop size in hectares">
            </div>
            <div class="form-group">
              <label for="harvest">Harvest</label>
              <input type="text" class="form-control" id="harvest" name="harvest" placeholder="Enter harvest details">
            </div>
            <div class="form-group">
              <label for="purpose">Purpose</label>
              <input type="text" class="form-control" id="purpose" name="purpose" placeholder="Enter purpose">
            </div>

            <div class="form-group">
              <label>Required Documents</label><br>
              <input type="checkbox" name="required_documents[]" value="Farm or organization profile"> Farm or organization profile<br>
              <input type="checkbox" name="required_documents[]" value="Farm map"> Farm map<br>
              <input type="checkbox" name="required_documents[]" value="Farm layout"> Farm layout<br>
              <input type="checkbox" name="required_documents[]" value="Field operation Procedures"> Field operation Procedures<br>
              <input type="checkbox" name="required_documents[]" value="Production and Harvesting Records"> Production and Harvesting Records<br>
              <input type="checkbox" name="required_documents[]" value="List of Farm inputs(Annex B)"> List of Farm inputs(Annex B)<br>
              <input type="checkbox" name="required_documents[]" value="Certificate of Nutrient Soil Analysis"> Certificate of Nutrient Soil Analysis<br>
              <input type="checkbox" name="required_documents[]" value="Certificate of training on GAP conducted by ATI, BPI, LGU, DA RFO, SUCs or by ATI accredited service providers"> Certificate of training on GAP conducted by ATI, BPI, LGU, DA RFO, SUCs or by ATI accredited service providers<br>
              <input type="checkbox" name="required_documents[]" value="Certification of Registration and other permits e.g. RSBSA, SEC, DTI,CDA(as applicable)"> Certification of Registration and other permits e.g. RSBSA, SEC, DTI,CDA(as applicable)<br>
            </div>

            <div class="form-group">
              <label>Additional Documents</label><br>
              <input type="checkbox" name="additional_documents[]" value="Quality Management System/Internal Control System"> Quality Management System/Internal Control System<br>
              <input type="checkbox" name="additional_documents[]" value="Procedure for accreditation of farmers/growers"> Procedure for accreditation of farmers/growers<br>
              <input type="checkbox" name="additional_documents[]" value="Manual of Procedure for outgrowership scheme which 
will show that the group have 100% control of all 
registered or accredited growers (e.g. internal policies on 
accreditation of farmer/grower, sanctions, etc."> Manual of Procedure for outgrowership scheme which
              will show that the group have 100% control of all
              registered or accredited growers (e.g. internal policies on
              accreditation of farmer/grower, sanctions, etc.)<br>
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
  <!-- Include SweetAlert2 Library -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


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
        start_loader();

        if ($('.err-msg').length > 0)
          $('.err-msg').remove();

        $.ajax({
          url: _base_url_ + "classes/Master.php?f=farmer_register",
          method: "POST",
          data: $(this).serialize(),
          dataType: "json",
          error: err => {
            console.log(err);
            alert_toast("An error occurred", 'error');
            end_loader();
          },
          success: function(resp) {
            end_loader(); // End loader here to ensure it's called in all cases

            if (typeof resp === 'object' && resp.status === 'success') {
              Swal.fire({
                icon: 'success',
                title: 'Registration Successful',
                text: resp.msg,
                customClass: {
                  popup: 'custom-alert' // Add a custom class
                },
              }).then(() => {
                location.reload(); // Reload the page after closing the alert
              });
            } else if (resp.status === 'failed' && !!resp.msg) {
              var _err_el = $('<div>')
                .addClass("alert alert-danger err-msg")
                .text(resp.msg);
              $('[name="password"]').after(_err_el);
            } else {
              console.log(resp);
              alert_toast("An error occurred", 'error');
            }
          }
        });
      });
    });
  </script>
</body>

</html>