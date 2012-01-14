<?php

require_once 'lib/base.php';

// Set up
F3::clear('TEST');
F3::mock('GET /');

F3::call('index.php'); // Our test fixture will run in a sandbox

echo "<hr>Test<hr>";
// This is where the tests begin
F3::expect(F3::get('RESPONSE'),'Passed','Failed: No response');
F3::expect('{{is_string(@RESPONSE)}}','OK','Failed: Not a string');
F3::expect('{{strlen(@RESPONSE)<120}}','Great!','Failed: Too long');
F3::expect('{{!@ERROR}}','Done','Failed: An error occurred');

// Display the results of each test
$passed = 0; $failed = 0;

foreach (F3::get('TEST') as $test) {
	echo $test['text'].'<br/>';
	if ($test['result'])
		$passed++;
	else
		$failed++;
}
echo '<br/>';

// If you have no need for detailed messages, you can do this:
// rotate TEST array variable so rows become columns, and vice-versa
F3::set('TEST',Matrix::transpose(F3::get('TEST')));
// then, distribute the number of passed/failed tests
//list($passed,$failed)=array_count_values(F3::get('TEST.result'));

if ($failed) echo 'Our test fixture failed in '.$failed.' tests.';
else echo 'Hoohah!';

?>
