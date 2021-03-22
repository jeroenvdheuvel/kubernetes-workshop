<!DOCTYPE html>
<html lang="en">
<head>
    <meta charSet="utf-8"/>
    <title>PI calculator</title>
</head>
<body>
<h1>PI calculator</h1>
<?php if (($_GET['iterations'] ?? 0) > 0) : ?>
    <?php
    $pi = 0.0;

    $calculatePiCallable = function () use (&$pi) {
        $pi = calculatePi($_GET['iterations']);
    };

    $executionTime = measureExecutionTimeInMicroSeconds($calculatePiCallable);
    ?>
    <p>
        Calculated PI: <strong><?= $pi; ?></strong>
        by iterating <strong><?= $_GET['iterations'] ?></strong> times
        in <strong><?= intval($executionTime * 1000000) ?></strong> microseconds.
    </p>
<?php else : ?>
    <form>
        <label for="iterations">Number of iterations to calculate PI</label>
        <input id="iterations" name="iterations" type="number" min="0" max="<?= PHP_INT_MAX ?>" step="1" value="<?= getenv('ITERATIONS') ?>" />
        <button type="submit">Submit</button>
    </form>
<?php endif; ?>
</body>
</html>
<?php

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
