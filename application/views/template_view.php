<!-- Главная страница -->
<!DOCTYPE html>
<html lang="ru">
	<head>
		<title>Блогер</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
		<link rel="stylesheet" href="/css/style.css" />
		<link rel="icon" type="image/png" href="/images/favicon-32x32.png">
		<script src="/js/script.js"></script>
		<meta charset="UTF-8">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300&family=Raleway&display=swap" rel="stylesheet">
	</head>
	<body>
		<div class="wrapper">
			<nav class="menu-bar">
				<div class="menu-bar__container container">
					<ul class="menu-bar__list">
						<li class="logo"><a href="/main"><img src="/images/bloger-logo.jpg" width="40" height="40" alt="logo"> <span>Блогер</span></a></li>
						<li class="search">
							<div class="search__container">
								<!-- TODO: РАЗМЕРЫ СТРОКИ ПОИСКА В REM-->
								<form method="get">
									<div class="search__box">
										<input type="text" name="search-request" class="search__input" placeholder="Поиск статьи">
										<input type="submit" name="submit" value="" class="search__button">
									</div>
								</form>
							</div>
						</li>
						<li class="user">
							<?php include 'application/views/'.$login_data[0]; ?>
						</li>
					</ul>
				</div>
			</nav>
			<div class="content">
				<div class="container content-container">
					<?php include 'application/views/'.$content_view; ?>
				</div>
			</div>
			<footer class="footer">
				<div class='container'>
					<div class="footer__row">
						<div class="footer__text">Bloger 2022, All Rights Reserved</div>
					</div>
				</div>
			</footer>
		</div>
	</body>
</html>