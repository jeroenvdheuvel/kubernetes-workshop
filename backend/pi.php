<?php

$numberOfIterations = $_GET['iterations'] ?? 0;

if ($numberOfIterations <= 0) {
    http_response_code(400);
    return;
}

$calculatePiCallable = function () use ($numberOfIterations, &$pi) {
    $pi = calculatePi($numberOfIterations);
};

$executionTime = measureExecutionTimeInMicroSeconds($calculatePiCallable);
header(sprintf('Server-Timing: pi;desc="Calculate pi";dur=%f', $executionTime));
echo $pi;

function calculatePi(int $numberOfIterations)
{
    $pi = 0;
    $top = 4.0;

    for ($i= 1; $i<=$numberOfIterations; ++$i){
        $bottom = $i * 2 - 1;

        if ($i % 2 === 1) {
            $pi += $top / $bottom;
        } else {
            $pi -= $top / $bottom;
        }
    }

    return $pi;
}

function measureExecutionTimeInMicroSeconds (callable $callable) : float
{
    $startTime = microtime(true);

    $callable();

    return microtime(true) - $startTime;
}
