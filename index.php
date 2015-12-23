<?php

	$url = 'http://forum.<url>.ru/feed/rss.xml?show=5';
	// если нужна сортировка по последнему посту добавляем &sort=last_post 

	if(curl_init($url) !== false) {

		$ch = curl_init($url); //инициализация сеанса

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // возвращаем результат, а не выводим его

		curl_setopt($ch, CURLOPT_TIMEOUT, 3); // устанавливаем таймаут

		$xmlstr = curl_exec($ch); // загрузка страницы

		curl_close($ch); // завершение сеанса и освобождение ресурсов

		$rss = @simplexml_load_string($xmlstr);//интерпретируем XML-файл в объект

		
		echo '<p>Последние темы на форуме:</p>';

		// проверяем, что файл загрузился
		if($rss !== false ) {

			$str = '-new-posts'; // лишние символы в url

			foreach ($rss->channel->item as $item) { //цикл для обхода всей RSS ленты

					$link = strip_tags($item->link);

					// делаем ссылку правильной
					$linkEnd = strpos($link, $str);

					// проверяем наличие в ссылке доп. элемента str
					if($linkEnd != 0) {
						$newlink = substr($link, 0, $linkEnd) . '.html';
					} else {
						$newlink = $link;
					}

					echo '<ul>';
					echo '<li><a href="' . $newlink  . '">' . strip_tags($item->title) . '</a></li>';
					echo '</ul>';
			}

		}


	}

?>
