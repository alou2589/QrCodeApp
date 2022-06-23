<?php

namespace App\Service;

use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;

class QrCodeService
{
    protected $builder;

    public function __construct(BuilderInterface $builder)
    {
        $this->builder=$builder;
    }

    public function qrcode($recherche, $code)
    {
        $url='https://3b4e-41-214-50-12.eu.ngrok.io/info/';
        $path= dirname(__DIR__,2).'/public/assets/';
        $result=$this->builder
        ->data($url.$recherche)
        ->encoding(new Encoding('UTF-8'))
        ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
        ->size(400)
        ->margin(10)
        ->backgroundColor(new Color(239, 155, 15))
        ->logoPath($path.'/img/logo-mcpme.png')
        ->logoResizeToHeight(100)
        ->logoResizeToWidth(100)
        ->build()
        ;
        $namePng=$code.'.png';
        $result->saveToFile($path.'/qrcodes/'.$namePng);
        return $result->getDataUri();
    }
}
