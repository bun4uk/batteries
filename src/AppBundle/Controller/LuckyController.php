<?php
// src/AppBundle/Controller/LuckyController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class LuckyController extends Controller
{
    /**
     * @Route("/lucky", name="lucky")
     */
    public function indexAction()
    {
//        throw $this->createNotFoundException('The product does not exist');
//        throw new \Exception('Something went wrong!');


        return new Response(
            'Lucky indexAction'
        );
    }

    /**
     * @Route("/lucky/number/{count}")
     */
    public function numberAction($count)
    {
        if (!$count) {
            $numbers = rand(0, 100);
        } else {
            for ($i = 0; $i < $count; $i++) {
                $numbers[] = rand(0, 100);
            }
        }

        $numbersList = implode(', ', $numbers);

        return $this->render(
            'lucky/number.html.twig',
            array('luckyNumberList' => $numbersList)
        );
    }

    /**
     * @Route("/api/lucky/number")
     */
    public function apiNumberAction()
    {
        $data = [
            'lucky_number' => rand(0, 100)
        ];

        return new JsonResponse($data);
    }

    /**
     * @Route("/lucky/notice/{notice}")
     */
    public function noticeAction($notice = 'This is test notice!')
    {

        $this->addFlash(
            'notice',
            $notice
        );

        return $this->render(
            'lucky/notice.html.twig',
            array('notice' => $notice)
        );
    }




    // Controller forwarding Start
    /**
     * @Route("/lucky/forward/{name}/{color}")
     */
    public function forwardInAction($name = 'testName', $color = 'red')
    {
        $response = $this->forward('AppBundle:Lucky:forwardOut', array(
            'name' => $name,
            'color' => $color,
        ));
        return $response;
    }


    public function forwardOutAction($name, $color)
    {
        return new Response("
        {$name}  it's name <br>
        {$color} it's color
        ");
    }
    // Controller forwarding End
}