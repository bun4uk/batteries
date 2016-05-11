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
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\Battery;

class BatteryController extends Controller
{
    /**
     * @Route("/battery/{productId}",
     *     defaults={"productId"=1},
     *     requirements={"productId": "\d+"},
     *     name="battery")
     */
    public function indexAction($productId)
    {
        $repository = $this->getDoctrine()
            ->getRepository('AppBundle:Battery');
        $query = $repository->createQueryBuilder('b')
            ->select('b.type as b_type', 'SUM(b.count) as b_count')
            ->groupBy('b.type')
            ->getQuery();
        $batteries = $query->getResult();
        


        return $this->render('battery/archive.html.twig',
            [
                'batteries' => $batteries
            ]
        );
    }

    /**
     * @Route("/battery/add", name="add battery")
     */
    public function addAction(Request $request)
    {

        $battery = new Battery();
        $form = $this->createFormBuilder($battery)
            ->add('type', TextType::class)
            ->add('count', IntegerType::class)
            ->add('name', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Drop the batteries'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($battery);
            $em->flush();

            return $this->redirectToRoute('battery');
        }

        return $this->render('battery/add.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}