<?php
/**
 * @copywright jpdrawneek
 * @author John-Paul Drawneek <jpd@drawneek.co.uk>
 */
namespace Test2\Services;



class ION {
    const url = "http://www.bbc.co.uk/iplayer/ion/searchextended/format/json/";
    
    /** @var GuzzleHttp\Client */
    protected $client;

    public function __construct($client) {
        $this->client = $client;
    }
    
    public function search(Array $parts, $query) {
        $res = $this->client->get($this->buildUrl($parts, $query));
        
        //echo $res->getStatusCode();           // validate this
        return $res->json();
    }
    
    public function buildUrl(Array $parts, $query = NULL) {
        $output = '';
        if (isset($parts['page']) && is_int($parts['page'])) {
            $output .= 'page/' . $parts['page'] . '/';
        }
        if (isset($parts['search_availability'])) {
            $val = $this->validateSearchAvailability($parts['search_availability']);
            if ($val) {
                $output .= $val;
            } else {
                throw new \RuntimeException('search_availability missing');
            }
        }
        if (isset($query)) {
            $output .= 'q/' . $query;
        }
        return self::url . $output;
    }
    
    public function validateSearchAvailability($value) {
        $list = array('iplayer', 'any', 'discoverable', 'ondemand', 'simulcast', 'comingup');
        $value = strtolower($value);
        if (in_array($value, $list)) {
            return 'search_availability/' . $value . '/';
        } else {
            return FALSE;
        }
    }
}

