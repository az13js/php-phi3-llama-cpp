<?php
require_once __DIR__ . '/vendor/autoload.php';

$systemPrompt = "You can engage in discussions on any topic, you can assist with "
. "anything. Your answer should be logical. Consider potential individuals or "
. "objects involved that not mentioned in question, vague expression and "
. "ambiguity of the problem. Analyze every aspect of the problem, explain each "
. "step according to the problem logic, identify the key or doubtful points of "
. "the problem, raise the question, and answer it step by step. If you discover a "
. "contradiction, you should point it out. You also should think about "
. "is there any contradiction or unreasonable aspects in your answer. If you find "
. "anything else that helps solve the problem, you should also speak up.";

$userPrompt = 'Who am I?';
echo runModel($userPrompt, $systemPrompt);
