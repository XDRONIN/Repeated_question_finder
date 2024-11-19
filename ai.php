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
    <h1>Repeated questions:</h1>

    <div id="output"></div>
    <script type="importmap">
      {
        "imports": {
          "@google/generative-ai": "https://esm.run/@google/generative-ai"
        }
      }
    </script>

    <script>
       
        // Fetch the PHP-encoded JSON array and parse it into a JavaScript array
        const pdfTextArray = <?php echo $jsonEncodedText; ?>;

        // Display the content in the output div
        const output=document.getElementById("output");
        output.innerText="loading..."

        // Optionally, you can manipulate the JavaScript array as needed
        console.log(pdfTextArray); // For debugging purposes
        </script>
<script type="module">
import { GoogleGenerativeAI } from "@google/generative-ai";
// Fetch your API_KEY
const API_KEY = "AIzaSyCSseZKn37jCeXrzbGIFhn-OzDpfkGaVrU";

// Access your API key (see "Set up your API key" above)
const genAI = new GoogleGenerativeAI(API_KEY);

// ...

// The Gemini 1.5 models are versatile and work with most use cases
const model = genAI.getGenerativeModel({ model: "gemini-1.5-flash" });
run();

async function run() {
  
  // The Gemini 1.5 models are versatile and work with both text-only and multimodal prompts
  const model = genAI.getGenerativeModel({ model: "gemini-1.5-flash" });
  
  
 
  const prompt = `${pdfTextArray} contains some questions from different question pappers. Go through the the questions and tell me which questions appear repeatedly 
  with the repeated number.You can consider similar questions from the same topic as Repeated `;

  const result = await model.generateContent(prompt);
  const response = await result.response;
  const text = response.text();

  const newText = addLineBreaks(text);
 // console.log(text);
 output.innerHTML=newText;
  
  
}



function addLineBreaks(text) {
  // Replace '#' and '*' with empty string
  const processedText = text.replace(/[#*]/g, "");

  // Split the processed text into an array of lines
  const lines = processedText.split(/\n/);
  let formattedText = "";

  // Iterate through each line
  lines.forEach((line) => {
    // Add line break before '#' or '*'
    formattedText += line.replace(/(#|\*)/g, "<br>$1") + "<br>";
  });

  return formattedText;
}
run();
//console.log("shibfdhisfd");

    </script>
 
    
</body>
</html>
