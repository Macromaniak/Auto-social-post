<?php
require WP_AUTO_SOCIAL_DIR . 'vendor/autoload.php';

use Coderjerk\BirdElephant\BirdElephant;
use GuzzleHttp\Exception\RequestException;

class TwitterBot
{
    private $twitter;

    public function __construct($config)
    {
        $this->twitter = new BirdElephant($config);
    }

    private function uploadMedia($filePath)
    {
        $image = $this->twitter->tweets()->upload($filePath);
        if (isset($image->media_id_string)) {
            return $image->media_id_string;
        } else {
            throw new Exception("Media upload failed: " . json_encode($image));
        }
    }

    public function tweet($text, $imagePaths = [])
    {
        error_log('Tweet method called'); // Debug log
        $mediaIds = [];

        foreach ($imagePaths as $filePath) {
            $localPath = $_SERVER['DOCUMENT_ROOT'] . parse_url($filePath, PHP_URL_PATH);
            if (file_exists($localPath)) {
                error_log('Uploading media: ' . $localPath); // Debug log
                $mediaIds[] = $this->uploadMedia($localPath);
            } else {
                throw new Exception("File not found: $localPath");
            }
        }

        $tweetData = (new \Coderjerk\BirdElephant\Compose\Tweet)->text($text);

        if (!empty($mediaIds)) {
            $media = (new \Coderjerk\BirdElephant\Compose\Media)->mediaIds($mediaIds);
            $tweetData->media($media);
        }

        try {
            error_log('Sending tweet'); // Debug log
            $response = $this->twitter->tweets()->tweet($tweetData);
            return $response;
        } catch (RequestException $e) {
            // Handle Guzzle request exceptions
            $statusCode = $e->getResponse()->getStatusCode();
            $errorMessage = $e->getMessage();
            throw new Exception("Request failed with status code $statusCode: $errorMessage");
        } catch (Exception $e) {
            // Handle other exceptions
            throw new Exception("Tweet failed: " . $e->getMessage());
        }
    }
}
