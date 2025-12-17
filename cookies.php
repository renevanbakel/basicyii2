<?php

declare(strict_types=1);

$startTime = microtime(true);

const TOTAL_TEASPOONS = 100;

$ingredients = [
    "Sprinkles" => [
        "capacity"   =>  2,
        "durability" =>  0,
        "flavor"     => -2,
        "texture"    =>  0,
        "calories"   =>  3,
    ],
    "Butterscotch" => [
        "capacity"   =>  0,
        "durability" =>  5,
        "flavor"     => -3,
        "texture"    =>  0,
        "calories"   =>  3,
    ],
    "Chocolate" => [
        "capacity"   =>  0,
        "durability" =>  0,
        "flavor"     =>  5,
        "texture"    => -1,
        "calories"   =>  8,
    ],
    "Candy" => [
        "capacity"   =>  0,
        "durability" => -1,
        "flavor"     =>  0,
        "texture"    =>  5,
        "calories"   =>  8,
    ],
];

function calculateScore(array $ingredients, array $amounts): array
{
    $totalCapacity   = 0;
    $totalDurability = 0;
    $totalFlavor     = 0;
    $totalTexture    = 0;
    $totalCalories   = 0;

    $index = 0;
    
    foreach ($ingredients as $property) {
        $amount = $amounts[$index];
        $totalCapacity   += $amount * $property["capacity"];
        $totalDurability += $amount * $property["durability"];
        $totalFlavor     += $amount * $property["flavor"];
        $totalTexture    += $amount * $property["texture"];
        $totalCalories   += $amount * $property["calories"];
        $index++;
    }

    // Negative totals become zero
    $totalCapacity   = max(0, $totalCapacity);
    $totalDurability = max(0, $totalDurability);
    $totalFlavor     = max(0, $totalFlavor);
    $totalTexture    = max(0, $totalTexture);

    $score = $totalCapacity * $totalDurability * $totalFlavor * $totalTexture;

    return [$score, $totalCalories];
}

// Main
$bestScore = 0;
$bestScore500 = 0;

foreach (range(0, TOTAL_TEASPOONS) as $a) {
    foreach (range(0, TOTAL_TEASPOONS - $a) as $b) {
        foreach (range(0, TOTAL_TEASPOONS - $a - $b) as $c) {
            $d = TOTAL_TEASPOONS - $a - $b - $c;

            $amounts = [$a, $b, $c, $d];

            [$score, $calories] = calculateScore($ingredients, $amounts);

            if ($score > $bestScore) {
                $bestScore = $score;
            }

            // Bonus points! :-D
            if ($calories === 500 && $score > $bestScore500) {
                $bestScore500 = $score;
            }
        }
    }
}

// Output
echo "Highest score (no calorie restriction): " . $bestScore . PHP_EOL;
echo "Highest score (exactly 500 calories): " . $bestScore500 . PHP_EOL;
echo "Time taken: " . (microtime(true) - $startTime) * 1000 . " ms." . PHP_EOL;

// Output on Rene's computer
//  Highest score (no calorie restriction): 21367368
//  Highest score (exactly 500 calories): 1766400
//  Time taken: 101.94993019104 ms.