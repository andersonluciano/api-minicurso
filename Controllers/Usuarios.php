<?php

/**
 * Description of Usuarios
 *
 * @author anderson
 */
class Usuarios {

    public $bodyParams;
    public $urlParams;

    public function get($id = null) {

        if ($id != null) {
            
        } else {

            if (array_key_exists('nick', $this->urlParams)) {

                //Momento de fazer um select para buscar o usuário solicitado
                //...
                //
                return array("nome" => "Anderson", "nick" => "anderson", "id" => "512");
            } else {
                throw new Exception('Nickname ou Id do Usuário é obrigatŕio');
            }
        }
    }

    public function post() {
        print_r($this->bodyParams);exit;
    }

    public function put() {
        
    }

    //Futuramente esses métodos podem virar uma Abstract...    
    public function getBodyParams() {
        return $this->bodyParams;
    }

    public function getUrlParams() {
        return $this->urlParams;
    }

    public function setBodyParams($bodyParams) {
        $this->bodyParams = $bodyParams;
    }

    public function setUrlParams($urlParams) {
        $this->urlParams = $urlParams;
    }

}
