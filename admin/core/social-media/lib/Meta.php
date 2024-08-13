
<?php
require 'vendor/autoload.php'; // Include Guzzle

use GuzzleHttp\Client;

// Instantiate Guzzle client
$client = new Client([
  'base_uri' => 'https://graph.facebook.com/v19.0/', // adjust version number as needed
]);

$access_token = 'EAAhCZBoUAFPABOwdjTDw0rJNQUsS9vw9tRC5qBRjuKysPFYOaPZAUPfPUWZCUV3sVNmqZB4fJ8ZATNr8odk3wNFGXJbD27EVZCIMLPG2HGTEFaV7lKT1Hl2FgNfCtCUSyIKwPsDnIySJoVhZAf62pyZCz1auQQMdKxCJuqwDqoiIs75ZBA3w1oWfzrsjxTYF9xjfY3lZCXyhFAgXqFxFPtyqhYVC0etwZDZD';

$ig_user_id = 'anandhun391'; // Replace this with the Instagram user ID

// Step 1: Create Container

// Define parameters for creating the container
$params = [
  'image_url' => 'https://vistaranews.com/wp-content/uploads/2023/08/Maine-Coon-Cat.webp',
  'caption' => 'Hi My Cat',
  'access_token' => $access_token,
];

try {
  // Make POST request to create the container
  $response = $client->post($ig_user_id . '/media', [
    'form_params' => $params,
  ]);

  // Handle response
  $container_data = json_decode($response->getBody(), true);
  // $container_data will contain the response from Instagram API after creating the container

  // Step 2: Publish Container

  // Extract creation_id from the container response
  $creation_id = $container_data['id']; // Assuming the response contains the creation ID

  // Make POST request to publish the container
  $publish_params = [
    'creation_id' => $creation_id,
    'access_token' => $access_token,
  ];

  // Make POST request to publish the container
  $publish_response = $client->post($ig_user_id . '/media_publish', [
    'form_params' => $publish_params,
  ]);

  // Handle publish response
  $publish_data = json_decode($publish_response->getBody(), true);
  // $publish_data will contain the response from Instagram API after publishing the media

  // Handle the response data as needed
  if (isset($publish_data['id'])) {
    echo "Media posted successfully!";
  } else {
    echo "Failed to post media.";
  }
} catch (Exception $e) {
  echo "Error: " . $e->getMessage();
}
