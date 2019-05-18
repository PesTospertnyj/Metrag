<div class="top-header">
			<div class="content">
				<ul>
					<?php
						$phones_arr = explode(",", $phones);
					foreach($phones_arr as $phone)
					{
						echo "<li class=\"phone\"><span>".$phone."</span></li>";
						echo "<li class=\"dot\"></li>";
					}
					echo "<li class=\"mail\"><span>".$email."</span></li>";
					?>
					
				</ul>
			</div>
		</div>