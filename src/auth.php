<?php
function is_date(): string
{
    // Set the default time zone to Nairobi
    date_default_timezone_set("Africa/Nairobi");

    // Get the current time in the local time zone
    $local_time = time();

    // Create a DateTime object for the current time in the local time zone
    $local_datetime = new DateTime("@$local_time");

    // Get the time zone offset for the local time zone
    $local_tz_offset = $local_datetime->getOffset();

    // Create a DateTimeZone object for the local time zone
    $local_tz = new DateTimeZone(date_default_timezone_get());

    // Create a DateTime object for the current time in the Nairobi time zone
    $nairobi_datetime = new DateTime("@$local_time");
    $nairobi_datetime->setTimezone(new DateTimeZone("Africa/Nairobi"));

    // Format the Nairobi date and time string
    $nairobi_date_str = $nairobi_datetime->format("Y-m-d h:i:s");

    // Get the time zone offset for the Nairobi time zone
    $nairobi_tz_offset = $nairobi_datetime->getOffset();

    // Calculate the time difference between the local and Nairobi time zones
    $tz_diff = $nairobi_tz_offset - $local_tz_offset;

    // Add the time difference to the local date and time to get the Nairobi date and time
    $nairobi_time = $local_time + $tz_diff;

    // Create a DateTime object for the Nairobi date and time
    $nairobi_datetime = new DateTime("@$nairobi_time");

    // Format the Nairobi date and time string
    $nairobi_date_str = $nairobi_datetime->format("Y-m-d h:i:s");

    // Return the Nairobi date and time string
    return $nairobi_date_str;
}
function save_message(string $name, string $email, string $message, string $date): bool
{
    $sql = "INSERT INTO messages (message_id, usernames, message, sent, read, email)
   VALUES (null, :name, :message, :date, :read, :email)";

    $read = 0;
    $statement = db()->prepare($sql);

    $statement->bindValue(':name', $name, PDO::PARAM_STR);
    $statement->bindValue(':email', $email, PDO::PARAM_STR);
    $statement->bindValue(':message', $message, PDO::PARAM_STR);
    $statement->bindValue(':read', $read, PDO::PARAM_STR);
    $statement->bindValue(':date', $date, PDO::PARAM_STR);
    return $statement->execute();
}
function save_news(string $email, string $date): bool
{
    $sql = "INSERT INTO newsletter (news_id, news_email, news_date)
   VALUES (null, :email, :date)";

    $statement = db()->prepare($sql);

    $statement->bindValue(':email', $email, PDO::PARAM_STR);
    $statement->bindValue(':date', $date, PDO::PARAM_STR);
    return $statement->execute();
}
function delete_record(int $id, string $table): bool
{
    $column_name = '';
    switch ($table) {
        case 'education':
            $column_name = 'ed_id';
            break;
        case 'experience':
            $column_name = 'exp_id';
            break;
        case 'interests':
            $column_name = 'int_id';
            break;
        case 'language':
            $column_name = 'lang_id';
            break;
        case 'messages':
            $column_name = 'message_id';
            break;
        case 'newsletter':
            $column_name = 'news_id';
            break;
        case 'portfolio':
            $column_name = 'port_id';
            break;
        case 'preferences':
            $column_name = 'pref_id';
            break;
        case 'reference':
            $column_name = 'ref_id';
            break;
        case 'reviews':
            $column_name = 'review_id';
            break;
        case 'services':
            $column_name = 'service_id';
            break;
        case 'skills':
            $column_name = 'skill_id';
            break;
        case 'title':
            $column_name = 'title_id';
            break;
        default:
            // handle error here
            break;
    }
    $sql = "DELETE FROM $table WHERE  $column_name = :id";
    $statement = db()->prepare($sql);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);

    return $statement->execute();
}

function select_count(string $table)
{
    $sql = "SELECT COUNT(*) FROM $table";

    $statement = db()->prepare($sql);
    $statement->execute();
    $num = $statement->fetch(PDO::FETCH_ASSOC);
    return $num['COUNT(*)'];
}
/**
 * get profile function
 * @return array
 */

