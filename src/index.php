<?php
// Connect to the MySQL database
require __DIR__ . '/../src/bootstrap.php';
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "port_db";

// // Create a connection
// $conn = new mysqli($servername, $username, $password, $dbname);

// // Check the connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// // Select data from a table
// $sql = "SELECT * FROM services";
// // Select data from a table
// $result = mysqli_query($conn, $sql);

// // Create an array to store the data
// $data = array();

// // Fetch data from the result set
// while ($row = mysqli_fetch_assoc($result)) {
//     $data[] = $row;
// }

// // Free the result set
// mysqli_free_result($result);

// // Convert the PHP array to JSON
// $jsonData = json_encode($data);

// // Specify the file path
// $filePath = "../vendors/file2.json";

// // Write the JSON data to the file
// file_put_contents($filePath, $jsonData);
// exit;

// create array of objects from query results
$number = 3999;
$data = array();

$contact = 'contact';
$social = 'social';
$rows = get_profile_data();
foreach ($rows as $row) {
  $obj = new stdClass();
  $obj->first = htmlspecialchars($row['first_name']);
  $obj->middle = htmlspecialchars($row['mid_name']);
  $obj->last = htmlspecialchars($row['last_name']);
  $obj->about = htmlspecialchars($row['about_me']);
  $obj->updated = htmlspecialchars($row['update_date']);
  $obj->gender = htmlspecialchars($row['gender']);
  $obj->marital = htmlspecialchars($row['status']);
  $obj->city = htmlspecialchars($row['city']);
  $obj->county = htmlspecialchars($row['county']);
  $obj->title = htmlspecialchars($row['title']);
  $obj->address = htmlspecialchars($row['address']);
  $obj->email = $row['email'];
  $obj->phone = $row['phone'];
  $obj->facebook = $row['facebook'];
  $obj->twitter = $row['twitter'];
  $obj->instagram = $row['instagram'];
  $obj->youtube = $row['youtube'];
  $obj->telegram = $row['telegram'];
  $obj->whatsapp = $row['whatsapp'];
  $obj->linkedin = $row['linkedin'];
  $obj->website = $row['website'];
  $obj->logo = $row['logo'];
  $obj->roman = convertToRoman($number);
  $obj->photo = $row['photo'];
  $obj->avatar = $row['avatar'];
  $obj->social = "<li class=\"icon facebook\"><span class=\"tooltip\">Facebook</span><span><i class=\"fab fa-facebook-f\"></i></span></li>
<li class=\"icon instagram\"><span class=\"tooltip\">Instagram</span><span><i class=\"fab fa-instagram\"></i></span></li>
<li class=\"icon youtube\"><span class=\"tooltip\">YouTube</span><span><i class=\"fab fa-youtube\"></i></span></li>
<li class=\"icon github\"><span class=\"tooltip\">Github</span><span><i class=\"fab fa-github\"></i></span></li>
<li class=\"icon twitter\"><span class=\"tooltip\">Twitter</span><span><i class=\"fab fa-twitter\"></i></span></li>";
  $data[] = $obj;
}

$service = 'service';
$rows2 = get_services_data();
foreach ($rows2 as $row) {
  $obj = new stdClass();
  $obj->service = "<div class=\"serve col back-yellow\"><i class=\"" . htmlspecialchars($row['icon']) . "\"></i><h3>" . htmlspecialchars($row['service']) . "</h3><p>" . htmlspecialchars($row['detail']) . "</p></div>";
  $data[] = $obj;
}

$rows4 = get_preferences_data();
foreach ($rows4 as $row) {
  $obj = new stdClass();
  $obj->preference = $row['[pref_id]'];
  $obj->primary = $row['primary_color'];
  $obj->variant = $row['primary_variant'];
  $obj->background = $row['background'];
  $obj->heading = $row['heading_font'];
  $obj->sub_font = $row['sub-heading_font'];
  $obj->body = $row['body_font'];
  $data[] = $obj;
}

$project = 'project';
$rows5 = get_portfolio_data();
foreach ($rows5 as $row) {
  $obj = new stdClass();
  $obj->project = "<div class=\"project " . htmlspecialchars($row['project']) . "\"><img src=\"" . htmlspecialchars($row['image']) . "\" alt=\"" . htmlspecialchars($row['project']) . " project image\" class=\"cover\"><div class=\"content back-orange\"><b>" . htmlspecialchars($row['project']) . "</b>
  <p class=\"limitedText\" data-limit=\"6\" data-id=\"" . htmlspecialchars($row['port_id']) . "\">" . htmlspecialchars($row['description']) . "</p></div></div>";
  $data[] = $obj;
}

$review = 'review';
$rows7 = get_reviews_data();
foreach ($rows7 as $row) {
  $obj = new stdClass();
  $obj->review = "<div><div class=\"slide\"><i class=\"fas fa-quote-left\"></i><blockquote>" . htmlspecialchars($row['review']) . "</blockquote><b>" . htmlspecialchars($row['names']) . "</b></div></div>";
  $data[] = $obj;
}

// encode data into JSON format
$json_data = json_encode($data);

// // write JSON data to a file
// $file_path = '../vendors/1st_data.json';
// $file_handle = fopen($file_path, 'w');
// fwrite($file_handle, $json_data);
// fclose($file_handle);

// encode data into JSON format
$json_data = json_encode($data);


// send JSON data back to client
header('Content-Type: application/json');
echo $json_data;

?>