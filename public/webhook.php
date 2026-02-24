<?php
// webhook.php - GitHub webhook listener
$secret = 'MOHAB';

// Navigate to the correct project directory
$projectRoot = dirname(__DIR__) . "/portfolio";
$deployScript = $projectRoot . "/deploy.sh";

// More reliable way to get headers
function getRequestHeader($name) {
    $name = strtoupper(str_replace('-', '_', $name));
    if (isset($_SERVER['HTTP_' . $name])) {
        return $_SERVER['HTTP_' . $name];
    }
    return null;
}

// Get signature from headers
$signature = getRequestHeader('X-Hub-Signature-256');
if (!$signature) {
    http_response_code(400);
    echo 'No signature found';
    exit;
}

// Get request body
$payload = file_get_contents('php://input');

// Verify signature
$hash = 'sha256=' . hash_hmac('sha256', $payload, $secret);
if (!hash_equals($hash, $signature)) {
    error_log("Expected: " . $hash);
    error_log("Received: " . $signature);

    http_response_code(403);
    echo 'Invalid signature';
    exit;
}

// Check event type
$event = getRequestHeader('X-GitHub-Event');
if ($event !== 'push') {
    http_response_code(400);
    echo 'Event not supported';
    exit;
}

// Verify script exists
if (!file_exists($deployScript)) {
    error_log("Deploy script not found at: " . $deployScript);
    http_response_code(500);
    echo 'Error: Deploy script not found';
    exit;
}

// Execute deployment using proc_open (since exec/shell_exec are disabled)
$descriptorspec = array(
    0 => array("pipe", "r"),  // stdin
    1 => array("pipe", "w"),  // stdout
    2 => array("pipe", "w")   // stderr
);

$cmd = "cd " . escapeshellarg($projectRoot) . " && bash " . escapeshellarg($deployScript);
$process = proc_open($cmd, $descriptorspec, $pipes);

$output = '';
$returnCode = -1;

if (is_resource($process)) {
    // Close stdin
    fclose($pipes[0]);

    // Read stdout
    $output = stream_get_contents($pipes[1]);
    fclose($pipes[1]);

    // Read stderr
    $errors = stream_get_contents($pipes[2]);
    fclose($pipes[2]);

    // Get return code
    $returnCode = proc_close($process);

    // Combine output and errors
    $fullOutput = $output . "\n" . $errors;
} else {
    $fullOutput = "Failed to start process";
}

// Log the results
error_log("=== Deployment Log ===");
error_log("Project Root: " . $projectRoot);
error_log("Deploy Script: " . $deployScript);
error_log("Return Code: " . $returnCode);
error_log("Output: " . $fullOutput);

// Return appropriate HTTP status
if ($returnCode === 0) {
    http_response_code(200);
    echo 'Webhook received successfully - Deployment successful!';
} else {
    http_response_code(500);
    echo 'Webhook received - Deployment failed (check logs)';
    error_log("Deployment FAILED with return code: " . $returnCode);
}

