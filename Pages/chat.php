<?php 
	session_start();
    if(!isset($_SESSION['user'])){
        header("location:index.php");
    }
?>

<html>
<head>
	<title>Messenger</title>
	<style type="text/css">
	html {
		height: 100%;
	}
	body {
		margin: 0px;
		padding: 0px;
		height: 100%;
		font-family: Helvetica, Arial, Sans-serif;
		font-size: 14px;
	}	
	.msg-container {
		width: 100%;
		height: 100%;
	}
	.header {
		width: 100%;
		height: 30px;
		border-bottom: 1px solid #CCC;
		text-align: center;
		padding: 15px 0px 5px;
		font-size: 20px;
		font-weight: normal;
	}
	.msg-area {
		height: calc(100% - 102px);
		width: 100%;
		background:
        -moz-radial-gradient(0% 100%, ellipse cover, rgba(104,128,138,.4) 10%,rgba(138,114,76,0) 40%),
        -moz-linear-gradient(top,  rgba(57,173,219,.25) 0%, rgba(42,60,87,.4) 100%), 
        -moz-linear-gradient(-45deg,  #27ae60 0%, #092756 100%);
	background: 
        -webkit-radial-gradient(0% 100%, ellipse cover, rgba(104,128,138,.4) 10%,rgba(138,114,76,0) 40%), 
        -webkit-linear-gradient(top,  rgba(57,173,219,.25) 0%,rgba(42,60,87,.4) 100%), 
        -webkit-linear-gradient(-45deg,  #27ae60 0%,#092756 100%);
	background: 
        -o-radial-gradient(0% 100%, ellipse cover, rgba(104,128,138,.4) 10%,rgba(138,114,76,0) 40%), 
        -o-linear-gradient(top,  rgba(57,173,219,.25) 0%,rgba(42,60,87,.4) 100%), 
        -o-linear-gradient(-45deg,  #27ae60 0%,#092756 100%);
	background: 
        -ms-radial-gradient(0% 100%, ellipse cover, rgba(104,128,138,.4) 10%,rgba(138,114,76,0) 40%), 
        -ms-linear-gradient(top,  rgba(57,173,219,.25) 0%,rgba(42,60,87,.4) 100%), 
        -ms-linear-gradient(-45deg,  #27ae60 0%,#092756 100%);
	background: 
        -webkit-radial-gradient(0% 100%, ellipse cover, rgba(104,128,138,.4) 10%,rgba(138,114,76,0) 40%), 
        linear-gradient(to bottom,  rgba(57,173,219,.25) 0%,rgba(42,60,87,.4) 100%), 
        linear-gradient(135deg,  #27ae60 0%,#092756 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#3E1D6D', endColorstr='#092756',GradientType=1 );
	overflow-y: scroll;
}
	.msginput {
		padding: 5px;
		margin: 10px;
		font-size: 14px;
		width: calc(100% - 20px);
		outline: none;
        color: #000;
		border: 0px solid #000;
        padding: 8px;
	}
	.bottom {
		width: 100%;
		height: 50px;
		position: fixed;
		bottom: 0px;
		border-top: 0px;
	}
        
	h1 {
		padding: 0px;
		margin: 20px 0px 0px 0px;
		text-align: center;
		font-weight: normal;
	}
	button {
		border: none;
		color: #FFF;
		font-size: 16px;
		margin: 0px auto;
		width: 150px;
	}
	.buttonp {
		width: 150px;
		margin: 0px auto;
	}

	.msg {
		margin: 10px 10px;
		background-color: #ecf0f1;
		max-width: calc(45% - 20px);
		color: #000;
		padding: 10px;
		font-size: 14px;
		border-radius: 5px !important;
        box-shadow: 0 1px 2px rgba(0,0,0,0.4);
	}
	.msgfrom {
		background-color: #2980b9;
		color: #FFF;
		margin: 10px 10px 3px 55%;
		border-radius: 5px !important;
        box-shadow: 0 1px 2px rgba(0,0,0,0.4);
	}
	
	.msgsentby {
		color: #fff;
		font-size: 12px;
		margin: 2px 0px 0px 10px;
	}
	.msgsentbyfrom {
		float: right;
		margin-right: 12px;
	}
	.logout {
		float:right !important;
		margin-right: 10px;
		color:#000;
		text-decoration:none;
		font-size:14px;
	}
	</style>
</head>
<body onload="update()">

<div class="msg-container">
	<div class="header">Messenger [ <?php echo $_SESSION['user']; ?> ]<a href="logout.php" class="logout">Logout</a></div>
	<div class="msg-area" id="msg-area"></div>
	<div class="bottom"><input type="text" name="msginput" class="msginput" id="msginput" onkeydown="if (event.keyCode == 13) sendmsg()" value="" placeholder="Enter your message here ... (Press enter to send message)"></div>
</div>
<script type="text/javascript">

var msginput = document.getElementById("msginput");
var msgarea = document.getElementById("msg-area");

function escapehtml(text) {
  return text
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;")
}

function update() {
	var xmlhttp=new XMLHttpRequest();
	var username = "<?php echo $_SESSION['user']; ?>";
	var output = "";
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				var response = xmlhttp.responseText.split("\n");
				var rl = response.length;
				var item = "";
				
				for(var i=0; i<rl; i++){
					item = response[i].split("\\");
					if(item[1] != undefined){
						if(item[0] == username){
							output += "<div class=\"msgc\" style=\"margin-bottom: 30px;\"> <div class=\"msg msgfrom\">" + item[1] + "</div> <div class=\"msgsentby msgsentbyfrom\">Sent by " + item[0] +" </div> </div>";
						} else {
							output += "<div class=\"msgc\"> <div class=\"msg\">" + item[1] + "</div><div class=\"msgsentby\">Sent by " + item[0] +"</div> </div>";
						}
					}
				}
				// loop through the data
				msgarea.innerHTML = output;
				msgarea.scrollTop = msgarea.scrollHeight;
			}
		}
	      xmlhttp.open("GET","getMessage.php?username=" + username,true);
	      xmlhttp.send();
}

function sendmsg() {
	var time = new Date();
	var message = msginput.value;
	if (message != "") {
		var username = "<?php echo $_SESSION['user']; ?>";

		var xmlhttp=new XMLHttpRequest();

		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				message = escapehtml(message)
				msgarea.innerHTML += "<div class=\"msgc\" style=\"margin-bottom: 30px;\"> <div class=\"msg msgfrom\">" + message + "</div><div class=\"msgsentby msgsentbyfrom\">Sent by "  + username +"</div> </div>";
				msginput.value = "";
			}
		}
	      xmlhttp.open("GET","sendMessage.php?username=" + username + "&message=" + message,true);
	      xmlhttp.send();
  	}
}

setInterval(function(){ update(); }, 500);
    
</script>
</body>
</html>