<?php

namespace AppBundle\Controller;

use AppBundle\Service\PlatformService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
	//php bin/console server:run
	
    /**
     * @Route("/", name="home")
     */
    public function indexAction(PlatformService $platformService)
    {
        $message = $platformService->getRandomMessage();
        return $this->render('home/index.html.twig', [
            'message' => $message,
        ]);
    }
}
