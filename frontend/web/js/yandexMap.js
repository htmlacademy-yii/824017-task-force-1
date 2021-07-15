ymaps.ready(init);

function init() {
    var myMap = new ymaps.Map("map", {
        center: [latitude, longitude],
        zoom: 17
    }, {
        searchControlProvider: 'yandex#search'
    });

    myMap.geoObjects.add(new ymaps.Placemark([latitude, longitude], {}, {
        preset: 'islands#redIcon'
    }));
}
