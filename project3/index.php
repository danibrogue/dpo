<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">

  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
  <script src="ajax.js"></script>
  <link rel="stylesheet" type="text/css" href="styles/style.css">

</head>

<body>
  <header class="header">
    <wrapper>
      <p class="header-text">Форма обратной связи</p>
    </wrapper>
  </header>
	<main>
		<wrapper>
			<div class="feedback-form">
				<form method="post" id="ajax_form" action="" class="form">
					<input type="text" id="surname" name="surname" placeholder="Фамилия" /><br>
					<input type="text" id="name" name="name" placeholder="Имя" /><br>
					<input type="text" id="patronymic" name="patronymic" placeholder="Отчество" /><br>
					<input type="text" id="phone" name="phone" placeholder="Номер" /><br>
					<input type="text" id="email" name="email" placeholder="E-mail" /><br>
					<input type="button" id="btn" value="Send" />
				</form>
			</div>
		</wrapper>
		<br>
		<wrapper>
			<div id="result_form"></div>
		</wrapper> 
	</main>
</body>
</html>