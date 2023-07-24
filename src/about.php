<?php
// Connect to the MySQL database
require __DIR__ . '/../src/bootstrap.php';

// create array of objects from query results
$data = array();

$contact = 'contact';
$rows = get_profile_data();
foreach ($rows as $row) {
  $obj = new stdClass();
  $obj->names = htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['last_name']);
  $obj->first = htmlspecialchars($row['first_name']);
  $obj->middle = htmlspecialchars($row['mid_name']);
  $obj->last = htmlspecialchars($row['last_name']);
  $obj->about = htmlspecialchars($row['about_me']);
  $obj->updated = htmlspecialchars($row['update_date']);
  $obj->gender = htmlspecialchars($row['gender']);
  $obj->marital = htmlspecialchars($row['status']);
  $obj->county = htmlspecialchars($row['county']);
  $obj->title = htmlspecialchars($row['title']);
  $obj->phone = $row['phone'];
  $obj->email = $row['email'];
  $obj->address = $row['address'];
  $obj->facebook = $row['facebook'];
  $obj->twitter = $row['twitter'];
  $obj->instagram = $row['instagram'];
  $obj->youtube = $row['youtube'];
  $obj->telegram = $row['telegram'];
  $obj->whatsapp = $row['whatsapp'];
  $obj->linkedin = $row['linkedin'];
  $obj->website = $row['website'];
  $obj->logo = $row['logo'];
  $obj->photo = $row['photo'];
  $obj->avatar = $row['avatar'];
  $data[] = $obj;
}

$skill = 'skill';
$rows1 = get_skills_data();
foreach ($rows1 as $row) {
  $obj = new stdClass();
  $obj->skill = "<li class=\"row my-4 w-100 flex-nowrap text-nowrap align-items-center justify-content-start\"><div class=\"col-6 d-block\">" . htmlspecialchars($row['skill']) . "</div><div class=\"progress bg-light mw-100 col-6\">
  <div class=\"progress-bar bg-warning\" role=\"progressbar\" style=\"width: " . htmlspecialchars($row['skill_level']) . "%\" aria-valuenow=\"" . htmlspecialchars($row['skill_level']) . "\" aria-valuemin=\"0\" aria-valuemax=\"100\"></div></div></li>";
  $data[] = $obj;
}

$language = 'language';
$rows2 = get_language_data();
foreach ($rows2 as $row) {
  $obj = new stdClass();
  $obj->language = "<li class=\"d-flex justify-content-start align-items-center my-4 gap-3 gap-md-5 gap-lg-5 w-100\"><span>" . htmlspecialchars($row['language']) . "</span><div class=\"progress bg-light w-100\">
  <div class=\"progress-bar bg-warning\" role=\"progressbar\" style=\"width: " . htmlspecialchars($row['lang_level']) . "%\" aria-valuenow=\"" . htmlspecialchars($row['lang_level']) . "\" aria-valuemin=\"0\" aria-valuemax=\"100\"></div></div></li>";
  $data[] = $obj;
}

$interest = 'interest';
$rows3 = get_interests_data();
foreach ($rows3 as $row) {
  $obj = new stdClass();
  $obj->interest = "<div class=\"rounded-circle px-5 text-center\"><i class=\"" . htmlspecialchars($row['int_icon']) . " text-warning fs-1 mb-2\"></i><p>" . htmlspecialchars($row['interest']) . "</p></div>";
  $data[] = $obj;
}

$experience = 'experience';
$rows4 = get_experience_data();
foreach ($rows4 as $row) {
  $obj = new stdClass();
  $obj->experience = "<div class=\"p-2 my-2\"><b class=\"fs-4\">" . htmlspecialchars($row['experience']) . "</b><div class=\"d-block my-2\"><span class=\"badge bg-warning text-dark fw-bold me-3\">" . htmlspecialchars($row['from']) . " - " . htmlspecialchars($row['to']) . "</span><strong>" . htmlspecialchars($row['company']) . " </strong></div><p>" . htmlspecialchars($row['role1']) . "</p><p>" . htmlspecialchars($row['role2']) . "</p><p>" . htmlspecialchars($row['role3']) . "</p></div>";
  $data[] = $obj;
}

$education = 'education';
$rows5 = get_education_data();
foreach ($rows5 as $row) {
  $obj = new stdClass();
  $obj->education = "<div class=\"my-2 p-1\"><b>" . htmlspecialchars($row['qualification']) . "</b><p>" . htmlspecialchars($row['school']) . "</p><strong>" . htmlspecialchars($row['from']) . " - " . htmlspecialchars($row['to']) . "</strong></div>";
  $data[] = $obj;
}

$reference = 'reference';
$rows6 = get_reference_data();
foreach ($rows6 as $row) {
  $obj = new stdClass();
  $obj->reference = "<div class=\"col-12 col-md-6 col-lg-6 my-3\"><h4>" . htmlspecialchars($row['names']) . "</h4><p><span>job title :</span>" . htmlspecialchars($row['job']) . "</p><p><span>Phone :</span>" . htmlspecialchars($row['phone']) . "</span></p></div>";
  $data[] = $obj;
}
// encode data into JSON format
$json_data = json_encode($data);

// send JSON data back to client
header('Content-Type: application/json');
echo $json_data;
?>