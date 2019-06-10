$(document).ready(function()
	{
        setTimeout(function()
        {
            var preloader = $(".preloader");
            preloader.fadeOut();
        },500);
		
        $(".hamburger").click(function(){
            $(".hamburger").toggleClass("is-active");
            $('.mobile__menu').toggleClass("show");

        });
	});
























//Переменная для включения/отключения индикатора загрузки
var spinner = $('.ymap-container').children('.loader');
//Переменная для определения была ли хоть раз загружена Яндекс.Карта (чтобы избежать повторной загрузки при наведении)
var check_if_load = false;
//Необходимые переменные для того, чтобы задать координаты на Яндекс.Карте
var myMapTemp, myPlacemarkTemp;

//Функция создания карты сайта и затем вставки ее в блок с идентификатором &#34;map-yandex&#34;
function init () {
    var map_id = 'map-yandex';
    var lattitude = $("#" + map_id).data('lat');
    var longtitude = $("#" + map_id).data('long');
    var siteName = $("#" + map_id).data('sitename');
    var adress = $("#" + map_id).data('adress');

	if (lattitude == undefined || longtitude == undefined || lattitude == '' || longtitude == '')
		{
			lattitude = '45.031903';
			longtitude = '38.918908';
		}
	if (adress == undefined || adress == '' )
		{
			adress = 'г. Краснодар, проспект Чекистов, 40';
		}
	
    var myMapTemp = new ymaps.Map(map_id, {
        center: [lattitude, longtitude], // координаты центра на карте
        zoom: 15, // коэффициент приближения карты
        controls: ['zoomControl', 'fullscreenControl'] // выбираем только те функции, которые необходимы при использовании
    });
    var myPlacemark = new ymaps.Placemark([lattitude,longtitude],{hintContent: siteName,balloonContent: siteName + " - " + adress});
    myMapTemp.geoObjects.add(myPlacemark);

    // Получаем первый экземпляр коллекции слоев, потом первый слой коллекции
    var layer = myMapTemp.layers.get(0).get(0);

    // Решение по callback-у для определения полной загрузки карты
    waitForTilesLoad(layer).then(function() {
        // Скрываем индикатор загрузки после полной загрузки карты
        var spinner = $('.ymap-container').children('.loader');
        spinner.removeClass('is-active');
    });
}

// Функция для определения полной загрузки карты (на самом деле проверяется загрузка тайлов)
function waitForTilesLoad(layer) {
    return new ymaps.vow.Promise(function (resolve, reject) {
        var tc = getTileContainer(layer), readyAll = true;
        tc.tiles.each(function (tile, number) {
            if (!tile.isReady()) {
                readyAll = false;
            }
        });
        if (readyAll) {
            resolve();
        } else {
            tc.events.once("ready", function() {
                resolve();
            });
        }
    });
}

function getTileContainer(layer) {
    for (var k in layer) {
        if (layer.hasOwnProperty(k)) {
            if (
                layer[k] instanceof ymaps.layer.tileContainer.CanvasContainer
                || layer[k] instanceof ymaps.layer.tileContainer.DomContainer
            ) {
                return layer[k];
            }
        }
    }
    return null;
}

// Функция загрузки API Яндекс.Карт по требованию (в нашем случае при наведении)
function loadScript(url, callback){
    var script = document.createElement("script");

    if (script.readyState){  // IE
        script.onreadystatechange = function(){
            if (script.readyState == "loaded" ||
                script.readyState == "complete"){
                script.onreadystatechange = null;
                callback();
            }
        };
    } else {  // Другие браузеры
        script.onload = function(){
            callback();
        };
    }

    script.src = url;
    document.getElementsByTagName("head")[0].appendChild(script);
}

// Основная функция, которая проверяет когда мы навели на блок с классом &#34;ymap-container&#34;
var ymap = function() {
    $('.ymap-container').mouseenter(function(){
            if (!check_if_load) { // проверяем первый ли раз загружается Яндекс.Карта, если да, то загружаем

                // Чтобы не было повторной загрузки карты, мы изменяем значение переменной
                check_if_load = true;

                // Показываем индикатор загрузки до тех пор, пока карта не загрузится
                var spinner = $('.ymap-container').children('.loader');
                spinner.addClass('is-active');

                // Загружаем API Яндекс.Карт
                loadScript("https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;loadByRequire=1", function(){
                    // Как только API Яндекс.Карт загрузились, сразу формируем карту и помещаем в блок с идентификатором &#34;map-yandex&#34;
                    ymaps.load(init);
                });
            }
        }
    );
}

$(function() {

    //Запускаем основную функцию
    ymap();

});



function mapInit(selector)
    {
        ymaps.ready(init);
        var myMap,
            myPlacemark;
        var adress = $(selector).data('adress');
        var siteName = $(selector).data('sitename');
        if(siteName == undefined || siteName == '' )
            {
                siteName = 'Сайт созданный в Cessel\'s WEBGae Studio';
            }
        function init()
        {
            ymaps.geocode(adress).then(function (res)
            {
                var position = res.geoObjects.get(0).geometry.getCoordinates();
                myMap = new ymaps.Map('map',{center: position,zoom : 14 });
                var myPlacemark = new ymaps.Placemark(position,{hintContent: siteName,balloonContent: siteName + " - " + adress});
                myMap.geoObjects.add(myPlacemark);
            });

        }
    }