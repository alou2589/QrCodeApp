<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Service\QrCodeService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_default')]
    public function index(Request $request, QrCodeService $qr_code): Response
    {
        $qrCode=null;
        $form=$this->createForm(type:SearchType::class, data:null);
        $form->handleRequest($request);        
        if ($form->isSubmitted() && $form->isValid()) { 
            $data=$form->getData();
            $qrCode=$qr_code->qrcode($data['name']);
        }
        return $this->render('default/index.html.twig', [
            'form' => $form->createView(),
            'qrCode'=>$qrCode
        ]);
    }
}
