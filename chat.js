"use strict";

$(document).ready(function () {
    var chatInterval = 250; //refresh interval in ms
    var $userName = $("#userName");
    var $chatOutput = $("#chatOutput");
    var $chatInput = $("#chatInput");
    var $chatSend = $("#chatSend");
    var $ipaddr = $("#ipaddy");
    var $inputbox = $("#chatInput");


	var rerun = false;
	var ranalready = false;
	var newmessage = false;

    function sendMessage() {
        var userNameString = $userName.val();
        var chatInputString = $chatInput.val();
        var ipad = $ipaddr.val();

        $.get("./write.php", {
            username: userNameString,
            text: chatInputString,
            ip: ipad        
        });

       // $userName.val("");
        retrieveMessages();
    }
	
	function scrollToBottom(){
		$('#chatOutput').animate({ scrollTop:           $('#chatOutput').prop('scrollHeight')}, 1000);
		var ranalready = true;
	}
	
function newMessage(){
	var userNameString = $userName.val();
        var chatInputString = $chatInput.val();
        var ipad = $ipaddr.val();
        $.get("./read.php", {username: userNameString, ip: ipad} , function (data) {
            $chatOutput.html(data); //Paste content into chat output
                if (data){
                        var fullLength = data.length;
                        var lastAliceChat = data.lastIndexOf("Alice");
                        var distance = fullLength - lastAliceChat;
                //      console.log(distance); // data is a string. parse string for id = alice or class = alice text. then refresh
                        if (distance <= 100){
                                newmessage = true;
                        }
                }
        //console.log(rerun);
        });
        return rerun;
}

    function retrieveMessages() {
	var userNameString = $userName.val();
        var chatInputString = $chatInput.val();
        var ipad = $ipaddr.val();
        $.get("./read.php", {username: userNameString, ip: ipad} , function (data) {
            $chatOutput.html(data); //Paste content into chat output
		if (data){
			var fullLength = data.length;
			var lastAliceChat = data.lastIndexOf("Alice");
			var distance = fullLength - lastAliceChat;
		//	console.log(distance); // data is a string. parse string for id = alice or class = alice text. then refresh
			if (distance <= 100){
				rerun = true;
			}
		}
	//console.log(rerun);
        });
	return rerun;
    }

	$('#chatInput').keypress(function(e){
		if(e.keyCode==13){
			//console.log("enter key pressed");
			$chatSend.click();
		}	
	});

    $chatSend.click(function () {
        sendMessage();
	scrollToBottom();
	$inputbox.val("");
    });

    setInterval(function () {
	 if (!$userName.val() ){
        $inputbox.attr("disabled", true);
    }else if ($userName.val()){
        $inputbox.attr("disabled", false);
    }
	//console.log($userName.val());
        var rerun = retrieveMessages();
	//console.log(rerun);
	/*
	if (rerun == true && ranalready == false){
		scrollToBottom();
		//var rerun = false;
	} */
//	var rerun = false;
//	$('#chatOutput').animate({ scrollTop:           $('#chatOutput').prop('scrollHeight')}, 1000);
//	console.log(rerun);
//console.log(ranalready);
    }, chatInterval);
});
