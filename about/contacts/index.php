<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Задайте вопрос");
?><div class="row">
	<div class="col-xs-12">
		<p>
 <b>Телефон:</b> 8 (495)&nbsp;287&nbsp;41&nbsp;00<br>
 <b>Адрес:</b> г. Москва, Волоколамское ш., д. 97
		</p>
		 <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2240.8328204917157!2d37.40012799999999!3d55.830861000000006!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNTXCsDQ5JzUxLjEiTiAzN8KwMjQnMDAuNSJF!5e0!3m2!1sen!2sru!4v1443089996268&hl=ru-RU" width="640" height="490" frameborder="0" style="border:0" allowfullscreen></iframe><br>
 <small><a href="https://maps.google.com/maps?ll=55.830506,37.399742&z=16&t=m&hl=ru-RU&gl=RU&mapclient=embed&q=%D0%92%D0%BE%D0%BB%D0%BE%D0%BA%D0%BE%D0%BB%D0%B0%D0%BC%D1%81%D0%BA%D0%BE%D0%B5%20%D1%88%D0%BE%D1%81%D1%81%D0%B5%2C%2097" style="color:#0000FF;text-align:left" target="_blank">Просмотреть увеличенную карту</a></small>
		<h2>Задать вопрос</h2>
		 <?$APPLICATION->IncludeComponent(
	"bitrix:main.feedback",
	"eshop_adapt",
	Array(
		"USE_CAPTCHA" => "Y",
		"OK_TEXT" => "Спасибо, ваше сообщение принято.",
		"EMAIL_TO" => "sale@nyuta.bx",
		"REQUIRED_FIELDS" => array(),
		"EVENT_MESSAGE_ID" => array()
	)
);?>
	</div>
</div>
 <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>