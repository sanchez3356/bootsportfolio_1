<?php
// Connect to the MySQL database
require __DIR__ . '/../src/bootstrap.php';
// Include TCPDF library
require_once('../vendors/library/tcpdf.php');

if(is_post_request()) {
// Check if the button is clicked
if (isset($_POST['generate_pdf'])) {
    // Call the function to generate the CV PDF
    generateCVPDF();
}
}
?>