function get_profile_data(): array
{
    $sql = "SELECT first_name, mid_name, last_name, about_me, address, logo, photo, avatar, update_date, g.gender, t.title, m.status, c.city, y.county, s.website, s.email, s.phone, s.whatsapp, s.facebook, s.twitter, s.youtube, s.telegram, s.instagram, s.linkedin FROM profile p INNER JOIN social s on s.email = p.email INNER JOIN city c on c.city_id = p.city INNER JOIN county y on y.county_id = p.county INNER JOIN gender g on g.gender_id = p.gender INNER JOIN marital m on m.marital_id = p.marital INNER JOIN title t on t.title_id = p.title";
    $statement = db()->prepare($sql);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
/**
 * get skills function
 * @return array
 */

function get_skills_data(): array
{
    $sql = "SELECT * FROM skills";
    $statement = db()->prepare($sql);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
/**
 * get interests function
 * @return array
 */

function get_interests_data(): array
{
    $sql = "SELECT * FROM interests";
    $statement = db()->prepare($sql);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
/**
 * get experience function
 * @return array
 */

function get_experience_data(): array
{
    $sql = "SELECT * FROM experience";
    $statement = db()->prepare($sql);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
/**
 * get reference function
 * @return array
 */

function get_reference_data(): array
{
    $sql = "SELECT * FROM reference";
    $statement = db()->prepare($sql);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
/**
 * get language function
 * @return array
 */

function get_language_data(): array
{
    $sql = "SELECT * FROM language";
    $statement = db()->prepare($sql);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
/**
 * get education function
 * @return array
 */

function get_education_data(): array
{
    $sql = "SELECT * FROM education";
    $statement = db()->prepare($sql);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
/**
 * get portfolio function
 * @return array
 */

function get_portfolio_data(): array
{
    $sql = "SELECT * FROM portfolio p INNER JOIN project j on j.project_id = p.project";
    $statement = db()->prepare($sql);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
/**
 * get services function
 * @return array
 */

function get_services_data(): array
{
    $sql = "SELECT * FROM services";
    $statement = db()->prepare($sql);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
/**
 * get reviews function
 * @return array
 */

function get_reviews_data(): array
{
    $sql = "SELECT * FROM reviews";
    $statement = db()->prepare($sql);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
/**
 * get preference function
 * @return array
 */
function get_preferences_data(): array
{
    $sql = "SELECT * FROM preferences";
    $statement = db()->prepare($sql);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

// Function to generate the CV PDF
function generateCVPDF()
{
    // Create a new TCPDF instance
    $pdf = new TCPDF("P", "mm", "A4");

    // Remove default header and footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    // Add a new page
    $pdf->AddPage();


    // Set the CV content
    $profile_data = get_profile_data();
    $pdf->SetFont('times', 'B', 28);
    $pdf->Cell(0, 8, strtoupper($profile_data[0]['first_name'] . ' ' . $profile_data[0]['mid_name']), 0, 1, 'C');

    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 8, 'Phone: ' . $profile_data[0]['phone'], 0, 1, 'C');
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->SetTextColor(0, 128, 0); // Green color
    $pdf->Cell(0, 8, 'Email: ' . $profile_data[0]['email'], 0, 1, 'C');
    $pdf->SetTextColor(0, 0, 0); // Reset color

    // Draw line under email
    $pdf->SetLineWidth(0.3); // Set line width to 0.2 units (thinner line)
    $pdf->SetDrawColor(192, 192, 192); // Set color to grey
    $pdf->Line($pdf->GetPageWidth() * 0.1, $pdf->GetY(), $pdf->GetPageWidth() * 0.9, $pdf->GetY()); // Draw line centered with 80% width of the document
    $pdf->Ln(2); // Add extra space after the line

    // About me line
    $pdf->SetFont('helvetica', '', 11);
    $pdf->SetLeftMargin(10);
    $pdf->SetRightMargin(10);
    $indent = '    ';
    $width = 0.95 * $pdf->GetPageWidth();
    $pdf->MultiCell($width, 20, $indent . $profile_data[0]['about_me'], 0, 'L');

    // Fetch MySQL data from the experience table
    $experience_data = get_experience_data(); // Replace with your actual MySQL data retrieval logic for the experience table

    // Add work experience information
    $pdf->SetFont('times', 'B', 16);
    $pdf->Cell(0, 10, 'EXPERIENCE', 0, 1, 'L');

    foreach ($experience_data as $experience) {
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(5, 6, '•', 0, 0, 'L', false);
        $pdf->Cell(30, 6, 'From: ' . $experience['from'] . ' - To: ' . $experience['to'], 0, 1, 'L');
        $pdf->Cell(5, 6, '•', 0, 0, 'L', false);
        $pdf->SetTextColor(0, 128, 0); // Green color
        $experienceText = strtoupper($experience['experience']) . ' , ';
        $experienceWidth = $pdf->GetStringWidth($experienceText);
        $pdf->Cell($experienceWidth, 6, $experienceText, 0, 0, 'L');
        $pdf->SetTextColor(0, 0, 0); // Set color back to black
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 6, strtoupper($experience['company']), 0, 1, 'L');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->SetLeftMargin(10);
        $pdf->SetRightMargin(10);
        $width = 0.95 * $pdf->GetPageWidth();
        $pdf->Cell(5, 6, '•', 0, 0, 'L', false);
        $pdf->MultiCell($width, 6, $experience['role1'], 0, 'L');
        // $pdf->Cell(0, 6, $experience['role1'], 0, 1, 'L');
        $pdf->Ln(3); // Add extra space after the line
        // Add other experience information fields similarly...
    }
    // Fetch MySQL data from the education table
    $education_data = get_education_data(); // Replace with your actual MySQL data retrieval logic for the education table

    // Add education information
    $pdf->SetFont('times', 'B', 16);
    $pdf->Cell(0, 10, 'EDUCATION', 0, 1, 'L');

    foreach ($education_data as $education) {

        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(30, 6, 'From: ' . $education['from'] . ' - To: ' . $education['to'], 0, 1, 'L');
        $pdf->SetTextColor(0, 128, 0); // Green color
        $pdf->Cell(0, 6, strtoupper($education['qualification']), 0, 1, 'L');
        $pdf->SetTextColor(0, 0, 0); // Reset color
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(15, 6, 'School:', 0, 0, 'L');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 6, $education['school'], 0, 1, 'L');
        $pdf->Ln(3); // Add extra space after the line
        // Add other education information fields similarly...
    }

    // Fetch MySQL data from the skills table
    $skill_data = get_skills_data(); // Replace with your actual MySQL data retrieval logic for the skills table
    // Add skills information
    $pdf->SetFont('times', 'B', 16);
    $pdf->Cell(0, 10, 'SKILLS', 0, 1, 'L');

    foreach ($skill_data as $skill) {
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(5, 5, '•', 0, 0, 'L', false);
        $pdf->Cell(0, 5, $skill['skill'], 0, 1, 'L');
    }

    // Fetch MySQL data from the activities table
    $interests_data = get_interests_data(); // Replace with your actual MySQL data retrieval logic for the skills table
    // Add skills information
    $pdf->SetFont('times', 'B', 16);
    $pdf->Cell(0, 10, 'ACTIVITIES', 0, 1, 'L');

    foreach ($interests_data as $interests) {
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(5, 5, '•', 0, 0, 'L', false);
        $pdf->Cell(0, 5, $interests['interest'], 0, 1, 'L');
    }

    // Fetch MySQL data from the references table
    $references_data = get_reference_data(); // Replace with your actual MySQL data retrieval logic for the references table
    // Add skills information
    $pdf->SetFont('times', 'B', 16);
    $pdf->Cell(0, 10, 'REFERENCES', 0, 1, 'L');

    foreach ($references_data as $references) {
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 6, $references['names'], 0, 1, 'L');
        $pdf->SetFont('helvetica', '', 9);
        $pdf->Cell(0, 6, 'Phone: ' . $references['phone'], 0, 1, 'L');
        $pdf->Ln(2); // Add extra space after the line

    }

    // Output the generated PDF as a downloadable file
    $pdf->Output('cv.pdf', 'D');
}

function convertToRoman($number)
{
    if ($number < 1 || $number > 3999) {
        return "Number out of range";
    }

    $romanNumerals = [
        "M" => 1000,
        "CM" => 900,
        "D" => 500,
        "CD" => 400,
        "C" => 100,
        "XC" => 90,
        "L" => 50,
        "XL" => 40,
        "X" => 10,
        "IX" => 9,
        "V" => 5,
        "IV" => 4,
        "I" => 1
    ];

    $result = "";

    foreach ($romanNumerals as $roman => $value) {
        while ($number >= $value) {
            $result .= $roman;
            $number -= $value;
        }
    }

    return $result;
}

?>