<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('getColor')) {
    /**
     * Get the content of a file.
     *
     * @param  string  $file
     * @param  string|null  $disk
     * @return string|false
     */
    function getColor($colors)
    {
        $stockColors = [
            '#1f77b4', // blue
            '#ff7f0e', // orange
            '#2ca02c', // green
            '#d62728', // red
            '#9467bd', // purple
            '#8c564b', // brown
            '#e377c2', // pink
            '#7f7f7f', // gray
            '#bcbd22', // yellow-green
            '#17becf', // cyan
            '#1a9850', // green
            '#66bd63', // green
            '#a6d96a', // green
            '#d9ef8b', // yellow-green
            '#fdae61', // orange
            '#f46d43', // orange
            '#d73027', // red
            '#a50026', // red
            '#ffeda0', // yellow
            '#737373', // gray
        ];

        $uniqueColors = [];

        // Iterate over each color in $colors
        foreach ($colors as $color) {
            // Check if the color exists in $stockColors and is not already added to $uniqueColors
            if (in_array($color, $stockColors) && !in_array($color, $uniqueColors)) {
                return $color; // Add the unique color to $uniqueColors
            }
        }

    }
}
