<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chat With Alice</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css" type="text/css" media="screen"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous"/>
    <link rel="stylesheet" href="style.css" type="text/css" media="screen" />
</head>
<body>
<?php
	$ipadd = $_SERVER['REMOTE_ADDR'];
?>
<input type="hidden" name="ipaddy" id="ipaddy" value="<?php echo $ipadd; ?>">
    <div class="container">
        <header class="header">
            <h1>Chat with Alice</h1>
        </header>
        <main>
            <div class="userSettings">
                <label for="userName">Username:</label>
                <input id="userName" type="text" placeholder="Username" maxlength="64" >
            </div>
            <div class="chat">
                <div id="chatOutput"></div>
                <input id="chatInput" type="text" placeholder="Input Text here" maxlength="256">
                <button id="chatSend">Send</button>
            </div>
        </main>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="chat.js"></script>
</body>
</html>
