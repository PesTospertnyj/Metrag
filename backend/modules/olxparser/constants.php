<?php

define("OLX_RU_OBYAVLENIE_OT", "Объявление от");
define("OLX_RU_TIP_KVARTIRI", "Тип квартиры");
define("OLX_RU_KOLICHESTVO_KOMNAT", "Количество комнат");
define("OLX_RU_OBSCHAYA_PLOSCHAD", "Общая площадь");
define("OLX_RU_JILAYA_PLOSCHAD", "Жилая площадь");
define("OLX_RU_PLOSCHAD_KUHNI", "Площадь кухни");
define("OLX_RU_TIP", "Тип");
define("OLX_RU_ETAJ", "Этаж");
define("OLX_RU_ETAJNOST_DOMA", "Этажность дома");

/* Регулярные выражения */
 return [
/* 1) Поиск контейнера с необходимыми объявлениями */
//'_pattern_search_container_offers_table' => "/<(table)[^>]*id\s*=\s*(['\"])offers_table\\2[^>]*>.*?<tbody>.*?<tr>.*?<td>[\S\s]*<\/td>.*?<\/tr>.*?<\/tbody>.*?<\/table>/is",
'_pattern_search_container_offers_table' => "/<(table)[^>]*id\s*=\s*(['\"])offers_table[^>]*>.*?<tbody>.*?<tr>.*?<td>[\S\s]*<\/td>.*?<\/tr>.*?<\/tbody>.*?<\/table>/is",
/* 2) Поиск всех ссылок на индивидуальные объявления */
'_pattern_search_all_links' => '/href="([^"]+)"/',
/* 3) Поиск общего количества страниц с необходимыми объявлениями */
'_pattern_search_total_pages' => '/{totalPages:.*?([0-9]{1,4})}/',
/* 4) Поиск контейнера с указанием даты публикации объявления */
'_pattern_search_container_date_publication' => '/<div class="offer-titlebox__details">.*?<\/div>/is',
/* 5) Поиск заголовка объявления */
'_pattern_search_title_publication' => '/<div class="offer-titlebox">.*?(<h1>.*?<\/h1>).*?<\/div>/is',
/* 6) Поиск даты публикации объявления */
'_pattern_search_date_publication' => '/<em>.*?, ([^,]*).*?<\/em>/is',
/* 7) Поиск ID объявления */
'_pattern_search_ID_publication' => '/[0-9]{7,12}/',
/* 8) Поиск дополнительной информации объявления ("ключ") */
'_pattern_search_container_additional_info_key' => '/<table class="item".*?>([^<\/th>]+)<\/th>.*?<\/table>/is',
/* 9) Поиск дополнительной информации объявления ("значение") */
'_pattern_search_container_additional_info_value' => '/<strong>.*?<\/strong>/is',
/* 10) Поиск контейнера с ценой квартиры */
'_pattern_search_container_price' => '/<div class="price-label">.*?<\/div>/is',
/* 11) Поиск контейнера с описанием квартиры */
'_pattern_search_container_description' => '/<div class="clr" id="textContent">.*?<\/div>/is',
/* 12) Поиск ID телефона */
'_pattern_search_id_phone' => "/{'path':'phone', 'id':'([^']+).*?'}/is",
/* 13) Поиск ID телефона */
'_pattern_search_phone_value' => '/{"value":"(.*?)"}/is',
/* 14) Выбираем только мобильные телефоны */
//'_pattern_only_phones' => '/([0-9 +-]{6,20})/',
'_pattern_only_phones' => '/([\(\)0-9 +-]{6,20})/',
/* 15) Поиск всех фотографий объявления */
'_pattern_all_photos' => '/<div class="photo-glow">.*?src="([^"]+)".*?<\/div>/s',
'url_phone' => 'https://www.olx.ua/ajax/misc/contact/phone/',

'_object_link' => '/<a href="([^"]+?)" class="[^"]+?linkWithHash detailsLink"/',
/* Неактивное объявление */
'_pattern_inactive_link' => '/<div[^>]*class\s*=\s*[\'"]content[\'"]\s*id\s*=\s*[\'"]offer_outdated[\'"][^>]*>/is',
'_pattern_404_link' => '/<div[^>]*id\s*=\s*[\'"]ad-not-available-box[\'"]\s*[^>]*>/is',
'_pattern_phone_field' => '/<ul[^>]*id\s*=\s*[\'"]contact_methods[\'"]\s*[^>]*>.*<div[^>]*class\s*=[\'"]contact-button\s*link-phone[^>]*>/is',
'_pattern_search_pt' => '/var phoneToken = \'([a-z0-9]+)\';/is',
//'_phone_normalise' => '/(^38)?(\d*)/'
'_phone_normalise' => '/(^38)?(^8)?(\d*)/'
];
