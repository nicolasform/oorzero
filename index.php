<?php

	/*
	MIT License

	Copyright (c) 2021 Nicolas Form https://www.feelouttheform.net/

	Permission is hereby granted, free of charge, to any person obtaining a copy
	of this software and associated documentation files (the "Software"), to deal
	in the Software without restriction, including without limitation the rights
	to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
	copies of the Software, and to permit persons to whom the Software is
	furnished to do so, subject to the following conditions:

	The above copyright notice and this permission notice shall be included in all
	copies or substantial portions of the Software.

	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
	LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
	SOFTWARE.
	*/

	// Count the visitors
	
	$host_name = '';
	$database = '';
	$user_name = '';
	$password = '';

	$dbConnection = new mysqli($host_name, $user_name, $password, $database)
		or die('{ "error":"1", "message": "Impossible to connect : ' . $dbConnection->connect_error . '" }');

	$stmt = $dbConnection->prepare("INSERT INTO `oorzero_visitors`(`date`) VALUES (CURRENT_TIMESTAMP)")
		or die('Failed PREPARE request : ' . $dbConnection->error);
	$stmt->execute()
		or die('Failed EXECUTE request : ' . $stmt->error);
	$stmt->close();
	
?><!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>Letter O or digit 0 - Copy/paste your text to know</title>
	       
	<style>
		body {
			font-family: "Source Code Pro";
			text-align: center;
			background-color: #ffdb97;
			color: #ffffffcf;
		}
		#container {
			background-color: #574a3c;
			border-radius: 30px;
			padding: 20px;
			max-width: 700px;
			margin: auto;
		}
		#mainInput {
			width: 90%;
			height: 50px;
			padding: 10px;
		}
		#result {
			width: 90%;
			padding: 10px;
			margin: auto;
			text-align: left;
			white-space: break-spaces;
			font-weight: bold;
		}
		.letter {
			color: #16c6bd;
		}
		.digit {
			color: #ff7d7d;
		}
		#footer {
			color: #444444;
			font-size: 10px;
			margin: auto;
			padding: 10px;
			max-width: 700px;
		}
	</style>
</head>

<body>
	
	<div id="container">
		
		<h1>Letter <span class='letter'>O</span> or digit <span class='digit'>0</span></h1>
		
		<div>
			<p>Copy/paste your text below to know where are letters <span class='letter'>O</span> and digits <span class='digit'>0</span>.</p>
			<p><textarea type="text" id="mainInput" onkeyup="checkLetters()"></textarea></p>
			<pre id="result"></pre>
		</div>
		
	</div>
	
	<p id="footer">Made by <a href="https://www.feelouttheform.net/" target="_blank">Nic<span class='letter'>o</span>las F<span class='letter'>o</span>rm</a> under the <a href="https://mit-license.org/" target="_blank">MIT license</a> (<a href="https://github.com/nicolasform/oorzero/" target="_blank">see s<span class='letter'>o</span>urce here</a>). This website d<span class='letter'>o</span>es n<span class='letter'>o</span>t put any tracker <span class='letter'>o</span>r c<span class='letter'>o</span><span class='letter'>o</span>kie in y<span class='letter'>o</span>ur br<span class='letter'>o</span>wser and d<span class='letter'>o</span>es n<span class='letter'>o</span>t c<span class='letter'>o</span>llect what y<span class='letter'>o</span>u put in the text b<span class='letter'>o</span>x.</p>
	
	<script>
				
		// Inpired by: https://stackoverflow.com/questions/18749591/encode-html-entities-in-javascript
		function htmlentities(rawStr,marker0) {
			if(rawStr) {
				return rawStr.toString().replace(/[\u00A0-\u9999<>\&]/g, function(i) {
					return ('&#'+i.charCodeAt(0)+';').replace(/0/gi,marker0);
				});
			} else {
				return rawStr;
			}
		}
		
		function randomString() {
			let characters = "ABCDEFGHIJKLMNPQRSTUVWXYZ";  // Do not includes the letter O!!!
			let str = "";
			for (let i=0; i<10; i++) {
				str += characters.charAt(Math.floor(Math.random() * characters.length));
			}
			return str;
		}
		
		function checkLetters() {
			
			// Get the input value
			let v = document.getElementById("mainInput").value;
			
			// Generate the marker for digit 0 inside html entities (should not be contained in the original text)
			let marker0;
			do {
				marker0 = randomString();
			} while(v.includes(marker0));
			
			// Parse and display the string
			document.getElementById("result").innerHTML = htmlentities(v,marker0)
				.replace(/(o)/gi,"<span class='letter'>$1</span>")
				.replace(/0/gi,"<span class='digit'>0</span>")
				.replace(new RegExp(marker0,'g'),"0")
			;
			
		}
		
		// Run once in case the input is pre-filled
		checkLetters();
		
	</script>
	
</body>

</html>
