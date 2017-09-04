<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 9/11/16
 * Time: 5:07 PM
 */

namespace UserBundle\Util;


use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Request;
class CommonFunctions
{
    public function randomCompanyId(){
        $digits = 3;
        $randomnumber=str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
        return 'companyId'.$randomnumber;
    }
    function random_password( $length = 8 ) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        $password = substr( str_shuffle( $chars ), 0, $length );
        return $password;
    }
    /**
     * Set base HTTP headers.
     *
     * @param Response $response
     *
     * @return Response
     */
    public function setBaseHeaders(Response $response)
    {
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }
    /**
     * Data serializing via JMS serializer.
     *
     * @param mixed $data
     *
     * @return string JSON string
     */
    public function serialize($data)
    {
        $context = new SerializationContext();
        $context->setSerializeNull(true);

        return $this->get('jms_serializer')
            ->serialize($data, 'json', $context);
    }
    public function find_options_ComparsionRule($option_Parameter,$dbvalue,$option_Parmeter_Value)
    {
        if($option_Parameter=='=') {
            if($dbvalue==$option_Parmeter_Value)
            {
                return true;
            }
            else
            {
                return false;
            }
        } else if($option_Parameter=='>') {
            if($dbvalue>$option_Parmeter_Value)
            {
                return true;
            }
            else
            {
                return false;
            }
        } else if($option_Parameter=='<') {
            if($dbvalue<$option_Parmeter_Value)
            {
                return true;
            }
            else
            {
                return false;
            }
        } else if($option_Parameter=='>=') {
            if($dbvalue>=$option_Parmeter_Value)
            {
                return true;
            }
            else
            {
                return false;
            }
        } else if($option_Parameter=='<=') {
            if($dbvalue<=$option_Parmeter_Value)
            {
                return true;
            }
            else
            {
                return false;
            }
        } else {
            if($dbvalue>=$option_Parmeter_Value)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
    public function find_Avg_Sum_Calculation($string_value_avg_or_sum,$elementvalue,$totalnumberships_inserted)
    {
        if($string_value_avg_or_sum == "Average") {
            return $elementvalue / $totalnumberships_inserted;
        } else if($string_value_avg_or_sum == "Sum") {
            return $elementvalue;
        }
        else {
            return $elementvalue / $totalnumberships_inserted;
        }
    }

}