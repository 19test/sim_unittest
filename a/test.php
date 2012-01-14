<?php

require_once 'lib/base.php';

function fun_exam($a, $b) {
	return 1.0 * $a + 1.0 * $b;
}

// Set up
F3::clear('TEST');
F3::mock('GET /');

F3::call('index.php'); // Our test fixture will run in a sandbox

echo "<hr>Test<hr>";

// This is where the tests begin
F3::expect(F3::get('RESPONSE'),		'Passed',	'Failed: No response');
F3::expect('{{is_string(@RESPONSE)}}',	'OK',		'Failed: Not a string');
F3::expect('{{strlen(@RESPONSE)<120}}',	'Great!',	'Failed: Too long');
F3::expect('{{!@ERROR}}',		'Done',		'Failed: An error occurred');
F3::expect(fun_exam(1,2) == 3,		'OK: 1+2=>3',	'Failed: 1+2');
F3::expect(fun_exam("1","2") == '12',	'OK: "1"+"2"=>"3"', 'Failed: "1"+"2"');

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

if ($failed) echo 'Our test fixture failed in '.$failed.' tests.';
else echo 'Hoohah!';

?>
