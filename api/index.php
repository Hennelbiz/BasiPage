<?php
    /* ------------------------------------------------- */
    /* ::::::::::::: PROTOTIPO DE API REST ::::::::::::: */
    /* ------------------------------------------------- */

    /* ENCABEZADOS DE ACCESO Y METODOS ACEPTABLES */
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: X-Requested-With');
    header('Content-Type: text/html; charset=utf-8');
    header('P3P: CP="IDC DSP COR CURa ADMa OUR IND PHY ONL COM STA"');

    /* INCLUCION DE TODOS LOS ARCHIVOS EN SERVICIOS */
    foreach(glob('servicios/*.php') as $file) {
        require_once strval($file);
    }

    /* SELECCION DE METODO DE ACCESO */
    if(!isset($_GET['PATH_INFO'])) {
        http_response_code(404);
        echo 'Entrada de Url NO válida';
    } else {
        $path_info = explode('/', strval($_GET['PATH_INFO']));
        $servicio = strtolower($path_info[0]);
        $funcion = strtolower($path_info[1]);
        $params;
        switch($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $params = $_GET;
            break;
            case 'POST':
                $params = json_decode(file_get_contents('php://input'), true);
            break;
            case 'PUT':
                echo 'Usaste Metodo Put';
            break;
            case 'DELETE':
                echo 'Usaste Metodo Delete';
            break;
            default:
                http_response_code(404);
                echo 'Método NO permitido o Invalido';
            break;
        }
        if(isset($params)) {
             try {
                call_user_func(array($servicio, $funcion), $params);
             } catch(Exception $e) {
                http_response_code(404);
                return $e->getMessage();
             }
        }
    }
?>