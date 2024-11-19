import { GoogleGenerativeAI } from "@google/generative-ai";

// Fetch your API_KEY
const API_KEY = "AIzaSyDYtZAFk7bBNAnQ3v3w78PnrfPcV_3nPGc";

// Access your API key (see "Set up your API key" above)
const genAI = new GoogleGenerativeAI(API_KEY);

// ...

// The Gemini 1.5 models are versatile and work with most use cases
const model = genAI.getGenerativeModel({ model: "gemini-1.5-flash" });

async function run() {
  showLoading();
  // The Gemini 1.5 models are versatile and work with both text-only and multimodal prompts
  const model = genAI.getGenerativeModel({ model: "gemini-1.5-flash" });
  resultText.innerHTML = "";
  topic = document.getElementById("topic").value;
  textBook = document.getElementById("testbook").value;
  author = document.getElementById("author").value;
  const prompt = `Explain ${topic}

    Guidelines for the Explanation:
    Introduction:
    
    Begin with a brief introduction to the topic.
    Mention the significance of the topic in a broader context.
    Reference Textbook:
    
    Refer exclusively to the specified textbook: ${textBook} by ${author}.
    Ensure that all information is accurately derived from the given textbook.
    Detailed Explanation:
    
    Break down the topic into clear, logical sections.
    Use simple language that can be understood by everyone.
    Define any technical terms in an easy-to-understand manner.
    Examples:
    
    Provide examples that are relatable and easy to understand.
    Use analogies or scenarios that a child might encounter in everyday life.
    Conclusion:
    
    Summarize the main points covered.
    Highlight why understanding this topic is important.`;

  const result = await model.generateContent(prompt);
  const response = await result.response;
  const text = response.text();

  const newText = addLineBreaks(text);
  hideLoading();
  resultText.innerHTML = `${newText}`;
}
const resultText = document.querySelector(".output");
let topic;
let author;
let textBook;
const spinner = document.querySelector(".spinner");

const genButton = document.querySelector("#butt");
genButton.addEventListener("click", () => {
  run();
});
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
function showLoading() {
  spinner.style.display = "flex";
}
function hideLoading() {
  spinner.style.display = "none";
}
