<?php 
namespace Entegrations\CheckIdentity;

use SoapClient;

class CheckIdentityEntegration
{
    public static function Check(string $identity,string $name,string $surname,int $birthOfDate):bool
    {
        $veriler = array(
          'TCKimlikNo' => $identity,
          'Ad' => $name,
          'Soyad' => $surname,
          'DogumYili' => $birthOfDate
        );
        
        $baglan = new SoapClient("https://tckimlik.nvi.gov.tr/Service/KPSPublic.asmx?WSDL");
        $sonuc = $baglan -> TCKimlikNoDogrula ($veriler);
        print_r($sonuc);
        return $sonuc->TCKimlikNoDogrulaResult;
    }
}
