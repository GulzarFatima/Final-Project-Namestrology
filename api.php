<?php

// response type to JSON
header( "Content-Type: application/json");

// reads raw POST body and decodes it from JSON into a PHP array
$input = json_decode(file_get_contents("php://input"), true);

// pull name entered remove spaces 
$name = trim($input["name"] ?? "");

// feedback prompt if no name was added / validation
if ($name === "") {
  echo json_encode(["result" => "Please enter a name."]);
  exit;
}

// set up OpenAI API key
$apiKey = "";

// ==== calling the API ==== //

// request body
$data = [

  "model" => "gpt-4",

  "temperature" => 0.9, // higher creativity for funnier responses

  "max_tokens" => 100, // limit tokens to ensure a concise response

  //"messages" => [
   // ["role" => "user", "content" => "Give a short, funny, sarcastic, and mysterious meaning for the name 
   // \"$name\". 
  //  Mention the actual meaning of the name, but add a sarcastic, witty twist to it. keep it light and under 2 lines."
   // ]
  //]

  "messages" => [
    ["role" => "user", "content" => "Give a short, funny, sarcastic, and mysterious meaning for the name 
    \"$name\". 
    Mention the real meaning of the name, but add a playful twist. Keep it simple, light, slightly evil, and under 2 lines. Only in roman Urdu without translation."
    ]
  ]

];

// ==== send request with curl ==== //

$ch = curl_init("https://api.openai.com/v1/chat/completions");

// return response as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// post request
curl_setopt($ch, CURLOPT_POST, true);

// add content type and authorization headers
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  "Content-Type: application/json",
  "Authorization: Bearer $apiKey"
]);

// attach the data to the request
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// execute request and close connection
$response = curl_exec($ch);
curl_close($ch);

// decode the response
$responseData = json_decode($response, true);

//get generated message text from OpenAI response
$meaning = $responseData["choices"][0]["message"]["content"] ?? "No meaning found.";

// return the meaning as a JSON response
echo json_encode(["result" => trim($meaning)]);
