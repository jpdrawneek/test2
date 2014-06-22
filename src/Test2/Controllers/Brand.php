<?php
/**
 * @copywright jpdrawneek
 * @author John-Paul Drawneek <jpd@drawneek.co.uk>
 */
namespace Test2\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class Brand {
    /** @var Silex\Application */
    protected $app;

    public function search(Request $request, Application $app) {
        $this->app = $app;
        $query = $request->attributes->get('search');
        $parts = array(
          'search_availability' => 'iplayer',
        );
        $result = $this->app['ION']->search($parts, $query);
        return $app['twig']->render('brand_list.twig', array('programs' => $result['blocklist']));
    }
}
