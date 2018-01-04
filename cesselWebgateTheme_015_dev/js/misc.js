$(document).ready(function()
	{
        mapInit("#map");
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