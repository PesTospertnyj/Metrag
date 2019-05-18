<?php

namespace app\modules\olxparser\controllers;

use app\modules\olxparser\models\PagesList;
use app\modules\olxparser\models\Parser;
use app\modules\olxparser\models\ParserOlxLog;
use app\modules\olxparser\models\ParserOlxParams;
use app\modules\olxparser\models\ParserSearch;
use app\modules\olxparser\models\Proxy;
use app\modules\olxparser\olxParserHelper;
use Exception;
use Yii;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\Controller;

/**
 * CREATE TABLE `metragYiiNew`.`new_parser_olx_links_list` (
 * `link_id` INT NOT NULL AUTO_INCREMENT ,
 * `link` VARCHAR(255) NOT NULL ,
 * `status` ENUM('wait','ready') NOT NULL DEFAULT 'wait' ,
 * PRIMARY KEY (`link_id`)) ENGINE = InnoDB;
 * */

/**
 * Default controller for the `olxparser` module
 */
class DefaultController extends Controller {
	/**
	 * Logging
	 * @param $object
	 */
	private function log($object) {
		$dump = VarDumper::dumpAsString($object);
		Yii::info($dump);
	}
	/**
	 * Renders the index view for the module
	 * @return string
	 */
	public function actionIndex() {
		\app\modules\olxparser\OlxAssetsBundle::register($this->view);
		// создание таблицы с опциями
		if (false === olxParserHelper::tableExists('new_parser_olx_params')) {
			$this->paramsTableCreate();
		}
		//var_dump($searchModel); exit;
		$searchModel = new ParserSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$result = [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		];

		if (olxParserHelper::tableExists('new_parser_olx_parser')) {
			// Количество уникальных ссылок в БД
			$flats = olxParserHelper::tableExists('new_parser_olx_links_list') ? Yii::$app->db->createCommand('SELECT COUNT(`link`) FROM `new_parser_olx_links_list`')->queryScalar() : 0;

			// Количество обработанных уникальных ссылок
			$count_true_links_list = olxParserHelper::tableExists('new_parser_olx_parser') ? Yii::$app->db->createCommand('SELECT COUNT(`advert_id`) FROM `new_parser_olx_parser`')->queryScalar() : 0;

			// Общее количество страниц
			$count_pages_list = Yii::$app->db->createCommand('SELECT COUNT(*) FROM `new_parser_olx_pages_list`')->queryScalar();

			// Общее количество распаршенных страниц
			$count_true_pages_list = Yii::$app->db->createCommand('SELECT COUNT(*) FROM `new_parser_olx_pages_list` WHERE `status` IS NOT NULL')->queryScalar();

			return $this->render('other-calls', [
				'count_pages_list' => $count_pages_list,
				'count_true_pages_list' => $count_true_pages_list,
				'count_true_links_list' => $count_true_links_list,
				'flats' => $flats,
			] + $result);
		}

		return $this->render('first-call', $result);
	}

	public function actionHandlerDropTables() {
		$sql = "DROP TABLE IF EXISTS `new_parser_olx_links_list`, `new_parser_olx_pages_list`, `new_parser_olx_parser`, `new_parser_olx_options`";
		Yii::$app->db->createCommand($sql)->execute();
		return $this->redirect(['/olxparser/default/index']);
	}

	public function actionParams() {
		$post = Yii::$app->request->post('Params');
		if ($post) {
			foreach ($post as $name => $value) {
				Yii::$app->db->createCommand()->update('new_parser_olx_params', ['value' => $value], ['name' => $name, 'pack' => 1])->execute();
			}
		}

		$model = ParserOlxParams::findAll(['pack' => 1]);
		return $this->render('params', [
			'model' => $model,
		]);
	}

