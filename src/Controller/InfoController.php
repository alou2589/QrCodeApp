<?php

namespace App\Controller;

use App\Entity\Info;
use App\Form\InfoType;
use App\Repository\InfoRepository;
use App\Service\QrCodeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/info')]
class InfoController extends AbstractController
{
    #[Route('/', name: 'app_info_index', methods: ['GET'])]
    public function index(InfoRepository $infoRepository): Response
    {
        return $this->render('info/index.html.twig', [
            'infos' => $infoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_info_new', methods: ['GET', 'POST'])]
    public function new(Request $request, InfoRepository $infoRepository, QrCodeService $qrcode): Response
    {
        $info = new Info();
        $form = $this->createForm(InfoType::class, $info);
        $form->handleRequest($request);
        $qr_code=null;
        if ($form->isSubmitted() && $form->isValid()) {            
            $info->setCreatedAt(new \DateTimeImmutable());
            $codeinfo= substr(uniqid($info->getNomInfo()),0,8);
            $info->setCodeInfo($codeinfo);
            $info->setQrInfo((string)$qr_code);
            $infoRepository->add($info, true);
            $qr_code=$qrcode->qrcode($info->getId(), $info->getCodeInfo());
            $info->setQrInfo((string)$qr_code);
            $infoRepository->add($info, true);
            return $this->redirectToRoute('app_info_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('info/new.html.twig', [
            'info' => $info,
            'form' => $form,
            'qrCode'=>$qr_code
        ]);
    }

    #[Route('/{id}', name: 'app_info_show', methods: ['GET'])]
    public function show(Info $info): Response
    {
        return $this->render('info/show.html.twig', [
            'info' => $info,
        ]);
    }

    #[Route('/{id}/showcode', name: 'app_info_showcode', methods: ['GET'])]
    public function showcode(Info $info): Response
    {
        return $this->render('info/showcode.html.twig', [
            'info' => $info,
        ]);
    }
    #[Route('/{id}/edit', name: 'app_info_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Info $info, InfoRepository $infoRepository): Response
    {
        $form = $this->createForm(InfoType::class, $info);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $infoRepository->add($info, true);

            return $this->redirectToRoute('app_info_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('info/edit.html.twig', [
            'info' => $info,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_info_delete', methods: ['POST'])]
    public function delete(Request $request, Info $info, InfoRepository $infoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$info->getId(), $request->request->get('_token'))) {
            $infoRepository->remove($info, true);
        }

        return $this->redirectToRoute('app_info_index', [], Response::HTTP_SEE_OTHER);
    }
}
