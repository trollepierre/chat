<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
sec_session_start();
?>

<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="title" content="Le T'Chat"/>
	<title>Le T'Chat</title>
	<meta name="description" content="Le T'Chat">
	<meta name="author" content="Pierre Trollé">
	<link rel="icon" href="../../favicon.ico">

	<link rel="stylesheet" type="text/css" href="css/main.css"/>
	<link rel="stylesheet" type="text/css" href="css/fenetreDeChat.css"/>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
</head>
<body>
	
	<h1>Le T'Chat</h1>
	<?php if (login_check($mysqli) == false) : ?>
        <p>
            <span class="error">Vous n’avez pas les autorisations nécessaires pour accéder à cette page.</span> Please <a href="login.php">login</a>.
        </p>
     <?php else : ?>
        <p id="bienvenue">Bienvenue <?php echo htmlentities($_SESSION['username']); ?> !</p> 

	<?php include("fenetreDeChat.html"); ?>
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> 
	<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	
	<script>
	$(function(){
		afficheConversation();
		
		$('#sent').click(function(){
			var message = $('#btn-input').val();
			alert("Votre message a bien été envoyé !");
			$.post('chat.php',{
				'nom':"<?php echo $_SESSION['username']; ?>",
				'message':message
			},
			function(){
				afficheConversation();
				$('#btn-input').val('');
				$('#message').focus();
			});
		});

		function afficheConversation(){
			//Vider #conversation
			$("#conversation").empty();

			$.getJSON('conversation.json', function(donnees){
				$.each(donnees, function(key,val){
					if (val.nom !=="<?php echo $_SESSION['username']; ?>") {
						$('#conversation').append('<li class="left clearfix"><span class="chat-img pull-left"><img src="http://placehold.it/50/55C1E7/fff&text=U" alt="User Avatar" class="img-circle" /></span><div class="chat-body clearfix"><div class="header"><strong class="primary-font">'+val.nom +'</strong> <small class="pull-right text-muted"><span class="glyphicon glyphicon-time"></span>' + val.when +'</small></div><p>' + val.message + '</p></div></li>');
					}else{
						$('#conversation').append('<li class="right clearfix"><span class="chat-img pull-right"><img src="http://placehold.it/50/FA6F57/fff&text=ME" alt="User Avatar" class="img-circle" /></span><div class="chat-body clearfix"><div class="header"><small class=" text-muted"><span class="glyphicon glyphicon-time"></span>'+val.when+'</small><strong class="pull-right primary-font">'+val.nom +'</strong></div><p>' + val.message + '</p></div></li>');
					}
				});
			});
			$('#message').focus();
		}
		setInterval(afficheConversation, 40000);
	});
	</script>
   <?php endif; ?>
</body>
</html>