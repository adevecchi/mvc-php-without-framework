<?php

namespace Application\Services;

use Application\Helpers\Json;

class TempConvert
{
    private const WDSL = 'https://www.w3schools.com/xml/tempconvert.asmx?WSDL';

    public static function get(string $grau, float $temperatura) : string
    {
        switch ($grau) {
            case 'celsius':
                return self::celsiusToFahrenheit($temperatura);
            case 'fahrenheit':
                return self::fahrenheitToCelsius($temperatura);
            default:
                return Json::encode(['error'=>true,'status'=>'failure','content'=>"Temperatura informada $to inválida"]);
        }
    }

    private static function celsiusToFahrenheit(float $celsius) : string
    {
        try {
            if (!self::hasSoapExtension()) {
                throw new \Exception('The "soap" module must be enabled in your PHP installation.');
            }

            $soapClient = self::createSoapClient();

            $fahr = $soapClient->CelsiusToFahrenheit(['Celsius' => $celsius]);

            return Json::encode([
                'error' => false, 
                'status' => 'success',
                'content' => floatval(sprintf("%.2f", $fahr->CelsiusToFahrenheitResult))
            ]);
        }
        catch (\Exception $ex) {
            return Json::encode([
                'error' => true, 
                'status' => 'failure', 
                'content' => $ex->getMessage()
            ]);
        }
    }

    private static function fahrenheitToCelsius(float $fahrenheit) : string
    {
        try {
            if (!self::hasSoapExtension()) {
                throw new \Exception('The "soap" module must be enabled in your PHP installation.');
            }

            $soapClient = self::createSoapClient();

            $fahr = $soapClient->FahrenheitToCelsius(['Fahrenheit' => $fahrenheit]);
            
            return Json::encode([
                'error' => false, 
                'status' => 'success', 
                'content'=> floatval(sprintf("%.2f", $fahr->FahrenheitToCelsiusResult))
            ]);
        }
        catch (\Exception $ex) {
            return Json::encode([
                'error' => true, 
                'status' => 'failure', 
                'content' => $ex->getMessage()
            ]);
        }
    }

    private static function createSoapClient() : \SoapClient
    {
        return new \SoapClient(self::WDSL, ['exceptions' => true]);
    }

    private static function hasSoapExtension() : bool
    {
        if (!extension_loaded('soap'))
            return false;

        return true;
    }
}
