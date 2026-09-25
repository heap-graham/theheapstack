<?php

/*
 * OPW00 - MAIN
 * Main control program for The Owl & Pussycat World
 */

$debug = true;


/*
 * MAIN
 */

function main($debug)
{
    $opwRoot = __DIR__;
    $knownState = $opwRoot . '/opw.txt';

    /*
     * Check for existing known state
     */

    if (!file_exists($knownState)) {

        if ($debug) {
            echo "opw.txt not found - building OPW known state<br><br>";
        }

        /*
         * Explore OPW directories
         */

        $directories = exploreDirectories($opwRoot);

        /*
         * Write directory tree
         */

        writeKnownState($knownState, $directories);

        if ($debug) {
            echo "OPW directory tree written to opw.txt<br>";
        }

    } else {

        if ($debug) {
            echo "opw.txt found<br>";
        }
    }
}


/*
 * EXPLORE DIRECTORIES
 */

function exploreDirectories($directory)
{
    $directories = [];

    $items = scandir($directory);

    foreach ($items as $item) {

        if ($item === '.' || $item === '..') {
            continue;
        }

        $path = $directory . DIRECTORY_SEPARATOR . $item;

        if (is_dir($path)) {

            $directories[] = $path;

            /*
             * Explore subdirectories
             */

            $subdirectories = exploreDirectories($path);

            $directories = array_merge(
                $directories,
                $subdirectories
            );
        }
    }

    return $directories;
}


/*
 * WRITE KNOWN STATE
 */

function writeKnownState($filename, $directories)
{
    $output = "OPW DIRECTORY TREE\n";
    $output .= "==================\n\n";

    foreach ($directories as $directory) {
        $output .= $directory . "\n";
    }

    file_put_contents($filename, $output);
}


/*
 * START OPW
 */

main($debug);

?>