<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConferenceController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(Request $request)
    {
        $message = "";
        $name = $request->query->get('hello');
        if($name) {
            $message = "Hello " . htmlspecialchars($name);
        }
        return new Response(<<<EOF
        <html>
            <body>
                <h1>$message</h1>
                <img src="/images/under-construction.gif" />
            </body>
        </html>
EOF
        );
    }
}
