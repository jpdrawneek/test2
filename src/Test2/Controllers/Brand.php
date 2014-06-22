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
        $paginationFlag = FALSE;
        if ($result['count'] > 1) {
            if ($result['count'] > 10) {
                $count = 10;
                $paginationFlag = TRUE;
            } else {
                $count = $result['count'];
            }
            $result['blocklist'] = array_merge($result['blocklist'], $this->app['ION']->paginate($count, $parts, $query)['blocklist']);
        }
        $output = array();
        foreach ($result['blocklist'] AS $item) {
            if (strpos($item['brand_title'], $query) !== FALSE) {
                $output[] = $item;
            }
        }
        return $app['twig']->render('brand_list.twig', array('programs' => $output, 'pagination' => $paginationFlag));
    }
    
    public function stripOtherBrands($blocklist, $query) {
        $output = array();
        foreach ($blocklist AS $item) {
            if (strpos($item['brand_title'], $query) !== FALSE) {
                $output[] = $item;
            }
        }
        return $output;
    }
    
    
}
