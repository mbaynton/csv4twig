<?php
namespace mbaynton\CSV4Twig\Tests;

use mbaynton\CSV4Twig\Filter;

class FilterTest extends \PHPUnit_Framework_TestCase {
  public function testStaticCsvFilter() {
    $this->assertEquals(
      '',
      Filter::csv(null, '', null),
      'Empty string is unmodified'
    );

    $this->assertEquals(
      'abc',
      Filter::csv(null, 'abc', null),
      'Simple string needing no changes is unmodified'
    );

    $this->assertEquals(
      '"ab,c"',
      Filter::csv(null, 'ab,c', null),
      'String including a comma is quoted'
    );

    $this->assertEquals(
      '"abc ""def"""',
      Filter::csv(null, 'abc "def"', null),
      'Double-quotes are escaped to two consecutive double-quotes'
    );

    $this->assertEquals(
      '"abc, ""def"""',
      Filter::csv(null, 'abc, "def"', null),
      'String with both comma and double-quotes is escaped and wrapped in quotes'
    );

    $this->assertEquals(
      "\"abc\ndef\"",
      Filter::csv(null, "abc\ndef", null),
      'String with newline is quoted'
    );

    $long_string = str_pad('abc', 17000, 'def');
    $this->assertEquals(17000, strlen($long_string));
    $this->assertEquals(
      $long_string,
      Filter::csv(null, $long_string, null),
      'Long strings are fully returned'
    );
  }
}
