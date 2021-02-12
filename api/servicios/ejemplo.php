<?php
    Class ejemplo {
        const HASHSECURITY = '7L4L0c&%${}4P1';
        public static function login($params) {
            try {
                $usuario = $params['Usuario'];
                $password = $params['Password'];
                if($usuario == "honorato" && $password == "123") {
                    echo json_encode(true);
                } else {
                    echo json_encode(false);
                }
            } catch(Exception $e) {
                http_response_code(404);
                echo $e;
            }
        }

        public static function get($params) {
            try {
                if(intval($params['id']) > 0 && intval($params['id']) < 6) {
                    $juegos["1"] = "Dark Souls";
                    $juegos["2"] = "Grand Theft Auto";
                    $juegos["3"] = "God of War";
                    $juegos["4"] = "Gears of War";
                    $juegos["5"] = "Assassins Creed";
                    echo json_encode($juegos[$params['id']]);
                } else {
                    echo "No existe un elemento con ese id ".$params['id']." o el id es inválido...";
                }
            } catch(Exception $e) {
                http_response_code(404);
                echo $e->getMessage();
            }
        }

        public static function lista() {
            try {
                $post_array = array();
                $devs = array("Capcom", "Rockstar", "Santa Monica", "Konami", "Epic Games");
                $juegos = array("Resident Evil", "Grand Theft Auto", "God of War", "Silent Hill", "Gears of War");
                for($i = 0; $i < 5; $i++) {
                    $json_data = new stdClass();
                    $json_data->id_juego = $i + 1;
                    $json_data->nombre_juego = $juegos[$i];
                    $json_data->nombre_dev = $devs[$i];
                    array_push($post_array, $json_data);
                }
                echo json_encode($post_array);
            } catch(Exception $e) {
                http_response_code(404);
                echo $e->getMessage();
            }
        }

        public static function llamadoTlaloc($params_users) {
            try {
                $curl = curl_init();
  
                curl_setopt_array($curl, array(
                  CURLOPT_URL => 'https://tlaloc-dev.bdscorpnet.mx/token',
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'POST',
                  CURLOPT_POSTFIELDS => 'grant_type=password&username='.$params_users['Usuario'].'&password='.$params_users['Password'],
                  CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/x-www-form-urlencoded'
                  ),
                ));
                $response = curl_exec($curl);
                
                curl_close($curl);
                echo $response;
              } catch(Exception $e) {
                  echo $e->getMessage();
              }
        }
    }
?>