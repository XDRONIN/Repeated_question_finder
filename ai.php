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
<style>
  body {
      background-color: rgb(226, 226, 226);
    }
    .spinner {
  display: none;
  margin-top: 15%;
  width: 70.4px;
  height: 70.4px;
  --clr: #00bfa6;
  --clr-alpha: rgba(159, 247, 218, 0.1);
  animation: spinner 1.6s infinite ease;
  transform-style: preserve-3d;
}

.spinner > div {
  background-color: var(--clr-alpha);
  height: 100%;
  position: absolute;
  width: 100%;
  border: 3.5px solid var(--clr);
}

.spinner div:nth-of-type(1) {
  transform: translateZ(-35.2px) rotateY(180deg);
}

.spinner div:nth-of-type(2) {
  transform: rotateY(-270deg) translateX(50%);
  transform-origin: top right;
}

.spinner div:nth-of-type(3) {
  transform: rotateY(270deg) translateX(-50%);
  transform-origin: center left;
}

.spinner div:nth-of-type(4) {
  transform: rotateX(90deg) translateY(-50%);
  transform-origin: top center;
}

.spinner div:nth-of-type(5) {
  transform: rotateX(-90deg) translateY(50%);
  transform-origin: bottom center;
}

.spinner div:nth-of-type(6) {
  transform: translateZ(35.2px);
}

@keyframes spinner {
  0% {
    transform: rotate(45deg) rotateX(-25deg) rotateY(25deg);
  }

  50% {
    transform: rotate(45deg) rotateX(-385deg) rotateY(25deg);
  }

  100% {
    transform: rotate(45deg) rotateX(-385deg) rotateY(385deg);
  }
}

</style>
<body>
    <h1>Repeated questions:</h1>

    <div id="output" style="font-size: 20px;"> </div>
    <center>
      <div class="spinner">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
      </div>
    </center>
    <script type="importmap">
      {
        "imports": {
          "@google/generative-ai": "https://esm.run/@google/generative-ai"
        }
      }
    </script>

    <script>
      function showLoading() {
  spinner.style.display = "flex";
}
function hideLoading() {
  spinner.style.display = "none";
}

       
        // Fetch the PHP-encoded JSON array and parse it into a JavaScript array
        const pdfTextArray = <?php echo $jsonEncodedText; ?>;

        // Display the content in the output div
        const output=document.getElementById("output");
        const spinner = document.querySelector(".spinner");
        output.innerText="loading..."
        showLoading();

        // Optionally, you can manipulate the JavaScript array as needed
        console.log(pdfTextArray); // For debugging purposes
        </script>
<script type="module">
import { GoogleGenerativeAI } from "@google/generative-ai";
// Fetch your API_KEY
const API_KEY = "AIzaSyDFYfajRlRbqC_PXm3f-8A2MCpbElYyScY";

// Access your API key (see "Set up your API key" above)
const genAI = new GoogleGenerativeAI(API_KEY);

// ...

// The Gemini 1.5 models are versatile and work with most use cases
const model = genAI.getGenerativeModel({ model: "gemini-1.5-flash-8b" });
run();

async function run() {
  
  // The Gemini 1.5 models are versatile and work with both text-only and multimodal prompts
  const model = genAI.getGenerativeModel({ model: "gemini-1.5-flash-8b" });
  
  
 
  const prompt = `${pdfTextArray} contains some questions from different question pappers. Go through the the questions and tell me which questions appear repeatedly 
  with the repeated number.You can consider similar questions from the same topic as Repeated `;

  const result = await model.generateContent(prompt);
  const response = await result.response;
  const text = response.text();

  const newText = addLineBreaks(text);
 // console.log(text);
 hideLoading();
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
