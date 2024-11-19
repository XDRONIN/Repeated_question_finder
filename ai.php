<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pdfText'])) {
    // Retrieve the 'pdfText' data from the form
    $pdfText = $_POST['pdfText'];

    // Convert the PDF text data into a PHP array by splitting it at newlines (or however you want to structure it)
    // For this example, we'll split the text by double newlines for separate pages/sections
    $pdfTextArray = explode("\n\n", $pdfText);

    // Encode the PHP array into a JSON object
    $jsonEncodedText = json_encode($pdfTextArray);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Extracted PDF Text</title>
</head>
<body>
    <h1>Extracted PDF Text</h1>

    <div id="output"></div>

    <script>
        // Fetch the PHP-encoded JSON array and parse it into a JavaScript array
        const pdfTextArray = <?php echo $jsonEncodedText; ?>;

        // Display the content in the output div
        document.getElementById("output").innerHTML = "<pre>" + pdfTextArray.join("\n\n") + "</pre>";

        // Optionally, you can manipulate the JavaScript array as needed
        console.log(pdfTextArray); // For debugging purposes
    </script>
</body>
</html>
