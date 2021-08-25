<?php
    function geo_object_query($geocode, $kind)
    {
        $http_parameters = [
            'apikey' => 'api',
            'geocode' => $geocode,
            'format' => 'json'
        ];
        if(isset($kind))
        {
            $http_parameters += ['kind' => $kind];
        }
        $response = file_get_contents('https://geocode-maps.yandex.ru/1.x/?'. http_build_query($http_parameters));
        $object = json_decode($response, true);
        $contents = $object['response']['GeoObjectCollection']['featureMember'];
        if(count($contents) > 0)
        {
            return $contents[0]['GeoObject'];
        }
        else {
            return NULL;
        }
    }

    if(isset($_POST["input_address"]))
    {
        $main_object = geo_object_query($_POST['input_address'], NULL); //GeoObject по искомому адресу
        $main_object_address = $main_object['metaDataProperty']['GeocoderMetaData']['Address']; //достаем адрес из GeoObject
        $coordinates = str_replace(" ", ",", $main_object['Point']['pos']); //координаты искомого адреса
        $metro_object = geo_object_query($coordinates, 'metro'); //GeoObject метро
        $coordinates = explode(',', $coordinates); //преобразуем строку координат в массив

        $result = [
            'zip_code' => $main_object_address['postal_code'],
            'country' => "",
            'province' => "",
            'locality' => "",
            'street' => "",
            'house' => "",
            'longtitude' => $coordinates[0],
            'latitude' => $coordinates[1],
        ];

        $address_components = ['country', 'province', 'locality', 'street', 'house'];

        foreach($main_object_address['Components'] as $value)
        {
            if(in_array($value['kind'], $address_components))
            {
                $result[$value['kind']] = $value['name'];
            }
        }

        $result += (isset($metro_object)) ? ['metro' => $metro_object['name']] : ['metro' => 'Отсутствует'];
        
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
?>