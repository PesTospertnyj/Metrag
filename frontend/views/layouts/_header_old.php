<?
	use yii\helpers\Html;
	use yii\helpers\Url;
?>

<header>

		<?= $this->render('_contactLine', ['phones' => $phones, 'email' => $email]); ?>
		
		<div class="header-menu">
			<div class="content">
				<div class="logo">
					
					<a href="<?= Url::base(true);?>" title="">
						
						<img src="<?= Url::base(true);?>/images/logo.png" alt="" width=250>
					</a>
				</div>

						<!-- main navigation -->
        <nav id="topnav" role="navigation">
          
	          <ul class="srt-menu" id="menu-main-navigation">
              <?php
              if (!isset ($_GET['art'])) echo "<li class=\"current\"><a href=\"".Url::base(true)."\">".Yii::t('app', 'HOME')."</a></li>";
              else echo "<li><a href=\"".Url::base(true)."\">".Yii::t('app', 'HOME')."</a></li>";

              if (isset ($_GET['art']))
              {
	              if (($_GET['art']==1) OR ($_GET['art']==2) OR ($_GET['art']==3) OR ($_GET['art']==4) OR ($_GET['art']==5)) echo "<li class=\"current\"><a href=\"#\">".Yii::t('app', 'ABOUT')."</a>";
	              else echo "<li><a href=\"#\">".Yii::t('app', 'ABOUT')."</a>";
	          }
	          else echo "<li><a href=\"#\">".Yii::t('app', 'ABOUT')."</a>";
               echo "<ul>";
	               echo "<li><a href=\"".Url::base(true)."/site/company-history\">".Yii::t('app', 'Company history')."</a></li>";
	               echo "<li><a href=\"".Url::base(true)."/site/review\">".Yii::t('app', 'Client review')."</a></li>";
	               echo "<li><a href=\"".Url::base(true)."/site/best-rieltors\">".Yii::t('app', 'Best rieltors')."</a></li>";
	               echo "<li><a href=\"".Url::base(true)."/site/carier\">".Yii::t('app', 'Carier')."</a></li>";
	               echo "<li><a href=\"".Url::base(true)."/site/vacancy\">".Yii::t('app', 'Vacancy')."</a></li>";
               echo "</ul>";
              echo "</li>";

              if (isset ($_GET['art']))
              {
	              if (($_GET['art']==10) OR ($_GET['art']==11) OR ($_GET['art']==12) OR ($_GET['art']==13) OR ($_GET['art']==14))
	              echo "<li class=\"current\"><a href=\"#\">".Yii::t('app', 'SERVICES')."</a>";
	              else echo "<li><a href=\"#\">".Yii::t('app', 'SERVICES')."</a>";
	          }
	          else echo "<li><a href=\"#\">".Yii::t('app', 'SERVICES')."</a>";
               echo "<ul>";
	               echo "<li><a href=\"".Url::base(true)."/site/buy\">".Yii::t('app', 'Buy')."</a></li>";
	               echo "<li><a href=\"\">".Yii::t('app', 'Ownership')."</a></li>";
	               echo "<li><a href=\"\">".Yii::t('app', 'Rent')."</a></li>";
	               echo "<li><a href=\"\">".Yii::t('app', 'Property valuation')."</a></li>";
               echo "</ul>";
              echo "</li>";

              if (isset ($_GET['art']))
              {
	              if (($_GET['art']==6) OR ($_GET['art']==7) OR ($_GET['art']==8)) echo "<li class=\"current\"><a href=\"#\">".Yii::t('app', 'NEWS')."</a>";
	              else echo "<li><a href=\"#\">".Yii::t('app', 'NEWS')."</a>";
	          }
	          else echo "<li><a href=\"#\">".Yii::t('app', 'NEWS')."</a>";
	          echo "<ul>";
	               echo "<li><a href=\"".Url::base(true)."/site/news\">".Yii::t('app', 'News')."</a></li>";
	               echo "<li><a href=\"".Url::base(true)."/site/article\">".Yii::t('app', 'Article')."</a></li>";
	               echo "<li><a href=\"".Url::base(true)."/#\">Аналитика</a></li>";
               echo "</ul>";
              echo "</li>";

              if (isset ($_GET['art']))
              {
	              if ($_GET['art']==9) echo "<li class=\"current\"><a href=\"".Url::base(true)."/site/contacts\">".Yii::t('app', 'CONTACTS')."</a></li>";
	              else echo "<li><a href=\"".Url::base(true)."/site/contacts\">".Yii::t('app', 'CONTACTS')."</a></li>";
	          }
	          else echo "<li><a href=\"".Url::base(true)."/site/contacts\">".Yii::t('app', 'CONTACTS')."</a></li>";
              ?>
			  <li>
                  <a href="#">ОБРАТНЫЙ ЗВОНОК</a>
              </li>

          </ul>
		</nav>
		<!-- end main navigation -->


                <?php
                /*
				<div class="button">
					<a href="" title=""><img src="<?php echo TEMPLATE ?>images/bottom.png"  alt=""></a>
				</div>
				*/
				?>
			</div>
		</div>
	</header>