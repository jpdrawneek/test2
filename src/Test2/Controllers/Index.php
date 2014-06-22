<?php
/**
 * @copywright jpdrawneek
 * @author John-Paul Drawneek <jpd@drawneek.co.uk>
 */
namespace Test2\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class Index {
    /** @var Silex\Application */
    protected $app;

    public function index(Request $request, Application $app) {
        $data = array();

        $form = $app['form.factory']->createBuilder('form', $data)
            ->add('brand')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();

            return $app->redirect('brands/' . $data['brand']);
        }
        return $app['twig']->render('index.twig', array('form' => $form->createView()));
    }
}
