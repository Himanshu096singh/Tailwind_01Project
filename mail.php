<?php
$allowedDomain = "http://localhost:5173";
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

$origin = $_SERVER['HTTP_ORIGIN'];
if (isset($_SERVER['HTTP_ORIGIN'])) {
  if ($origin === $allowedDomain) {
    header('Access-Control-Allow-Origin: ' . $origin);
    header('Content-Type: application/json');
      
      $errors = [];
      $errorMessage = '';
      $successMessage = '';
      $origin = $_SERVER['HTTP_ORIGIN'];

      if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $message =  isset($_POST["message"]) ? $_POST("message") : "-";
        
        $body = "
          <h3>
            Landing Page Information:
          </h3>
          <hr/>
          <br/>
          <table>
            <tr>
              <th>Name  : </th><td> ".  $name ." </td>
            </tr>
            <tr>
              <th>Email : </th><td> ".  $email ." </td>
            </tr>
            <tr>
              <th>Phone : </th><td> ".  $phone ." </td>
            </tr> 
            <tr>
            
                <th>Message : </th><td> ".  $message ." </td>
            </tr>
          </table>
        ";
      // Your existing code...

        if (!empty($errors)) {
            $allErrors = join('<br/>', $errors);
            $errorMessage = "<p style='color: red;'>error: {$allErrors}</p>";
          } else {
            // Your existing code...
            $mail = new PHPMailer(true);
            // Configure the PHPMailer instance
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'shubhameglobal20@gmail.com';
            $mail->Password = 'gapzbocvfekmtnsz';
            $mail->SMTPSecure = "ssl"; // Updated
            $mail->Port = 465;

            // Debugging (optional)
            // $mail->SMTPDebug = 2; // 2 or higher for debugging information
            // $mail->Debugoutput = function ($str, $level) {
            //     echo "debug level $level; message: $str";
            // };

            // Your existing code...

            try {
              $mail->setFrom('shubhameglobal20@gmail.com', "test");
              $mail->addAddress("himanshu01eglobalsoft@gmail.com");
              $mail->Subject = "subject";
              $mail->isHTML(true);
              $mail->Body =  $body;
              $mail->send();
              echo json_encode(['message' => 'Form submitted successfully']);
            } catch (Exception $e) {
              echo json_encode(['error' => 'Error sending email']);
            }
        }
      } else {
        // Invalid request method
        echo json_encode(['error' => 'Invalid request method']);
      }
    }  else {
        // Request from an unauthorized domain
        http_response_code(403);
        echo json_encode(['error' => 'Forbidden']);
    }
} else {
    // No Origin header set
    http_response_code(400);
    echo json_encode(['error' => 'Bad Request']);
}
?>