<?php
namespace App\Classe;


use Mailjet\Client;
use Mailjet\Resources;

class Mail {

private $api_key= 'b0e614344570ee742e17008181bcd14f';
private $api_key_secret='d6167f919580dcf4f5396a9c412578bd';

public function send($to_email, $to_name, $subjet, $content){


      $mj= new Client($this->api_key, $this->api_key_secret,true,['version' => 'v3.1']);

    $body = [
        'Messages' => [
            [
                'From' => [
                    'Email' => "norelonamboua20@gmail.com",
                    'Name' => "la boutique francaise de geoffroy"
                ],
                'To' => [
                    [
                        'Email' => "$to_email",
                        'Name' => "$to_name"
                    ]
                ],
                'TemplateID' => 3775760,
                'TemplateLanguage' => true,
                'Subject' => "$subjet",
                 'variables'=>[
                     'content'=> $content

                 ]





            ]
        ]
    ];
    $response = $mj->post(Resources::$Email, ['body' => $body]);
    $response->success() ;
    //&& dd($response->getData());
}




}


