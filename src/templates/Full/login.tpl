
[not-group=5]
<div class="user-dropdown" id="userMenu">

	<button id="loginButton" class="custom-dropdown-button dropdown-toggle">
		<span class="over text-black">{login}</span>
		<span title="Новые сообщения - {new-pm}" class="pm_num badge bg-secondary ">{new-pm}</span>

	</button>
	<div class="user-dropdown-content" id="userContent">
		<div class="user-dropdown-header">
			{*<div class="avatar">
				<a href="{profile-link}">
					<span class="cover" style="background-image: url({foto});">{login}</span>
				</a>
			</div>*}
			[admin-link]
			<div class="ms-3">
				<a href="{admin-link}" target="_blank" class="dropdown-item">Админпанель</a>
			</div>
			[/admin-link]
		</div>
		<hr class="dropdown-divider">
		<div class="user-dropdown-footer">
			<a class=" btn btn-primary w-100"  href="{logout-link}">Выход</a>

		</div>
	</div>
</div>


<script>
	document.addEventListener("DOMContentLoaded", function () {
		var loginButton = document.getElementById("loginButton");
		var userContent = document.getElementById("userContent");


		loginButton.addEventListener("click", function (e) {
			e.preventDefault();
			e.stopPropagation();
			userContent.classList.toggle("show");
		});

		document.addEventListener("click", function (e) {
			if (!e.target.closest("#userMenu")) {
				userContent.classList.remove("show");
			}
		});
	});



</script>
[/not-group]

<!-- Гости (группа 5) -->
[group=5]
<div class="custom-dropdown" id="loginMenu">
	<button id="loginButton" class="custom-dropdown-button dropdown-toggle">
		Войти
	</button>
	<div class="custom-dropdown-content" id="loginContent">
		<form class="p-3" method="post">
			<div class="mb-3">
				<input type="text" class="form-control" id="login_name" placeholder="Логин" name="login_name">
			</div>
			<div class="mb-3">
				<input type="password" class="form-control" id="login_password" placeholder="Пароль" name="login_password">
			</div>
			<button type="submit" class="btn btn-primary w-100">Войти</button>
			<input type="hidden" name="login" value="submit">
			<div class="d-flex justify-content-center">
				<a href="{registration-link}" class="text-black mx-2"><b>Регистрация</b></a>
				<a href="{lostpassword-link}" class="text-muted mx-2">Забыли пароль?</a>
			</div>
		</form>
	</div>
</div>
<script>
	document.addEventListener("DOMContentLoaded", function () {
		var loginButton = document.getElementById("loginButton");
		var loginContent = document.getElementById("loginContent");

		// Открытие меню по клику на кнопку
		loginButton.addEventListener("click", function (e) {
			e.preventDefault();
			e.stopPropagation();
			loginContent.classList.toggle("show");
		});

		// Закрытие меню при клике вне его
		document.addEventListener("click", function (e) {
			if (!e.target.closest("#loginMenu")) {
				loginContent.classList.remove("show");
			}
		});
	});

</script>

[/group]

