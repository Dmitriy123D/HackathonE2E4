<!DOCTYPE html>
<?php

	if (!empty($_COOKIE['sid'])) {
		// check session id in cookies
		session_id($_COOKIE['sid']);
	}

	session_start();
	require_once 'classes/Auth.class.php';

	require_once ("config.php");
	require_once ("preheader.php");
?>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>Your page title here :)</title>
  <meta name="description" content="">
  <meta name="author" content="">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

  <!-- CSS –––––––––––––––––––––––––––––––––––– -->
	
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/skeleton.css">
  <link rel="stylesheet" href="css/menu.css">
  <link rel="stylesheet" href="css/elop.css">
  
  <link rel="icon" type="image/png" href="images/favicon.png">


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="./js/ajax-form.js"></script>
      <script src="https://api-maps.yandex.ru/2.1/?lang=ru-RU&amp;apikey=cf839dd8-9d68-4c97-84ad-d8135946d7cd" type="text/javascript"></script>
    <script src="https://yandex.st/jquery/2.2.3/jquery.min.js" type="text/javascript"></script>
    <script>
	ymaps.ready(init);

function init () {
    var myMap = new ymaps.Map('map', {
            center: [47.236727, 39.764285],
            zoom: 13
        }, {
            searchControlProvider: 'yandex#search'
        }),
        objectManager = new ymaps.ObjectManager({
            // Чтобы метки начали кластеризоваться, выставляем опцию.
            clusterize: true,
            // ObjectManager принимает те же опции, что и кластеризатор.
            gridSize: 32,
            clusterDisableClickZoom: true
        });

    // Чтобы задать опции одиночным объектам и кластерам,
    // обратимся к дочерним коллекциям ObjectManager.
    objectManager.objects.options.set('preset', 'islands#greenDotIcon');
    objectManager.clusters.options.set('preset', 'islands#greenClusterIcons');
    myMap.geoObjects.add(objectManager);

    $.ajax({
		    url: "test/json.php"
    }).done(function(data) {
        objectManager.add(data);
    });

}
	</script>
	<style>
        html, body, #map {
            width: 100%; height: 500px; padding: 0; margin: 0;
        }
        a {
            color: #04b; /* Цвет ссылки */
            text-decoration: none; /* Убираем подчеркивание у ссылок */
        }
        a:visited {
            color: #04b; /* Цвет посещённой ссылки */
        }
        a:hover {
            color: #f50000; /* Цвет ссылки при наведении на нее курсора мыши */
        }
    </style>
</head>

<body>


      <?php if (Auth\User::isAuthorized()): ?>
    
      <h1>Your are welcome!</h1>

      <form class="ajax" method="post" action="./ajax.php">
          <input type="hidden" name="act" value="logout">
          <div class="form-actions">
              <button class="btn btn-large btn-primary" type="submit">Logout</button>
          </div>
      </form>
	  
		<div class="container">
			<div class="row">
				<div class="eleven columns">
					<?php require_once ("header.php");?>
				</div>
			</div>

			<div class="row">
				<div class="eleven columns">


					<div id="map"></div>

				</div>
			</div>
			<div class="row">
				<div class="eleven columns">
				<?php require_once ("footer.php");?>
				</div>
			</div>
		</div>

      <?php else: ?>

		  <form class="form-signin ajax" method="post" action="./ajax.php">
			<div class="main-error alert alert-error hide"></div>

			<h2 class="form-signin-heading">Please sign in</h2>
			<input name="username" type="text" class="input-block-level" placeholder="Username" autofocus>
			<input name="password" type="password" class="input-block-level" placeholder="Password">
			<label class="checkbox">
			  <input name="remember-me" type="checkbox" value="remember-me" checked> Remember me
			</label>
			<input type="hidden" name="act" value="login">
			<button class="btn btn-large btn-primary" type="submit">Sign in</button>
		
			<div class="alert alert-info" style="margin-top:15px;">
				<p>Not have an account? <a href="/register.php">Register it.</a>
			</div>
		  </form>

      <?php endif; ?>


</body>
</html>