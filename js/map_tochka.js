$(function(){

	ymaps.ready(init);
	var coord1 = $("#coord1").val()
	var coord2 = $("#coord2").val()
	var name_uchr = $("#name_uchr").val()
	var address_uchr = $("#address_uchr").val()
function init() {
    var myMap = new ymaps.Map("map", {
	center: [coord1, coord2],
            zoom: 17
        }, {
            searchControlProvider: 'yandex#search'
        });

    // Создаем многоугольник, используя класс GeoObject.
    var myGeoObject = new ymaps.GeoObject();

    // Добавляем многоугольник на карту.
    myMap.geoObjects.add(myGeoObject);

    myMap.geoObjects
        .add(new ymaps.Placemark([coord1, coord2], {
            balloonContent: name_uchr + '<br>ул.' + address_uchr,
            iconCaption: name_uchr
        }, {
            preset: 'islands#icon',
            iconColor: '#0095b6'
        }))

}


});