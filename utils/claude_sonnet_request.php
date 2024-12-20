<?php

function send_antrophic_request($prompt) {

    $env = parse_ini_file('.env');

    $apiKey =  $env["CLAUDE_SONNET_API_KEY"];
    $url = 'https://api.anthropic.com/v1/messages/batches';

    // Build the JSON payload for a single prompt
    $data = [
        "requests" => [
            [
                "custom_id" => "single-prompt",
                "params" => [
                    "model" => "claude-3-5-haiku-20241022",
                    "max_tokens" => 100,
                    "messages" => [
                        ["role" => "user", "content" => $prompt]
                    ]
                ]
            ]
        ]
    ];

    // Initialize cURL
    $ch = curl_init($url);

    // Set the cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'anthropic-version: 2023-06-01',
        'x-api-key: ' . $apiKey,
        'anthropic-beta: message-batches-2024-09-24'
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    // Execute the request
    $response = curl_exec($ch);

    // Check for errors
    if (curl_errno($ch)) {
        echo 'Error: ' . curl_error($ch);
        return null;
    } else {
        // Decode and return the response
        $decodedResponse = json_decode($response, true);
        curl_close($ch);
        return $decodedResponse;
    }

    // Close cURL session
    curl_close($ch);
}

// Example usage
$prompt = "Hey Claude, tell me a short fun fact about video games!";
$response = send_antrophic_request($prompt);
print_r($response);
?>
