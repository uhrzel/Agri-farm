<?php
require_once('../../config.php');
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT * FROM users WHERE id = '{$_GET['id']}'");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = $v;
        }
    } else {
        $_settings->set_flashdata('error', 'Farmer ID provided is Unknown');
        redirect('admin/?page=farmer');
    }
} else {
    $_settings->set_flashdata('error', 'No Farmer ID Provided.');
    redirect('admin/?page=farmer');
}
?>
<?php
// Define the base URL manually or fetch it from settings
$base_url = 'http://localhost/agri-farm/';  // Modify this according to your actual project path

// Construct the full avatar URL
$avatar_url = $base_url . $avatar;

?>

<div class="container-fluid">
    <h4>Farmer Details</h4>

    <div class="text-center mb-3">
        <!-- Display the full avatar image -->
        <img src="<?php echo htmlspecialchars($avatar_url); ?>" alt="Farmer Image" class="img-fluid rounded-circle" style="max-height: 200px; max-width: 200px;">
    </div>

    <dl>
        <dt class="muted">First Name</dt>
        <dd class="pl-4"><?php echo htmlspecialchars($firstname); ?></dd>

        <dt class="muted">Last Name</dt>
        <dd class="pl-4"><?php echo htmlspecialchars($lastname); ?></dd>
    </dl>

    <div class="text-right">
        <button class="btn btn-dark btn-flat btn-sm" type="button" data-dismiss="modal">
            <i class="fa fa-times"></i> Close
        </button>
    </div>
</div>


<style>
    #uni_modal .modal-footer {
        display: none !important;
    }
</style>