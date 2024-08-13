<?php

require 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class LinkedInClient
{
  private $clientId;
  private $clientSecret;
  private $redirectUri;
  private $authUrl = 'https://www.linkedin.com/oauth/v2/authorization';
  private $tokenUrl = 'https://www.linkedin.com/oauth/v2/accessToken';
  private $refreshTokenUrl = 'https://www.linkedin.com/oauth/v2/accessToken';
  //private $scopes = 'r_liteprofile r_emailaddress w_member_social';
  private $scopes;
  private $credentialsFile = 'credentials.json';
  private $client;
  private $apiUrl = 'https://api.linkedin.com/v2';

  public function __construct()
  {
    $this->clientId = getenv('LINKEDIN_CLIENT_ID');
    $this->clientSecret = getenv('LINKEDIN_CLIENT_SECRET');
    $this->redirectUri = getenv('SITE_URL') . getenv('LINKEDIN_REDIRECT_URI');
    $this->scopes = getenv('LINKEDIN_SCOPES');
    $this->client = new Client();
  }

  /**
   *  Create OAuth 2.0 authorization URL
   */

  public function getAuthorizationUrl()
  {
    session_start();
    $state = bin2hex(random_bytes(16)); // Generate a random state parameter for security
    $_SESSION['oauth2state'] = $state; // Store the state in the session for later verification

    $params = [
      'response_type' => 'code',
      'client_id' => $this->clientId,
      'redirect_uri' => $this->redirectUri,
      'state' => $state,
      'scope' => $this->scopes,
    ];

    $url = $this->authUrl . '?' . http_build_query($params);

    // Example URL (commented out)
    // https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id={CLIENT_ID}&redirect_uri={REDIRECT_URI}&state={STATE}&scope=r_liteprofile r_emailaddress w_member_social

    return $url;
  }

  /**
   * 
   * Handle redirect, capture the authorization code and state, then get access token
   * 
   */

  public function handleRedirect()
  {
    session_start();

    if (isset($_GET['code']) && isset($_GET['state'])) {
      $authorizationCode = $_GET['code'];
      $state = $_GET['state'];

      // Verify state parameter for security
      if ($state !== $_SESSION['oauth2state']) {
        throw new Exception('Invalid state parameter');
      }

      // Unset the stored state to prevent replay attacks
      unset($_SESSION['oauth2state']);

      // Get access token using the authorization code
      return $this->getAccessToken($authorizationCode);
    }

    throw new Exception('Authorization code or state missing');
  }

  /**
   * 
   * Exchange authorization code for access token and store it
   * 
   */

  private function getAccessToken($authorizationCode)
  {
    try {
      $response = $this->client->post($this->tokenUrl, [
        'form_params' => [
          'grant_type' => 'authorization_code',
          'code' => $authorizationCode,
          'redirect_uri' => $this->redirectUri,
          'client_id' => $this->clientId,
          'client_secret' => $this->clientSecret,
        ],
      ]);

      $data = json_decode($response->getBody(), true);
      $this->storeCredentials($data);

      return $data['access_token'];
    } catch (RequestException $e) {
      $this->handleError($e);
    }
  }

  /**
   * 
   * Refresh access token
   * 
   */
  private function refreshAccessToken()
  {
    $credentials = $this->loadCredentials();
    $refreshToken = $credentials['refresh_token'];

    try {
      $response = $this->client->post($this->refreshTokenUrl, [
        'form_params' => [
          'grant_type' => 'refresh_token',
          'refresh_token' => $refreshToken,
          'client_id' => $this->clientId,
          'client_secret' => $this->clientSecret,
        ],
      ]);

      $data = json_decode($response->getBody(), true);
      $this->storeCredentials($data);

      return $data['access_token'];
    } catch (RequestException $e) {
      $this->handleError($e);
    }
  }

  /**
   * 
   * Authenticate API requests
   * 
   */
  public function apiRequest($endpoint, $method = 'GET', $body = null)
  {
    $credentials = $this->loadCredentials();
    $accessToken = $credentials['access_token'];
    $expiresAt = $credentials['expires_at'];

    // Check if the access token is expired
    if (time() >= $expiresAt) {
      $accessToken = $this->refreshAccessToken();
    }

    try {
      $options = [
        'headers' => [
          'Authorization' => 'Bearer ' . $accessToken,
          'Content-Type' => 'application/json',
        ],
      ];

      if ($body) {
        $options['body'] = json_encode($body);
      }

      $response = $this->client->request($method, $this->apiUrl . $endpoint, $options);

      return json_decode($response->getBody(), true);
    } catch (RequestException $e) {
      $this->handleError($e);
    }
  }

  /**
   * 
   * Store credentials in a JSON file
   */
  private function storeCredentials($data)
  {
    // Calculate the expiration time
    $data['expires_at'] = time() + $data['expires_in'];
    file_put_contents($this->credentialsFile, json_encode($data));
  }

  /**
   * Load credentials from the JSON file
   */
  private function loadCredentials()
  {
    if (!file_exists($this->credentialsFile)) {
      throw new Exception('Credentials file not found');
    }

    return json_decode(file_get_contents($this->credentialsFile), true);
  }

  /**
   * 
   * Handle errors the api errors
   */
  private function handleError(RequestException $e)
  {
    $response = $e->getResponse();
    $statusCode = $response ? $response->getStatusCode() : 'No response';
    $body = $response ? $response->getBody() : 'No response body';

    switch ($statusCode) {
      case 400:
        $this->handle400Error($body);
        break;
      case 401:
        throw new Exception("Unauthorized: $body");
      case 403:
        throw new Exception("Access Denied: $body");
      case 404:
        throw new Exception("Resource Not Found: $body");
      case 405:
        throw new Exception("Method Not Allowed: $body");
      case 411:
        throw new Exception("Length Required: $body");
      case 429:
        throw new Exception("Rate Limit Exceeded: $body");
      case 500:
        throw new Exception("Internal Server Error: $body");
      case 504:
        throw new Exception("Gateway Timeout: $body");
      default:
        throw new Exception("HTTP error: $statusCode\nBody: $body");
    }
  }


  /**
   * 
   * Get the 404 error messages using error message code
   */
  private function handle400Error($body)
  {
    $errorMessages = [
      "authorization code not found" => "Authorization code sent is invalid or not found. Check whether the sent authorization code is valid.",
      'redirect_uri is missing' => 'Redirect_uri in the request is missing. It is a mandatory parameter. Pass the redirect_uri in the request to route the user back to the correct landing page.',
      'code is missing' => 'Authorization code in the request is missing. It is a mandatory parameter. Pass the Authorization code received as part of the authorization API call.',
      'grant_type is missing' => 'Grant type in the request is missing. It is a mandatory parameter. Add grant_type as "authorization_code" in the request.',
      'client_id is missing' => 'Client ID in the request is missing. It is a mandatory parameter. Pass the client id of the app in the request.',
      'client_secret is missing' => 'Client Secret in the request is missing. It is a mandatory parameter. Pass the client secret of the app in the request.',
      'redirect uri/code verifier does not match authorization code' => 'Invalid redirect uri is passed in the request. Pass the right redirect uri tagged to the developer application.',
      'authorization code expired' => 'Authorization code expired. Re-authenticate the member to generate a new authorization code and pass the fresh authorization code to exchange for an access token.',
    ];

    foreach ($errorMessages as $key => $message) {
      if (strpos($body, $key) !== false) {
        throw new Exception($message);
      }
    }

    throw new Exception("Unknown error: $body");
  }
}

// Example usage
$linkedinClient = new LinkedInClient();
echo "Authorization URL: " . $linkedinClient->getAuthorizationUrl();

// On your redirect URI page, you would call:
// session_start(); // Ensure session is started
// $linkedinClient = new LinkedInClient();
// $accessToken = $linkedinClient->handleRedirect();
// $response = $linkedinClient->apiRequest('/me');
