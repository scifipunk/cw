let center = [55.73, 37.75];

function init() {
    let map = new ymaps.Map('map-test', {
        center: center,
        zoom: 20
    });

    let placemark = new ymaps.Placemark([55.73, 37.75], {}, {
        iconLayout: 'default#image',
        iconImageHref: 'https://image.flaticon.com/icons/png/512/64/64113.png',
        iconImageSize: [40, 40],
        iconImageOffset: [-19, -44]
    });
     myGeoObject = new ymaps.GeoObject({
        geometry: {
            type: "Point",
            coordinates: [55.8, 37.8]
        },

        properties: {
            
            iconContent: 'Я тащусь',
            hintContent: 'Ну давай уже тащи'
        }
    }, {
        
        preset: 'islands#blackStretchyIcon',
        
        draggable: true
    })
    map.controls.remove('geolocationControl'); // удаляем геолокацию
    map.controls.remove('searchControl'); // удаляем поиск
    map.controls.remove('trafficControl'); // удаляем контроль трафика
    map.controls.remove('typeSelector'); // удаляем тип
    map.controls.remove('fullscreenControl'); // удаляем кнопку перехода в полноэкранный режим
    map.controls.remove('rulerControl'); // удаляем контрол правил
    map.behaviors.disable(['scrollZoom']); // отключаем скролл карты (опционально)
    myMap.geoObjects.add(myGeoObject);
    map.geoObjects.add(placemark);
}

ymaps.ready(init);