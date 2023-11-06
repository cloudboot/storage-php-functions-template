<?php
use CloudEvents\V1\CloudEventInterface;
use Google\CloudFunctions\FunctionsFramework;

// Register the function with Functions Framework.
// This enables omitting the `FUNCTIONS_SIGNATURE_TYPE=cloudevent` environment
// variable when deploying. The `FUNCTION_TARGET` environment variable should
// match the first parameter.
FunctionsFramework::cloudEvent('main', 'main');

function main(CloudEventInterface $cloudevent)
{
  $log = fopen(getenv('LOGGER_OUTPUT') ?: 'php://stderr', 'wb');
  $data = $cloudevent->getData();
  fwrite($log, 'Event: ' . $cloudevent->getId() . PHP_EOL);
  fwrite($log, 'Event Type: ' . $cloudevent->getType() . PHP_EOL);
  fwrite($log, 'Bucket: ' . $data['bucket'] . PHP_EOL);
  fwrite($log, 'File: ' . $data['name'] . PHP_EOL);
  fwrite($log, 'Metageneration: ' . $data['metageneration'] . PHP_EOL);
  fwrite($log, 'Created: ' . $data['timeCreated'] . PHP_EOL);
  fwrite($log, 'Updated: ' . $data['updated'] . PHP_EOL);
}
