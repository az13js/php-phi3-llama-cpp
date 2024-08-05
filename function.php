<?php

function runModel(string $userPrompt, string $systemPrompt = ''): string 
{

    $eol = PHP_EOL;
    $prompt="<|system|>${eol}${systemPrompt}<|end|>${eol}<|user|>${eol}${userPrompt}<|end|>${eol}<|assistant|>${eol}";

    $executableFilePath = getenv('PCLOCAL_LLAMA_EXE');
    $modelFilePath = getenv('PCLOCAL_LLAMA_MODEL');
    $numberThreadInRuntime = getenv('PCLOCAL_LLAMA_THREAD');

    $command = [
        $executableFilePath,
        '-m', $modelFilePath,
        '-t', $numberThreadInRuntime,
        '-p', $prompt,
        '--log-disable',
        '--no-display-prompt',
    ];

    $tmpFileOut = '.runModel.out.txt';
    $tmpFileErr = '.runModel.err.txt';

    if (false === ($processResource = proc_open(
        $command,
        [['pipe', 'r'], ['file', $tmpFileOut, 'wb'], ['file', $tmpFileErr, 'wb']],
        $pipes
    ))) {
        fwrite(STDERR, 'Fail.' . PHP_EOL);
        exit(1);
    }

    $status = ['running' => true];
    do {
        if ($status['running']) {
            sleep(1);
        }
        $status = proc_get_status($processResource);
    } while ($status['running']);

    proc_close($processResource);

    $result = file_get_contents($tmpFileOut);
    $begig = 0;
    $end = strrpos($result, '<|end|>', $begig === false ? 0 : $begig);

    $returnValue = '';

    if (false === $begig || false === $end) {
        $returnValue = '';
    } else {
        $returnValue = substr($result, $begig, $end);
    }

    unlink($tmpFileOut);
    unlink($tmpFileErr);

    return trim($returnValue);
}
