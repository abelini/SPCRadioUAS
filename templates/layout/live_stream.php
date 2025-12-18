<!DOCTYPE html>
<html>
	<head>
		<title>Chat online</title>
		<meta charset="UTF-8">
		<script>
		
			document.addEventListener("DOMContentLoaded", function(event) {
				var xhttp = new XMLHttpRequest();
				xhttp.open("post", "<?= $this->Url->build(['action' => 'getComments'])?>", true);
				xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xhttp.setRequestHeader("X-CSRF-Token", "<?= $this->request->getAttribute('csrfToken')?>");
				xhttp.send("n=10");
				xhttp.onreadystatechange = function(){
					if (xhttp.readyState == 4 && xhttp.status == 200) {
						document.getElementById('messages').innerHTML = xhttp.responseText;
					}
				};
			});
		
			var xhttp = new XMLHttpRequest();
			setInterval(function(){
				xhttp.open("post", "<?= $this->Url->build(['action' => 'getComments'])?>", true);
				xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xhttp.setRequestHeader("X-CSRF-Token", "<?= $this->request->getAttribute('csrfToken')?>");
				xhttp.send("n=10");
				xhttp.onreadystatechange = function(){
					if (xhttp.readyState == 4 && xhttp.status == 200) {
						document.getElementById('messages').innerHTML = xhttp.responseText;
					}
				};
			}, 60000);

			String.prototype.capitalize = function() {
				return this.charAt(0).toUpperCase() + this.slice(1);
			}
		</script>
		<style>
			body{font-family:"Droid Sans",Arial,"sans-serif";font-size:40px;background:url(<?= $this->Url->image('livestream_bg.jpeg')?>) top left/100% 100% no-repeat fixed;} .time::before{content:"[";}.time::after{content:"] ";} .name{font-weight:bold;} .name::after{content:"\00a0";}
			ul{list-style-type:none;} li{display:block;padding:32px;} li:nth-child(odd) {background:#efefef;} li:nth-child(even){background:#fefefe;}
			
			#messages {width:75%;background:#fff;}
		</style>
	</head>
	<body>
		<?= $this->Html->image('https://radio.uas.edu.mx/wp-content/images/icons/FBLive.png', ['style' => 'float:right;margin:32px;width:180px;'])?>
		
		<?= $this->fetch('content') ?>

		<div id="messages">
			
		</div>
	</body>
</html>