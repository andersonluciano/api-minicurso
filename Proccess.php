<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Proccess
 *
 * @author anderson
 */
class Proccess {

    public function run($url, $method = 'GET') {

        //Tratar url
        $urlExplode = explode('/', $url);

        #limpa espaços brancos
        $urlAux = array();
        foreach ($urlExplode as $value) {
            if (trim($value) != "") {
                $urlAux[] = $value;
            }
        }
        $urlExplode = $urlAux;

        if (count($urlExplode) >= 1) {
            $className = ucfirst($urlExplode[0]);
            if (class_exists($className)) {
                $controller = new $className();
                $methods = get_class_methods($controller);

                if (in_array($method, $methods)) {
                    switch ($method) {
                        case 'get':
                            $urlParams = $this->proccessUrlParams($urlExplode);
                            if (array_key_exists('id', $urlParams)) {
                                $controller->setUrlParams($urlParams);
                                $res = $controller->get($urlParams['id']);
                            } else {
                                $controller->setUrlParams($urlParams);
                                $res = $controller->get();
                            }
                            return $res;
                            
                            break;
                        case 'post':

                            $controller->setBodyParams($this->getBodyParams());
                            $ret = $controller->post();
                            return $res;
                            break;
                        case 'put':
                            $urlParams = $this->proccessUrlParams($urlExplode);
                            $controller->setBodyParams($this->getBodyParams());
                            if (array_key_exists('id', $urlParams)) {
                                $controller->setUrlParams($urlParams);
                                $res = $controller->put($urlParams['id']);
                            } else {
                                $controller->setUrlParams($urlParams);
                                $res = $controller->put();
                            }

                            return $res;
                            break;
                        case 'delete':
                            $urlParams = $this->proccessUrlParams($urlExplode);
                            if (array_key_exists('id', $urlParams)) {
                                $controller->setUrlParams($urlParams);
                                $res = $controller->delete($urlParams['id']);
                            } else {
                                $controller->setUrlParams($urlParams);
                                $res = $controller->delete();
                            }

                            return $res;
                            break;

                        default:
                            break;
                    }
                } else {
                    http_response_code(404);
                    throw new \Exception("Método não permitido para a rota: " . $url);
                }

                print_r($methods);
                exit;
            } else {
                http_response_code(404);
                throw new \Exception("Nenhuma rota encontrada");
            }
        } else {
            http_response_code(404);
            throw new \Exception("Nenhuma rota encontrada");
        }
    }

    public function getBodyParams() {


        $text = file_get_contents('php://input');
        if ($text != "") {
            $body = json_decode($text,true);
        } else {
            $body = array();
        }

        return $body;
    }

    public function proccessUrlParams($urlExplode) {
        //Retira a primeira posição do array que no caso é o endereço -> Ex: {/usuario}/{nick}/{chavesdobarril}

        array_shift($urlExplode);
        $params = array();
        //Se houver parametros pares eu uso {chave}/{valor }
        //Senão o primeiro é o ID e os proximos chave e valor {id}/{chave}/{valor}
        if (count($urlExplode) % 2 == 0) {
            for ($i = 0; $i < count($urlExplode); $i+=2) {
                $params[$urlExplode[$i]] = $urlExplode[$i + 1];
            }
        } else {
            $params['id'] = array_shift($urlExplode);
            for ($i = 0; $i < count($urlExplode); $i+=2) {
                $params[$urlExplode[$i]] = $urlExplode[$i + 1];
            }
        }
        return $params;
    }

}
