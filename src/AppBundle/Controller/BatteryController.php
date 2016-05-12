<?php
/**
 * Created by PhpStorm.
 * User: v.bunchuk
 * Date: 10/05/2016
 * Time: 13:23
 */

// src/AppBundle/Controller/BatteryController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\Type\BatteryType;
use AppBundle\Entity\Battery;

class BatteryController extends Controller
{
    /**
     * @Route("/battery",
     *     name="battery home")
     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository('AppBundle:Battery');
        $query = $repository->createQueryBuilder('b')
            ->select('b.type as b_type', 'SUM(b.count) as b_count')
            ->groupBy('b.type')
            ->getQuery();
        $batteries = $query->getResult();

        return $this->render('battery/archive.html.twig',
            ['batteries' => $batteries]
        );
    }

    /**
     * @Route("/battery/add", name="add battery")
     */
    public function addAction(Request $request)
    {

        $battery = new Battery();
        $form = $this->createForm(BatteryType::class, $battery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($battery);
            $em->flush();
            return $this->redirectToRoute('battery home');
        }

        return $this->render('battery/add.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}