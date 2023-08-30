<?php
/** 
 * phpOpenAI 
 * 
 * A quick, easy integration with OpenAI API (ChatGPT) allowing for 
 * both text completions and image generations.
 * 
 * Usage:
 * <code>
 * $ai = new OpenAI();
 * $text = $ai->generateTextFromPrompt('what did humpty dumpty sit on?');
 * echo "Text: " . $text['data'];
 * </code>
 *
 * Requirements:
 * - PHP 7.4 or newer.
 * - cURL extension enabled.
 * - Valid OpenAI API key. (Paste into API_KEY const value)
 * - Active internet connection to communicate with the OpenAI API.
 * - JSON extension (usually enabled by default in PHP installations).
 * 
 * @author Adam Tandowski
 * @link https://www.tando.net
 * @version 1.0.0
 * @package phpOpenAI
 */

/**
 * Class OpenAI
 *
 * This class provides methods to interact with the OpenAI API for generating text and images.
 */
class OpenAI
{
    private const API_KEY = "YOUR_API_KEY";
    private const TEXT_URL = "https://api.openai.com/v1/completions";
    private const IMAGE_URL = "https://api.openai.com/v1/images/generations";

    /** @var \CurlHandle cURL session handle. */
    private $curl;

    /**
     * OpenAI constructor.
     *
     * Initializes a cURL session.
     *
     * @throws Exception if the cURL library is not enabled.
     */
    public function __construct()
    {
        if (!extension_loaded('curl')) {
            throw new Exception('cURL library is not enabled.');
        }

        $this->curl = curl_init();
    }

    /**
     * Sets up the cURL session for the given request type.
     *
     * @param string $requestType Type of the request ('image' or 'text').
     */
    private function setupCurlSession(string $requestType): void
    {
        curl_reset($this->curl);

        $url = ($requestType === 'image') ? self::IMAGE_URL : self::TEXT_URL;

        curl_setopt_array($this->curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "Authorization: Bearer " . self::API_KEY
            ]
        ]);
    }

    /**
     * Generates text based on the given prompt.
     *
     * @param string $prompt      The input text to guide the output.
     * @param string $model       OpenAI model used for text generation.
     * @param float  $temperature Determines randomness of output (0.0 to 1.0).
     * @param int    $maxTokens   Maximum number of tokens in the response.
     *
     * @return array Contains the generated text and any errors encountered.
     */
    public function generateTextFromPrompt(string $prompt, string $model = 'text-davinci-003', float $temperature = 0.7, int $maxTokens = 1000): array
    {
        $this->setupCurlSession('text');

        $data = [
            "model" => $model,
            "prompt" => $prompt,
            "temperature" => $temperature,
            "max_tokens" => $maxTokens
        ];

        curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($this->curl);
        $responseArray = json_decode($response, true);

        return [
            'data' => $responseArray['choices'][0]['text'] ?? null,
            'error' => $responseArray['error']['code'] ?? null
        ];
    }

    /**
     * Generates image URL based on the given prompt.
     *
     * @param string $prompt       The input text to guide the image generation.
     * @param string $imageSize    Desired dimensions of the generated image.
     * @param int    $numberOfImages Number of images to be generated.
     *
     * @return array Contains the URL of the generated image(s) and any errors encountered.
     */
    public function generateImageUrlFromPrompt(string $prompt, string $imageSize = '512x512', int $numberOfImages = 1): array
    {
        $this->setupCurlSession('image');

        $data = [
            "prompt" => $prompt,
            "n" => $numberOfImages,
            "size" => $imageSize
        ];

        curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($this->curl);
        $responseArray = json_decode($response, true);

        return [
            'data' => $responseArray['data'][0]['url'] ?? null,
            'error' => $responseArray['error']['code'] ?? null
        ];
    }
}
