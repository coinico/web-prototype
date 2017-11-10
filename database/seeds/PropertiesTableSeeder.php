<?php

use Illuminate\Database\Seeder;

class PropertiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*for($i=1; $i<20; $i++) {
            $property = DB::table('properties')->find($i);
            $info = [
                'title' => 'Parsons Green',
                'user_id' => 1,
                'status_id' => 1,
                'description' => '',
                'detail' => '',
                'images' => '{}',
                'value' => '1000000',
                'location' => '{lat:33,lng:44}',
                'bidding_time' => 'taylor@example.com',
                'features' => 'taylor@example.com',
            ];
            if (!$property) {
                DB::table('properties')->insert($info);
            }else{
                DB::table('properties')
                    ->where('id', $i)
                    ->update($info);
            }
        }*/

        $properties = array(
            array(
                'title' => 'Montealina',
                'user_id' => 1,
                'status_id' => 1,
                'description' => 'Una de las mejores y lujosas mansiones de Madrid, en La Urbanización Montealina, con accesos de seguridad y vigiladas 24 horas...Espectacular mansión de 1016 mts, en 2.500 mts de parcela con jardines impecables, ascensor, pista de pádel y piscina privada. Urbanización vigilada y con seguridad. Salón principal con biblioteca y chimenea, Gran cocina con office, 7 dormitorios, 9 baños todos los dormitorios en suite, principal con chimenea, con 2 vestidores y 2 baños. Pub inglés en zona de ocio interior, gran gimnasio, sauna, zona de servicio, zona de lavado... Gran porche en jardín, Todas las habitaciones con grandes terrazas al jardín. Garaje exterior con zonas de aparcamiento. Barbacoa. Aire acondicionado centralizado en toda la casa. Sofisticado sistema de seguridad perimetral. Materiales y acabados de lujo, con mármol, maderas importadas, suelos de Tasso. Casa muy representativa con uno de los mejores precios de Montealina.',
                'detail' => '',
                'images' => '1.jpg',
                'value' => '2.600.000',
                'location' => '{lat:40.4435326,lng:-3.8402236}',
                'bidding_time' => '',
                'features' => '',
            ),
            array(
                'title' => 'La Moraleja',
                'user_id' => 1,
                'status_id' => 1,
                'description' => 'La vivienda está distribuida de la siguiente manera; planta principal con hall, amplio salón con 4 ambientes con acceso a porche cubierto, jardín, barbacoa y cenador. Gran cocina en isla con office, zona de lavado-planchado, dormitorio de servicio con baño. En zona privada se encuentra el dormitorio principal que consta de, salón con chimenea, amplio dormitorio con terraza, vestidor y cuarto de baño completo. En primera planta, 4 amplios dormitorios con terraza, vestidor y todos ellos con baño completo en suite, comparten una gran sala de estar con todas las comodidades. En planta baja, un gran salón de recreo con proyecto.',
                'detail' => '',
                'images' => '2.jpg',
                'value' => '4.900.000',
                'location' => '{lat:40.4435326,lng:-3.8402236}',
                'bidding_time' => '',
                'features' => '',
            ),
            array(
                'title' => 'Ribadesella',
                'user_id' => 1,
                'status_id' => 1,
                'description' => 'Magnífica finca de 44.500 m2, con 1323 m2 construidos y 2000 m2 más como suelo residencial para construir y ampliar instalaciones.La finca cuenta con una vivienda actualizada, restaurante, sala de fiestas y un antiguo molino harinero del Siglo XVIII.Construcciones actualizadas, reformadas y reforzadas para poder ofrecer la posibilidad de realizar multitud negocios, restauración, sala de fiestas, animales (núcleo zoológico), circuitos de aventuras, etc.Con fácil acceso por carretera asfaltada directa a la finca con gran zona de aparcamiento en el interior, con cabida para coches y autobuses. Tengas el proyecto que tengas, esta extraordinaria finca te ofrece todas las posibilidades para desarrollarlo, ya sea para uso residencial privado como para explotación de negocio.Características actuales:Vivienda con 6 habitacionesUn hogar de leña en el comedor principal.',
                'detail' => '',
                'images' => '3.jpg',
                'value' => '2.950.000',
                'location' => '{lat:40.4435326,lng:-3.8402236}',
                'bidding_time' => '',
                'features' => '',
            ),
            array(
                'title' => 'Las Matas',
                'user_id' => 1,
                'status_id' => 1,
                'description' => ' Gran diseño exterior e interior, seguridad y calidad de construcción. 1350 mts de casa en 3.900 mts de jardines impecables de diseño. Piscina desbordante exterior en gran porche con solarium y unas excelentes vistas. Piscina interior acristalada con vistas al salón y ventana a la sala de fiestas. Terraza chill out con grandes vistas. Gran salón en varios ambientes con vistas panoramicas y chimenea. Grandes espacios llenos de luz y techos muy altos. Casa domotizada con stores, ventanales electricos, sala de cine, gimnasio, cocina con isla central y zona de office. 5 habitaciones, 5 baños, 3 aseos, aseo de invitados de diseño de más de 25 mts, habitacion de servicio, 2 salones, comedor, discoteca con bar. Posibilidad de garita de seguridad. Alarma interior, perimetral, camaras de seguridad. Ultima tecnologia en seguridad con Alarma invisible en todas las entradas. garage con 3 entradas independientes. ',
                'detail' => '',
                'images' => '4.jpg',
                'value' => '2.950.000',
                'location' => '{lat:40.4435326,lng:-3.8402236}',
                'bidding_time' => '',
                'features' => '',
            ),
            array(
                'title' => 'Cangas de Onís',
                'user_id' => 1,
                'status_id' => 1,
                'description' => 'El edificio, de aspecto contemporáneo tiene una extensión de 645 m2 y se distribuye en tres plantas y planta sótano. Todo construido con los mejores materiales, de lujo. Para ello se utilizaron las mejores maderas en carpintería con tallas únicas como en la escalera, puerta principal y diversos paneles que decoran las paredes de las distintas habitaciones. Mármoles en sus baños y estucos en relieves. Dispone además de un moderno ascensor que recorre el edificio desde el sótano hasta la tercera planta.Las puertas son macizas de nogal negro seleccionado español, ventanas de pino tea con persianas eléctricas. Suelos de nogal negro seleccionado español y pino tea. Revestimiento de paredes de pino melis.En la planta sótano encontramos un amplísimo garaje y otras muchas dependencias: zona de juegos, trasteros, salas de calderas y herramientas y un apartamento para caseros con cocina, salón comedor, baño y habitación. También hay otros dormitorios para el servicio.En la planta baja se encuentran varios salones, un comedor, hall de entrada, despacho con salita de espera. Cocina muy grande y luminosa con despensa y zona de planchado. Baños y dormitorio.',
                'detail' => '',
                'images' => '5.jpg',
                'value' => '2.700.000',
                'location' => '{lat:40.4435326,lng:-3.8402236}',
                'bidding_time' => '',
                'features' => '',
            ),
            array(
                'title' => 'Finca',
                'user_id' => 1,
                'status_id' => 1,
                'description' => 'Finca compuesta por 3 plantas, la planta semisótano esta formada por una sala de conferencias y otra de usos múltiples, sala de espera, almacén, despacho y aseos. Planta baja; su forma es simétrica, se encuentra un amplio recibidor en el centro y desde aquí se distribuyen dos alas diferenciadas. En el ala izquierda se encuentra la zona de la cocina, con un almacén, lavadero, servicios, cámara frigorífica, una sala de estar y un amplio comedor. Esta misma a la presenta un pasillo de distribución donde se albergan 7 dormitorios con sus respectivos baños. En el ala derecha de forma simétrica se encuentra otro pasillo de distribución con 6 dormitorios con baño y un despacho. En este ala se encuentra la capilla, la sacristía y dos aseos. La capilla además de tener el acceso por el interior de la planta baja se puede acceder también por el exterior del edificio a través de un porche. Primera planta; en la parte central se encuentra una biblioteca, hay cuatro pasillos de distribución donde se albergan un total de 35 dormitorios con sus respectivos baños. ',
                'detail' => '',
                'images' => '6.jpg',
                'value' => '2.600.000',
                'location' => '{lat:40.4435326,lng:-3.8402236}',
                'bidding_time' => '',
                'features' => '',
            )
        );
        DB::table('properties')->insert($properties);
    }
}