	public function beforeAction($action) {
		$css = <<<CSS
.colLeft {
    width: 50%;
    float: left;
}
.colRg {
    width: 50%;
    float: right;
}
#hellopreloader>p{display:none;}
#hellopreloader {
    display: block;
    width:100%;
    height:100%;
    z-index:9998;
    position:fixed;
    top:0;
    left:0;
    right:0;
    bottom: 0;
    background:rgba(0,0,0,.3);
}
.showTable {
    position:relative;
    display:inline-block;
    border: 1px solid #ccc;
    padding: 5px 20px;
    background: #fff;
    font-size: 20px;
    cursor: pointer;
    margin: 20px 0 10px;
}
#hellopreloader_preload{
    display: block;
    position: fixed;
    z-index: 99999;
    top: calc(50% - 50px);
    left: calc(50% - 50px);
    width: 100px;
    height: 100px;
    background: url(https://www.ppgvoiceofcolor.com/Content/images/loader.gif) center center no-repeat;
    background-size:cover;}
.fixedFormButton {
    display: block;
    position:absolute;
    width: 30px;
    height:30px;
    right: 20px;
    top: 65px;
    background: url(http://s1.iconbird.com/ico/2014/1/625/w128h1281390855539deletedatabase128.png);
    background-size: contain;
    cursor: pointer;
}
.formCont {
   display: none;
   position:fixed;
   right: calc(50% - 200px);
   top: 30%;
   background: #eeeeee;
   width: 400px;
    height: auto;
    padding: 20px;
    box-sizing: border-box;
    text-align: center;
    font-size: 32px;
    border: 1px solid #919191;
}
.formCont form > div {
    margin: 0 0 20px;
}
.formCont form {
    border: 1px solid #919191;
    padding: 10px 10px 10px;
}
.formCont label {
    font-size: 32px;
    display: block;
    margin: 0 0 20px;
    line-height: 30px;
}
.clearButton {
    background: #b2c3d0;
    border: 1px solid #000;
    font-size: 24px;
    padding: 5px 10px;
    display: inline-block;
    margin: 0 10px 0 0;
}
.closeFormButt {
    display:block;
    position:absolute;
    width:20px;
    height: 20px;
    top: 0;
    right: 0;
    background: url(https://d30y9cdsu7xlg0.cloudfront.net/png/52944-200.png);
    background-size: contain;
    cursor: pointer;
}
.closeForm {
    cursor: pointer;
}
.olx-table-result {
    border-collapse:  collapse;
    #display: none;
}
.olx-table-result th,
.olx-table-result td{
    border: 1px solid black;
    text-align: center;

}
.olx-table-result td div {
    height: 90px;
    overflow-Y:scroll;
}

.olx-table-result td {
   /*background: rgb(255, 255, 0);*/
}
/* Изменяем цвета строк в зависимости от статуса */
.status-1 {
   background: rgb(255, 255, 0);
}
.status-2 {
   background: #FFFFFF;
}
.status-3 {
   background: coral;
}
.status-4 {
   background: greenyellow;
}
.status-5 {
   background: #C4C4C4;
}

.olx-table-result td a {
    color: #0088cc;
}
.olx-table-result td a:hover {
    opacity: .7;
}
.tooltip {
    z-index:999;
    left:-9999px;
    top:-9999px;
    background:#fff;
    border:1px solid #ccc;
    font-size:15px;
    color:#323232;
    padding:4px 8px;
    position:absolute;
}
.tooltip p {
    margin: 0px;
    padding: 0px;
}
.olx-table-result tr td:nth-last-of-type(1) div {
    max-width: 300px;
}
#pag-link {
    display:none;
    width: 100%;
    margin: 20px 0 10px;
}
#pag-link  span {
    margin: 5px;
}
#pag-link a {
    font-size: 20px;
    line-height: 1.5;
    display: block;
    width: 32px;
    height: 32px;
    transition: all .8s;
    text-align: center;
    color: #000;
    border-radius: 120px;
    transition: all .3s;
}
#pag-link * {
    display:inline-block;
}
.pag-link-active {
     color: #fff!important;
    background-color: #4caf50;
}
#pag-link a:hover {
    color: #fff!important;
    background-color: #4caf50;
}
.cresrPopup {
    display: none;
    position: fixed;
    top: 40%;
    background-color: #eee;
    width: 200px;
    left: calc(50% - 100px);
    padding: 10px;
    text-align: center;
    z-index: 9999;
}
.cresrPopup p {
    font-size: 16px;
    margin: 0 0 20px;
}
.closeFormSecPopup {
    cursor: pointer;
}
.table th, .table th a {
   white-space:pre-wrap;

}
.table td,
.table th {
 vertical-align: middle !important;

}
.table td {
     text-shadow: 1px 1px 1px;
}
CSS;

		Yii::$app->view->registerCss($css);

		Yii::$app->view->registerJs(
			"var main_url = '" . Url::to(['default/get-pages']) . "';",
			\yii\web\View::POS_HEAD,
			'yiiOptions'
		);

		$js = <<<JS


