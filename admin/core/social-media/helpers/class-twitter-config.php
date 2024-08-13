<?php

if (!defined('ABSPATH')) {
  exit;
}

class TwitterPost {
  private $options = array();
  private $apiCreds =  [
        'bearer_token' => '',
        'consumer_key' => '',
        'consumer_secret' => '',
        'token_identifier' => '',
        'token_secret' => '',
  ];

  function __construct() {
    $this->setUpApiCreds();
  }

  function setUpApiCreds() {
    $this->options = get_option(WPASP_OPTIONS_NAME);

    $this->apiCreds['bearer_token'] = $this->options['wpasp_social_twitter_bearer_token'];
    $this->apiCreds['consumer_key'] = $this->options['wpasp_social_twitter_api_key'];
    $this->apiCreds['consumer_secret'] = $this->options['wpasp_social_twitter_api_secret'];
    $this->apiCreds['token_identifier'] = $this->options['wpasp_social_twitter_access_token'];
    $this->apiCreds['token_secret'] = $this->options['wpasp_social_twitter_access_secret'];
  }

  function getApiConfig() {
    return $this->apiCreds;
  }

}