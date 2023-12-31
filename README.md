# phpOpenAI

PHP OpenAI ChatGPT Class. 🚀 Native PHP, Zero dependencies. 

[OpenAPI.php](https://github.com/zonesql/phpopenai/blob/main/OpenAI.php)

## Overview

A PHP integration with OpenAI API (ChatGPT) allowing text completions and image generations. Easy & quick to implement, Pure PHP, no dependencies.

## Installation

Copy the class to your project, obtain your [API key](https://platform.openai.com/account/api-keys) and replace YOUR_API_KEY in the line below:

```
private const API_KEY = "YOUR_API_KEY";
```

## Usage


```
$ai = new OpenAI();
$response = $ai->generateTextFromPrompt('what did humpty dumpty sit on?');
echo "Response: " . $response['data'];
```

## Requirements

- PHP 7.4 or newer.
- cURL extension enabled.
- Valid OpenAI API key.
- Active internet connection to communicate with the OpenAI API.
- JSON extension (usually enabled by default in PHP installations).

## Licensing

See LICENCE file for details.

## Author

Adam Tandowski

## Links

- Tando: https://tando.net
- GitHub User: https://github.com/zonesql
- GitHub Repo: https://github.com/zonesql/phpopenai
- OpenAI: https://openai.com
- OpenAI API Info: https://openai.com/product
- OpenAI Keys Page: https://platform.openai.com/account/api-keys
