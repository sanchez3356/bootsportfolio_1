<?php
// Connect to the MySQL database
require __DIR__ . '/../src/bootstrap.php';

$errors = [];
$inputs = [];

if (is_post_request()) {
  if (isset($_POST['newsletter'])) {
    // sanitize & validate user inputs
    [$inputs, $errors] = filter($_POST, [
      'newsletter' => 'email | required | email | unique: newsletter, news_email',
      'newsDate' => 'string | required'
    ]);

    // if validation error
    if ($errors) {
      $error = [
        'inputs' => $inputs,
        'errors' => $errors,
      ];
      header('Content-Type: application/json');
      echo json_encode($error);
      exit;
    }
    $return = [
      "message" => null
    ];
    echo save_news($inputs['newsletter'], $inputs['newsDate']) ? json_encode($return["message"] = "Email sent successfully") : json_encode($return["message"] = "Email sending failed");
    exit;
  }
  // $_POST["date"] = (!$_POST["date"]) ? $_POST["date"] : is_date();
  $values = [
    'name' => 'string | required | between: 3, 25',
    'email' => 'email | required | email',
    'message' => 'string | required | min: 50',
    'date' => 'string | required '
  ];

  // custom messages
  $messages = [
    'message' => [
      'required' => 'There must be a message to be sent to Samson',
    ],
    'subject' => [
      'required' => 'You need to specify the subject of the message to Samson'
    ]
  ];

  [$inputs, $errors] = filter($_POST, $values, $messages);

  if ($errors) {
    $error = [
      'inputs' => $inputs,
      'errors' => $errors,
    ];
    echo json_encode($error);
    exit;
  }
  $return = [
    "message" => null
  ];
  echo save_message($inputs['name'], $inputs['email'], $inputs['message'], $inputs['date']) ? json_encode($return["message"] = "message saved") : json_encode($return["message"] = "message was not saved");
  exit;
}

?>