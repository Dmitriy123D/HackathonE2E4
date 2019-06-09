ymaps.ready(init);
var usluga = $("#usluga").val()
function init () {
    var myMap = new ymaps.Map('map', {
            center: [47.236727, 39.764285],
            zoom: 11
        }, {
            searchControlProvider: 'yandex#search'
        }),
        objectManager = new ymaps.ObjectManager({
            // Чтобы метки начали кластеризоваться, выставляем опцию.
            clusterize: true,
            // ObjectManager принимает те же опции, что и кластеризатор.
            gridSize: 32,
            clusterDisableClickZoom: true
        });

    // Чтобы задать опции одиночным объектам и кластерам,
    // обратимся к дочерним коллекциям ObjectManager.
    objectManager.objects.options.set('preset', 'islands#greenDotIcon');
    objectManager.clusters.options.set('preset', 'islands#greenClusterIcons');
    myMap.geoObjects.add(objectManager);

console.log (usluga);
    $.ajax({
		    url: "uslugi_map.php?usluga=" + usluga
    }).done(function(data) {
        objectManager.add(data);
    });

}