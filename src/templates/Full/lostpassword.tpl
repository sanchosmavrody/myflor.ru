{*<div class="page_form__inner">
	<h1 class="title h1">Восстановление пароля</h1>
	<div class="page_form__form">
		<ul class="ui-form">
			<li class="form-group">
				<label for="lostname">Логин или E-mail</label>
				<input type="text" name="lostname" id="lostname" class="wide" required>
			</li>
		[sec_code]
			<li class="form-group">
				<div class="c-captcha">
					{code}
					<input placeholder="Повторите код" title="Введите код указанный на картинке" type="text" name="sec_code" id="sec_code" required>
				</div>
			</li>
		[/sec_code]
		[recaptcha]
			<li>{recaptcha}</li>
		[/recaptcha]
		</ul>
		<div class="form_submit">
			<button class="btn" name="submit" type="submit">Восстановить</button>
		</div>
	</div>
</div>*}
<section class="section-contact section-bg-img pad-top-250" data-bg="images/bg/bg-34.jpg" style="background-image: url(&quot;images/bg/bg-34.jpg&quot;);">
	<div class="container">
		<div class="row align-items-center">
			<!-- col -->
			<div class="col-lg-6 align-self-center">
				<!-- Contact Form -->
				<div class="contact-form-4 register-form bg-theme">
					<!-- Form -->
					<div class="contact-form-wrap">
						<h2 class="title">Восстановление пароля</h2>
						<!-- form inputs -->
						<form id="contact-form" class="contact-form" action="inc/function.php" enctype="multipart/form-data">
							<div class="row">
								<div class="col-md-12">
									<!-- form group -->
									<div class="form-group">
										<input id="lostname" class="form-control wide" name="name" placeholder="Логин или E-mail" data-bv-field="name" type="text" required/>

									</div>
								</div>

								<div class="col-md-12">
									<div class="form_submit">
										<button class="btn btn-default mt-0 theme-btn" name="submit" type="submit">Восстановить</button>
									</div>
								</div>
							</div>
							<span class="clearfix"></span>

						</form>

						<!-- form inputs end -->
						<p id="contact-status-msg" class="hide"></p>
					</div>
					<!-- Form End-->
				</div>
			</div>
			<!-- .col -->
			<!-- Col -->
			<div class="col-lg-6 register " data-animation="fadeInRight">
				<div class="title-wrap margin-bottom-20">
					<div class="section-title">
						<div class="section-title register-title">
							<h2 class="title mb-0 theme-color">elephant-flowers.ru
							</h2>
						</div>
					</div>
					<div class="register-contant pad-top-5 typo-white">
						<p class="margin-bottom-30">
							<br>В случае возникновения проблем с регистрацией, обратитесь к <a href="/index.php?do=feedback">Администратору.</a>
						</p>

					</div>
				</div>

			</div>

			<!-- Col -->
		</div>
	</div>
</section>
