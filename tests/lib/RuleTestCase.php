<?php

use PHPUnit\Framework\TestCase;

// RuleTestCase with custom assertions
// see more: https://phpunit.readthedocs.io/en/7.3/extending-phpunit.html#subclass-phpunit-framework-testcase
abstract class RuleTestCase extends TestCase {
  /**
   * @var string ruleId
   */
  public $ruleId;

  public function assertLineColumn($linecolumns, $report) {
    $messages = $report->getResult()->messages;

    $this->assertCount(count($linecolumns), $messages);
    for ($i = 0; $i < count($linecolumns); $i++) {
      $pos = $linecolumns[$i];
      $this->assertArraySubset([
        'ruleId' => $this->ruleId,
        'line' => $pos[0],  // line
        'column' => $pos[1],  // column
      ], $messages[$i]);
    }
  }

  public function assertContainsMessage($message, $report) {
    $messages = $report->getResult()->messages;
    $found = false;
    foreach ($messages as $m) {
      if ($m['message'] === $message) {
        $found = true;
        break;
      }
    }
    $this->assertTrue($found, "It should contain message '" . $message . "'");
  }
}
