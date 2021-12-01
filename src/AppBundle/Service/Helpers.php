<?php

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\Request;

class Helpers
{
    /**
     * @param Request $request
     * @return object
     */
    public function decodeParams(Request $request){
        $json = $request->get("json", null);
        $params = json_decode($json);

        return $params;
    }

    /**
    * @return void
    */
    public function sendNotificationByMail(){
        try {
            $to = "mail@mail.com";
            $subject = "New association player club";
            $message = "New association player club";
            $headers = "From: mi@cuentadeemail.com" . "\r\n" . "CC: destinatarioencopia@email.com";
     
            mail($to, $subject, $message, $headers);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function sendNotificationBySms(){
        //TODO: Add SMS Logic for future
    }

    public function sendNotificationByWhatsapp(){
        //TODO: Add Whatsapp Logic for future
    }
}