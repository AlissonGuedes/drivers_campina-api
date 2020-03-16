<?php

namespace App\Controllers
{

    class Accounts extends AppController
    {
        public function __construct()
        {
            $this -> user_model = new \App\Models\UserModel();
            $this -> user = new \App\Entities\User();
        }

        public function index()
        {
            
        }

        /**
         * Verificar o login e senha e, caso estejam corretos,
         * realiza a autenticação do usuário no sistema
         */
        public function auth()
        {
           
            $data = [];
            $post = file_get_contents('php://input');
            $post = json_decode($post);

            $login = isset($post -> login) ? $post -> login : null;
            $senha = isset($post -> senha) ? $post -> senha : null;
            $bd_pass = null;

            if ( $login )
            {
                if ( !empty($login))
                {

                    $user = $this -> user_model -> getLogin($login);

                    if ( $user )
                    {

                        $data['user']['usrId']= $user -> id;
                        $data['user']['name'] = $user -> nome;
                        $data['user']['photo'] = $user -> imagem;

                        $data['status'] = 'success';

                        $db_pass = $user -> senha;

                    }
                    else
                    {
                        $data = array(
                            'status' => '401',
                            'msg'    => 'Usuário Inválido'
                        );
                    }

                } 
                else
                {
                    $data = ['status'=>'error', 'msg' => 'Login obrigatório'];
                }

            }

            if ( $senha )
            {

                if ( ! empty($senha) )
                {

                    $pass = hashCode($senha);

                    if ( $pass === $db_pass )
                    {

                        $data['sessionId'] = hashCode(implode('', $data['user']) . time());
                        $data['status'] = 'success';
                        $data['msg']    = null;
                    }
                    else
                    {
                        $data['status'] = '401';
                        $data['msg']    = 'Senha Inválida';
                    }
                }

            }

            echo json_encode($data);

        }

        public function logout()
        {
            $this -> session -> remove(USERDATA);
            location(base_url());
        }
    }

}
