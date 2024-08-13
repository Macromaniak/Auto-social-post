<?php
class SocialMediaManager
{
    private $socialMediaBots = [];

    public function __construct()
    {
        $this->initializeBots();
    }

    private function initializeBots()
    {
        // Initialize TwitterBot with configuration
        $twitterConfig = new TwitterPost();
        $twitterApiConfig = $twitterConfig->getApiConfig();
        $this->socialMediaBots['twitter'] = new TwitterBot($twitterApiConfig);

        // Add initialization for other social media bots here
    }

    public function post($platform, $text, $imagePaths = [])
    {
        error_log("Posting to platform: $platform"); // Debug log
        if (isset($this->socialMediaBots[$platform])) {
            error_log('Tweeting...!'); // Debug log
            return $this->socialMediaBots[$platform]->tweet($text, $imagePaths);
        } else {
            error_log('Error tweet! Unsupported platform: ' . $platform); // Debug log
            throw new Exception("Unsupported platform: $platform");
        }
    }
}
