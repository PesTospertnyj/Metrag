<?php
//include ("content/about.php");
/*
		<div class="distribution">
			<div class="content">
				<form action="" method="post" >
					<ul>
						<li class="text-distribution"><p>подписаться на расылку</p></li>
						<li><input type="text" name="mail"  placeholder="введите e-mail"></li>
						<li><input type="submit" name="" value="отправить"></li>
					</ul>
				</form>
			</div>
		</div>
	</div>
	<footer>
		<div class="header-menu">
			<div class="content">
				<div class="logo">
					<a href="index.php" title="">
						<img src="<?php echo TEMPLATE ?>images/logo.png" alt="" width=250>
					</a>
				</div>
							<!-- main navigation -->
        <nav id="topnav" role="navigation">
          <div class="menu-toggle">Menu</div>
	          <ul class="srt-menu" id="menu-main-navigation">
              <li class="current"><a href="#">ГЛАВНАЯ</a></li>
              <li><a href="#">О КОМПАНИИ</a>
                  <ul>
                      <li class="current"><a href="#">История компании</a></li>
                      <li>
                          <a href="#">Отзывы клиентов</a>
                          <!--<ul>
                              <li><a href="#">1</a></li>
                              <li><a href="#">2 длинное</a></li>
                              <li><a href="#">3</a></li>
                              <li><a href="#">4</a></li>
                              <li><a href="#">5</a></li>
                          </ul>-->
						  <li><a href="#">Лучшие риэлторы</a></li>
                      <li><a href="#">Карьера</a></li>
					  <li><a href="#">Вакансии</a></li>
                  </ul>
              </li>
              <li>
                  <a href="#">УСЛУГИ</a>
                  <ul>
                      <li><a href="#">Купить</a></li>
                      <li><a href="#">Владельцам</a></li>
					  <li><a href="#">Арендовать</a></li>
                      <li><a href="#">Оценка недвижимости</a></li>
                  </ul>
              </li>
              <li>
                  <a href="#">НОВОСТИ</a>
				  <ul>
				      <li><a href="#">Новости</a></li>
                      <li><a href="#">Статьи</a></li>
					  <li><a href="#">Аналитика</a></li>
				  </ul>
              </li>
			  <li>
                  <a href="#">КОНТАКТЫ</a>
              </li>
			  <li>
                  <a href="#">ОБРАТНЫЙ ЗВОНОК</a>
              </li>
          </ul>
		</nav>


				<div class="button">
					<a href="" title=""><img src="<?php echo TEMPLATE ?>images/bottom.png"  alt=""></a>
				</div>
			</div>
		</div>
		*/
		?>
        </div></div>
		
		<?= $this->render('_contactLine', ['phones' => $phones, 'email' => $email]); ?>
	</footer>