$(document).ready(function(){
      $('[name = startparsing], [name = startUniqueParsing], a > .showTable').on('click', function(){
       $('#hellopreloader').show();
    });

    $('.colRg > .showTable').on('click', function(){

        $('.olx-table-result, .pagination').toggle();
        $('#pag-link').toggle();
        if($('.olx-table-result').is(':visible')){
            $(this).text('Скрыть таблицу');
        }
        else {
            $(this).text('Показать таблицу');
        }
    });
    $('.fixedFormButton').click(function(){
       $('.formCont').toggle();
    });
    $('.closeForm, .closeFormButt').click(function(){
        $('.formCont').hide();
    });
    // $('.olx-table-result td div').hover(function(){

    // });
 // function ('.olx-table-result td div', tooltip){
$('.tooltipTd').hover(function(){
    $('.tooltipTd').each(function(i){
        $("body").append("<div class='tooltip' id='"+tooltip+i+"'><p>"+$(this).text()+"</p></div>");
        var tooltip = $("#"+tooltip+i);
        if($(this).text() != "" && $(this).text() != "undefined" ){
            $(this).mouseover(function(){
                tooltip.css({opacity:0.9, display:"none"}).fadeIn(30);
        }).mousemove(function(kmouse){
                tooltip.css({left:kmouse.pageX-105, top:kmouse.pageY+15});
        }).mouseout(function(){
                tooltip.fadeOut(10);
        });
        }
    });
});
// l_tooltip($('.olx-table-result td div'), tooltip);



})
$(window).load(function(){
    $('#hellopreloader').hide();
    //if($('.pagination .active a').text() == '11') {
    //    $('.olx-table-result, .pagination').hide();
    //}
    //else {
    //      $('.olx-table-result, .pagination').show();
    //}
    $('.clearButton').on('click', function(){
        $('.formCont').hide();
        $('.cresrPopup').show();
    });
    $('.closeFormSecPopup').on('click', function(){
        $('.cresrPopup').hide();
    });
});
JS;

		Yii::$app->view->registerJs($js);

		return true;
	}

	public function actionGetPages() {
		extract(ParserOlxParams::params());
		$data['errorCode'] = '0';
		$count = (new \yii\db\Query())
			->from('new_parser_olx_pages_list')
			->count();
		if ($count == 0) {
			Yii::$app->db->createCommand()
				->insert('new_parser_olx_pages_list', [
					'page_url' => $root_url,
					'proxy' => "",
				])->execute();
			$this->getPage($root_url);
		}

		$sql = 'SELECT page_url FROM new_parser_olx_pages_list WHERE `status` = "wait" ORDER BY cast( SUBSTRING(page_url FROM LOCATE ("=", page_url) + 1) as unsigned)';
		$parsing_data = Yii::$app->db->createCommand($sql)->queryColumn();
		if (empty($parsing_data)) {
			$data['status'] = 'end';
		}
		//если есть что парсить
		if (!empty($parsing_data)) {
			$data['url'] = reset($parsing_data);
			$session = Yii::$app->session;
			if (!$session->isActive) {
				$session->open();
			}
			if (!$session->has('list_proxy')) {
				$proxys = Proxy::find()->all();
				if ($proxys) {
					$list_proxy = [];
					foreach ($proxys as $proxy) {
						array_push($list_proxy, "");
						array_push($list_proxy, "$proxy->ip:$proxy->port");
					}
				}
				$session->set('list_proxy', $list_proxy);
			} else {
				$list_proxy = $session->get('list_proxy');
				if (count($list_proxy) == 0) {
					$data['status'] = 'error';
					$data['statusText'] = 'end list of proxy';
					$data['errorCode'] = '1';
					$session->remove('list_proxy');
				} else {
					$data['proxy'] = array_shift($list_proxy);
					$session->set('list_proxy', $list_proxy);
					try {
						if ($this->getPage($data['url'], $data['proxy'])) {
							if ($data['proxy'] != '') {
								Proxy::setProxyStatus($data['proxy'], true);
							}
							$data['status'] = 'page';
							$data['errorCode'] = '0';
						} else {
							if ($data['proxy'] != '') {
								Proxy::setProxyStatus($data['proxy'], false);
							}
							$data['status'] = 'error';
							$data['errorCode'] = '2';
						}
					} catch (Exception $e) {
						$data['statusText'] = $e->getMessage();
					}
				}
			}
		}

		$data['total'] = Yii::$app->db->createCommand("SELECT COUNT(*) FROM `new_parser_olx_pages_list`")->queryScalar();
		$data['ready'] = Yii::$app->db->createCommand("SELECT COUNT(*) FROM `new_parser_olx_pages_list` WHERE `status` ='ready'")->queryScalar();


		echo Json::encode(["total" => $data['total'], "ready" => $data['ready'], "status" => $data['status'], "statusText" => $data['statusText'],
			"errorCode" => $data['errorCode'], "url" => $data['url'], "proxy" => $data['proxy']]);
		Yii::$app->end();
	}

	private function getPage($pageUrl, $proxy = false) {

        //$proxy = '98.124.121.102:53281';
        //$proxy = '134.249.61.92:39880';

        //var_dump('dick 123'); exit;

		ini_set('max_execution_time', 0);
		ini_set('max_input_time', -1);
		$ch = curl_init();
		$this->logDB("Processed: $pageUrl   Proxy: $proxy");
		/* Настраиваем опции */
		curl_setopt($ch, CURLOPT_URL, "$pageUrl");

        //var_dump('dicl 123', CURLOPT_PROXY, $proxy); exit;
		if ($proxy) {
			curl_setopt($ch, CURLOPT_PROXY, $proxy);
		}
		$useragent = $list_users_agents[rand(0, $count_list_users_agents)];
		curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		curl_setopt($ch, CURLOPT_ENCODING, "");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //required for https urls
		$output = curl_exec($ch);


		$status = curl_getinfo($ch);
        //var_dump($output, $status); exit;
		curl_close($ch);
		if ($status['http_code'] == 301 || $status['http_code'] == 0) {
			$this->logDB("-------Status1: {$status['http_code']} Proxy: $proxy----------");
			$this->logDB("-------Redirect URL: {$status['redirect_url']}");
			/*if($proxy)
				            {
				                Proxy::setProxyStatus($proxy, true);
			*/
			/*Yii::$app->db->createCommand()
				->update("new_parser_olx_pages_list", ['status' => 'ready'], 'page_url=:url', [":url" => $pageUrl])
				->execute();*/
			return false;
		}
		if ($status['http_code'] != 200 || $output === FALSE) {
			$this->logDB("-------Status2: {$status['http_code']} Proxy: $proxy----------");
			/*if($proxy)
				            {
				                Proxy::setProxyStatus($proxy, false);
			*/
			return false;
		}

		if (preg_match_all('/<a class="block br3 brc8[^"]*".*?href="([^"]*?)"/', $output, $matches_key)) {
			//$this->logDB('pages links found');
			$this->logDB("OK. Надены ссылки на другие страницы.($pageUrl)");
			$this->logDB(var_export($matches_key['1'], true));
			foreach ($matches_key['1'] as $key => $value) {
				$link = trim($value);
				try {
					// Проверяем, нет ли записи в таблице
					$result = Yii::$app->db->createCommand("SELECT * FROM new_parser_olx_pages_list WHERE page_url=:url")
						->bindParam(":url", $value)
						->queryOne();
					// если такой страницы нет, то ее надо добавить
					// если сейчас она обрабатывается
					if (!$result) {
						// добавляем страницу в список обрабатываемых
						Yii::$app->db->createCommand()
							->insert('new_parser_olx_pages_list', [
								'page_url' => $link,
								'proxy' => $proxy,
							])->execute();
						$this->logDB("Добавлена:$link");

					}
				} catch (Exception $e) {
					$this->logDB('link search ex - ' . $e->getMessage());
				}
			}
			// список страниц обработан. теперь берем все ссылки с данной страница
			// пытаемся найти ссылки на объекты
			$objectsQuantity = $this->getObjectsLinks($output);
			// если ссылки на объекты найдены, то сообщаем, что страница обработана
			if ($objectsQuantity) {
				/*if($proxy)
					                {
					                    Proxy::setProxyStatus($proxy, true);
				*/

				Yii::$app->db->createCommand()
					->update("new_parser_olx_pages_list", ['status' => 'ready'], 'page_url=:url', [":url" => $pageUrl])
					->execute();
				return true;
			}
		} else {
			// на странице не надены ссылки на другие страницы. это ошибка. ее обрабатывать не надо
			$this->logDB("на странице не надены ссылки на другие страницы. это ошибка. ее обрабатывать не надо($pageUrl)");
			Yii::$app->db->createCommand()
				->update("new_parser_olx_pages_list", ['status' => 'ready', 'proxy' => $proxy], 'page_url=:url', [":url" => $pageUrl])
				->execute();
			return true;
		}
		return false;
	}

	public function actionResearchPage($limit) {
		//if (PagesList::find()->where(['status' => 'wait'])->count()) {
		//	return true;
		//}
		$temp_pages = PagesList::find()->where(['status' => 'wait'])->all();
		if ($temp_pages) {
			foreach ($temp_pages as $page) {
				$page->status = 'ready';
				$page->save(false);
			}
		}
		if ($limit == 'all') {
			$pages = PagesList::find()->all();
		} else {
			$pages = PagesList::find()->limit($limit)->orderBy(['id' => SORT_ASC])->all();
		}
		foreach ($pages as $page) {
			$page->status = 'wait';
			$page->save();
		}
		return true;
	}

	private function getObjectsLinks($txt) {
		extract(ParserOlxParams::params());
		if (preg_match($_pattern_search_container_offers_table, $txt, $matches)) {
			//$this->logDB('container found!');
			$container_offers_table = $matches['0'];
			if (preg_match_all($_object_link, $container_offers_table, $links)) {
				//$this->logDB('obj links found!');
				foreach ($links['1'] as $key => $link) {
					$link = strstr($link, '#', true);
					$result = Yii::$app->db->createCommand("SELECT * FROM new_parser_olx_links_list WHERE link=:url")
						->bindValue(":url", $link)
						->queryOne();
					if (!$result) {
						$all_links_tmp[] = [$link];
					}

				}
				$this->logDB(var_export($all_links_tmp, true));
				Yii::$app->db->createCommand()
					->batchInsert('new_parser_olx_links_list', ['link'],
						$all_links_tmp)
					->execute();
				return true;
			}
		}
		return false;
	}

	public function actionHandleApartmentsLinks() {
		extract(ParserOlxParams::params());
		$this->parserTableCreate();
		$data['errorCode'] = '0';
		// Проверяем, есть ли объекты для парсинга
		$data['url'] = reset(Yii::$app->db->createCommand('SELECT link FROM `new_parser_olx_links_list` WHERE `status` = "wait" LIMIT 1')->queryColumn());
		if (empty($data['url'])) {
			$data['status'] = 'end';
		}

		if (!empty($data['url'])) {
			$result = Yii::$app->db->createCommand("SELECT * FROM new_parser_olx_parser WHERE link=:url")
				->bindParam(":url", $data['url'])
				->queryOne();
			if ($result) {
				Yii::$app->db->createCommand()
					->update("new_parser_olx_links_list", ['status' => 'ready'], 'link=:url', [":url" => $data['url']])
					->execute();
				$data['status'] = 'page';
				$data['errorCode'] = '0';
			}
			if (!$result) {
				$session = Yii::$app->session;
				if (!$session->isActive) {
					$session->open();
				}
				if (!$session->has('list_proxy')) {
					$proxys = Proxy::find()->all();
					if ($proxys) {
						$list_proxy = [];
						foreach ($proxys as $proxy) {
							array_push($list_proxy, "");
							array_push($list_proxy, "$proxy->ip:$proxy->port");
						}
					}
					$session->set('list_proxy', $list_proxy);
				} else {
					$list_proxy = $session->get('list_proxy');
					if (count($list_proxy) == 0) {
						$data['status'] = 'error';
						$data['statusText'] = 'end list of proxy';
						$data['errorCode'] = '1';
						$session->remove('list_proxy');
					} else {
						$data['proxy'] = array_shift($list_proxy);
						$session->set('list_proxy', $list_proxy);
						try {
							if ($this->getObjectInfo($data['url'], $data['proxy'])) {
								// Найдена информация об объекте. Отмечаем, что объект обработан.
								//$this->logDB("data url - {$data['url']}");
								Yii::$app->db->createCommand()
									->update("new_parser_olx_links_list", ['status' => 'ready'], 'link=:url', [":url" => $data['url']])
									->execute();
								if ($data['proxy'] != '') {
									Proxy::setProxyStatus($data['proxy'], true);
								}
								$data['status'] = 'page';
								$data['errorCode'] = '0';
							} else {
								if ($data['proxy'] != '') {
									Proxy::setProxyStatus($data['proxy'], false);
								}
								$data['status'] = 'error';
								$data['errorCode'] = '2';
							}
						} catch (Exception $e) {
							$data['statusText'] = $e->getMessage();
						}
					}
				}
			}
		}

		$data['total'] = Yii::$app->db->createCommand("SELECT COUNT(*) FROM `new_parser_olx_links_list`")->queryScalar();
		$data['ready'] = Yii::$app->db->createCommand("SELECT COUNT(*) FROM `new_parser_olx_links_list` WHERE `status` ='ready'")->queryScalar();

		echo Json::encode(["total" => $data['total'], "ready" => $data['ready'], "status" => $data['status'], "statusText" => $data['statusText'],
			"errorCode" => $data['errorCode'], "url" => $data['url'], "proxy" => $data['proxy']]);
		Yii::$app->end();
	}

	/**
	 * @param $apartment_link
	 * @param $proxy
	 * @return bool
	 *
	 *
	 * Получаем информацию об объекте. Обязательно получаем телефон. Только тогда информация считается собранной.
	 */
	private function getObjectInfo($apartment_link, $proxy) {
		//$this->logDB("url - $apartment_link, proxy - $proxy");
		extract(ParserOlxParams::params());
		// Инициализируем переменные
		$array_flat_properties = array();
		$link = $path = $date = $price = $note = $phone = $image = $advert_from = $type = $type_flat = '';
		$count_apartment_parsing = $count_fail_apartment_parsing = $advert_id =
		$kolfoto = $count_room = $floor = $floor_all = $total_area = $floor_area =
		$kitchen_area = 0;

		// Инициализируем cURL-сессию
		$ch = curl_init();
		ini_set('max_execution_time', 0);
		ini_set('memory_limit', '1024M');
		ini_set('max_input_time', -1);
		if ($proxy) {
			curl_setopt($ch, CURLOPT_PROXY, $proxy);
		}

		curl_setopt($ch, CURLOPT_URL, $apartment_link);
		$useragent = $list_users_agents[rand(0, $count_list_users_agents)];
		curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		curl_setopt($ch, CURLOPT_ENCODING, "");
		//curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //required for https urls
		$output = curl_exec($ch);
		$status = curl_getinfo($ch);
		curl_close($ch);
		if ($status['http_code'] != 200 || $output === FALSE) {
			$this->logDB("-------Status3: {$status['http_code']} Данные не получены Proxy: $proxy----------");
			if ($status['http_code'] == 301) {
				$this->logDB("url - $apartment_link  =====  redirect url - {$status['redirect_url']}");
				//$_pattern_location_for_301 = '\Location:\s*(.*)\sX-B:\is';
				//$this->getObjectInfo($status['redirect_url'], $proxy);
				//return $this->getObjectInfo($status['redirect_url'], $proxy);
				Yii::$app->db->createCommand() // where        prepare
					->update("new_parser_olx_links_list", ['link' => $status['redirect_url']], 'link=:url', [":url" => $apartment_link])
					->execute();
			}
			return false;
		}
		// Ссылка на объявление
		$link = $apartment_link;
		// Если объявление неактивно, отмечаем как обработанное
		if (preg_match($_pattern_inactive_link, $output, $matches)) {
			return true;
		}
		if (preg_match($_pattern_404_link, $output, $matches)) {
			return true;
		}
		// Находим контейнер с необходимой информацией о заголовке объяления
		if (preg_match($_pattern_search_title_publication, $output, $matches)) {
			$title_publication = trim(strip_tags($matches['1']));
			$path = "<a href='$link' target='_blank'>$title_publication</a>";
		}
		// Находим контейнер с необходимой информацией о дате публикации и об ID объяления
		if (preg_match($_pattern_search_container_date_publication, $output, $matches)) {
			$container_date_publication = $matches['0'];
			if (preg_match($_pattern_search_date_publication, $container_date_publication, $matches)) {
				$date_publication = $matches['1'];
				$date = $this->normaliseDate($date_publication);
			}
			if (preg_match($_pattern_search_ID_publication, $container_date_publication, $matches)) {
				$id_publication = $matches['0'];
				$advert_id = $id_publication;
			}
		}
		// Находим контейнер с необходимой дополнительной информацией
		if (preg_match_all($_pattern_search_container_additional_info_key, $output, $matches_key)) {
			foreach ($matches_key['0'] as $value_str) {
				preg_match($_pattern_search_container_additional_info_value, $value_str, $matches_tmp);
				$array_values[] = $matches_tmp['0'];
			}
			foreach ($matches_key['1'] as $key => $value) {
				$array_flat_properties[$value] = trim(strip_tags($array_values[$key]));
				/* Массив $array_flat_properties содержит всю необходимую доп. информацию */
			}
			// @se: была ошибка `Undefined index` из-за предыдущего кода
			$prop = function ($key, $default) use ($array_flat_properties) {
				if (isset($array_flat_properties[$key])) {
					return $array_flat_properties[$key];
				} else {
					return $default;
				}
			};
			$advert_from = $prop('Объявление от', '-');
			$type = $prop('Тип', '-');
			$type_flat = $prop('Тип квартиры', '-');
			$count_room = $prop('Количество комнат', 0);
			$floor = $prop('Этаж', 0);
			$floor_all = $prop('Этажность дома', 0);
			$total_area = $prop('Общая площадь', 0);
			$floor_area = $prop('Жилая площадь', 0);
			$kitchen_area = $prop('Площадь кухни', 0);
		}
		unset($array_values);
		// Находим контейнер с ценой
		if (preg_match($_pattern_search_container_price, $output, $matches)) {
			$price = trim(strip_tags($matches['0']));
		}
		// Находим контейнер с описанием
		if (preg_match($_pattern_search_container_description, $output, $matches)) {
			$note = trim(strip_tags($matches['0']));
		}
		/* ТЕЛЕФОННЫЙ НОМЕР */
		//проверяем есть ли контейнер телефона
		if (preg_match($_pattern_phone_field, $output, $matches)) {
			// Находим id номера телефона
			if (preg_match($_pattern_search_id_phone, $output, $matches)) {
				$idphone = $matches['1'];
				//$this->logDB("=====id phone:".$idphone);
			}
			// Задаём необходимый url для работы Curl
			$url_address_phone = "{$url_phone}{$idphone}/";
			//$this->logDB("url_address_phone - $url_address_phone");
			// search cookies
			$cookies = $this->getCookies($output);
			$pt = '';
			if (preg_match($_pattern_search_pt, $output, $matches)) {
				$pt = $matches[1];
			}
			$phones = $this->getPhones($url_address_phone, $proxy, $useragent, $pt, $cookies["PHPSESSID"]);
			if (!$phones) {
				$this->logDB('phone error; ' . $apartment_link);
				// не можем получить телеффоны. прерываем работу.
				return false;
			}
		} else {
			$this->logDB('parser:  Контейнер телефона не найден');
			$this->logDB('no phone set');
			$phones = 'no phone';
		}
		// Находим все фотографии, относящиеся к данному объявлению
		if (preg_match_all($_pattern_all_photos, $output, $matches)) {
			$kolfoto = count($matches['1']);
			$image = serialize($matches['1']);
			$this->logDB('parser: images: ' . $image);
		} else {
			$this->logDB('parser: no images block found');
		}

		// Наполняем таблицу распаршенными данными

		$result = Yii::$app->db->createCommand("SELECT * FROM new_parser_olx_parser WHERE advert_id=:id")
			->bindParam(":id", $advert_id)
			->queryOne();
		if (!$result) {
			Yii::$app->db->createCommand()
				->insert('new_parser_olx_parser', [
					'advert_id' => $advert_id,
					'link' => $link,
					'path' => $path,
					'date' => $date,
					'type_object_id' => 12,
					'advert_from' => $advert_from,
					'type' => $type,
					'type_flat' => $type_flat,
					'count_room' => $count_room,
					'floor' => $floor,
					'floor_all' => $floor_all,
					'total_area' => $total_area,
					'floor_area' => $floor_area,
					'kitchen_area' => $kitchen_area,
					'price' => $price,
					'phone' => $phones,
					'status' => 1,
					'note' => $note,
					'kolfoto' => $kolfoto,
					'image' => $image,
					'view' => 'no',
				])->execute();

		}
		return true;

	}

	private function getPhones($url, $proxy, $useragent, $pt, $phpsessid) {
		extract(ParserOlxParams::params());
		$ch = curl_init();
		// Задаём опции для корректной работы Curl
		$url .= "?pt=$pt";
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_PROXY, $proxy);
		curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		$strCookie = "PHPSESSID=$phpsessid;";
		curl_setopt($ch, CURLOPT_COOKIE, $strCookie);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		curl_setopt($ch, CURLOPT_ENCODING, "");
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //required for https urls

		$response = curl_exec($ch);
		// Разделяем строку полученного ответа по маркерам окончания строки
		$result_answer = explode("\r\n", $response);
		curl_close($ch);

		// Если ответ положительный ( код 200 ) - продолжаем получать номера телефонов
		if ($result_answer['0'] == "HTTP/1.1 200 OK") {
			$this->logDB("Response - $response");
			if (preg_match($_pattern_search_phone_value, $response, $matches)) {
				$this->logDB("Matches - {$matches['1']}");
				if (preg_match_all($_pattern_only_phones, $matches['1'], $phones)) {
					$phone_numbers = [];
					foreach ($phones['0'] as $item) {
						$this->logDB("item - $item");
						$phone_number = str_replace([' ', '+', '-', '(', ')'], '', $item);
						if (preg_match($_phone_normalise, $phone_number, $normalise_phone)) {
							$phone_numbers[] = $normalise_phone[3];
						}
					}
					$phone = implode(", ", $phone_numbers);
				}
			}
		} else {
			return false;
		}
		return $phone;
	}

	private function logDB($value) {
		$model = new ParserOlxLog();
		switch (gettype($value)) {
		case "array":{
				$model->text = join(",", $value);
			}break;
		default:
			$model->text = $value;
		}

		$model->save();
	}

	public function paramsTableCreate() {
		Yii::$app->db->createCommand("CREATE TABLE `new_parser_olx_params` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `pack` int(11) NOT NULL,
          `name` varchar(255) NOT NULL,
          `label` varchar(255) NOT NULL,
          `value` text NOT NULL,
          `default_value` text NOT NULL,
          `textfield` tinyint(4) NOT NULL DEFAULT '0',
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;")->execute();

		Yii::$app->db->createCommand("INSERT INTO `new_parser_olx_params` (`id`, `pack`, `name`, `label`, `value`, `default_value`, `textfield`) VALUES
        (1,	1,	'list_proxy',	'proxy ip:port, по одному в строке',	'83.239.58.162:8080\r\n',	'',	1),
        (17,	1,	'root_url',	'Задаём исходный URL для парсинга информации',	'https://www.olx.ua/nedvizhimost/prodazha-kvartir/kharkov/',	'https://www.olx.ua/nedvizhimost/prodazha-kvartir/kharkov/',	0),
        (19,	1,	'list_users_agents',	'user agent, по одному в строке',	'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; FSL 7.0.6.01001)\r\n',	'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; FSL 7.0.6.01001)\r\n',	1),
        (20,	1,	'_count_true_pages_list',	'Количество обработываемых объектов за одну итерацию',	'100',	'100',	0),
        (21,	1,	'url_phone',	'Задаём необходимый url для получения номера телефона при помощи ajax',	'https://www.olx.ua/ajax/misc/contact/phone/',	'https://www.olx.ua/ajax/misc/contact/phone/',	0),
        (22,	1,	'max_pagecount',	'Задаем максимальное количество страниц для парсинга',	'500',	'',	0);
        ")->execute();
	}

	public function parserTableCreate() {
		Yii::$app->db->createCommand("CREATE TABLE IF NOT EXISTS `new_parser_olx_parser` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`advert_id` int(11) NOT NULL UNIQUE,
		`link` text NOT NULL,
		`path` text NOT NULL,
		`date` varchar(255) NOT NULL,
		`type_object_id` int(11) NOT NULL,
		`advert_from` varchar(255) NOT NULL,
		`type` varchar(255) NOT NULL,
		`type_flat` varchar(255) NOT NULL,
		`count_room` int(11) NOT NULL,
		`floor` int(11) NOT NULL,
		`floor_all` int(11) NOT NULL,
		`total_area` int(11) NOT NULL,
		`floor_area` int(11) NOT NULL,
		`kitchen_area` int(11) NOT NULL,
		`price` varchar(255) NOT NULL,
		`phone` text NOT NULL,
		`status` ENUM('wait','ready') NOT NULL DEFAULT 'wait',
		`note` text NOT NULL,
		`kolfoto` int(11) NOT NULL,
		`image` text NOT NULL,
		`view` enum('neprov','no','yes','tel') NOT NULL,
		`count_similar_advs` INT(11) NOT NULL DEFAULT 0,
		PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1")->execute();

	}

	public function actionProcessPagesInfo() {
		$pages_total = Yii::$app->db->createCommand("SELECT COUNT(*) FROM `new_parser_olx_pages_list`")->queryScalar();
		$pages_ready = Yii::$app->db->createCommand("SELECT COUNT(*) FROM `new_parser_olx_pages_list` WHERE `status` ='ready'")->queryScalar();
		echo Json::encode(["total" => $pages_total, "ready" => $pages_ready]);
		Yii::$app->end();
	}

	public function actionProcessLinksInfo() {
		$pages_total = Yii::$app->db->createCommand("SELECT COUNT(*) FROM `new_parser_olx_links_list`")->queryScalar();
		$pages_ready = Yii::$app->db->createCommand("SELECT COUNT(*) FROM `new_parser_olx_links_list` WHERE `status` ='ready'")->queryScalar();
		echo Json::encode(["total" => $pages_total, "ready" => $pages_ready]);
		Yii::$app->end();
	}

	public function actionClearTables() {
		//TRUNCATE TABLE `new_parser_olx_links_list`
		Yii::$app->db->createCommand("TRUNCATE TABLE new_parser_olx_pages_list")->execute();
		Yii::$app->db->createCommand("TRUNCATE TABLE new_parser_olx_links_list")->execute(); //new_parser_olx_pages_list
		$this->redirect(['/olxparser/default/']);
	}

	private function getCookies($text) {
		preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $text, $matches);
		$cookies = array();
		foreach ($matches[1] as $item) {
			parse_str($item, $cookie);
			$cookies = array_merge($cookies, $cookie);
		}

		return $cookies;
	}

	//------------------------------------------ test -------------------------------------------

	public function actionTest() {
		echo 'test!!';
		$link = "https://www.olx.ua/obyavlenie/2-kom-kv-novostroy-69-kv-m-saltovka-saltovskoe-shosse-602-m-r-IDtN1Z6.html";
		//https://www.olx.ua/obyavlenie/prodam-2-kom-kv-ul-elizarova-5-min-ot-m-hol-gora-IDuqcKu.html

		echo $page = $this->get_page($link);

		if ($page) {
			extract(ParserOlxParams::params());
			if (preg_match($_pattern_search_id_phone, $page, $matches)) {
				$idphone = $matches['1'];
				//$this->logDB("=====id phone:".$idphone);
			}
			$url_address_phone = "{$url_phone}{$idphone}/";
			// search cookies
			$cookies = $this->getCookies($page);
			$pt = '';
			$_pattern_search_pt = '/var phoneToken = \'([a-z0-9]+)\';/is';
			if (preg_match($_pattern_search_pt, $page, $matches)) {
				$pt = $matches[1];
			}
			echo 'Phones - ';

			$phones = $this->getPhones($url_address_phone, '', '', $pt, $cookies["PHPSESSID"]);
			if (!$phones) {
				$this->logDB('phone error 1');
				return false;
			}
			print_r($phones);
			/*$pt = '';
				            $_pattern_search_pt = '/var phoneToken = \'([a-z0-9]+)\';/is';
				            if (preg_match($_pattern_search_pt, $page, $matches)) {
				                $pt = $matches[1];
				            }
				            $cookies = $this->getCookies($page);
				            echo "<pre>";
				            print_r($cookies);
				            echo "</pre>";
			*/
		}
	}

	private function get_page($pageUrl) {
		$ch = curl_init();
		/* Настраиваем опции */
		curl_setopt($ch, CURLOPT_URL, "$pageUrl");
		// curl_setopt($ch, CURLOPT_COOKIEFILE, 'c:/OpenServer2/domains/olxphones/cookies.txt'); // set cookie file to given file
		// curl_setopt($ch, CURLOPT_COOKIEJAR, 'c:/OpenServer2/domains/olxphones/cookies.txt'); // set same file as cookie jar
		//$proxy = '195.34.238.52:65301';
		//curl_setopt($ch, CURLOPT_PROXY, $proxy);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		//curl_setopt($ch, CURLOPT_NOBODY, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, "Chrome/55.0.2883.75");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		curl_setopt($ch, CURLOPT_ENCODING, "");
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //required for https urls
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); //required for https urls

		$output = curl_exec($ch);
		$status = curl_getinfo($ch);
		curl_close($ch);
		$_pattern_location_for_301 = '\Location:\s*(.*)\sX-B:\is';
		if ($status['http_code'] != 200 || $output === FALSE) {
			//return "=========Status4: {$status['http_code']}";
			//echo "=========Status5: {$status['http_code']}";
			if ($status['http_code'] == 301) {
				//if(preg_match($_pattern_location_for_301, ))
				return $this->get_page($status['redirect_url']);
				//return false;
				//var_dump($status);
			}
			//return $output;
			return false;
		}
		return $output;
	}

	private function normaliseDate($str) {
		include Url::to("@app/modules/olxparser/months.php");
		$d = explode(" ", $str);
		$month = $months[trim($d[1])];
		if ($month != '') {
			$temp = new \DateTime(trim($d[2]) . '-' . $month . '-' . trim($d[0]));
			$date = date_format($temp, 'Y-m-d');
		} else {
			$date = date('Y-m-d');
		}
		return $date;
	}

	public function actionTestMonth() {
		$str = '12 августа 2017';
		require_once "/../months.php";
		$d = explode(" ", $str);
		$month = $months[trim($d[1])];
		if ($month != '') {
			$test = new \DateTime(trim($d[2]) . '-' . $month . '-' . trim($d[0]));
			$date = date_format($test, 'Y-m-d');
		} else {
			$date = date('Y-m-d') . "-now";
		}

		echo $date;
	}

	public function actionDateconvert() {
		$objects = Parser::find()->all();
		foreach ($objects as $obj) {
			$tmp_date = $this->normaliseDate($obj->date);
			echo $tmp_date . ", ";
			$obj->date = $tmp_date;
			$obj->save(false);
		}
	}
}