<?php
/**
 * User: jg
 * Date: 28/11/16
 * Time: 22:54
 */

namespace Database;

use ByJG\AnyDataset\Database\Expressions\DbSqliteFunctions;

class DbSqliteFunctionsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DbSqliteFunctions
     */
    private $object;

    protected function setUp()
    {
        $this->object = new DbSqliteFunctions();
    }

    protected function tearDown()
    {
        $this->object = null;
    }

    public function testConcat()
    {
        $result = $this->object->concat('param1', 'param2');
        $this->assertEquals('param1 || param2', $result);

        $result = $this->object->concat('param1', 'param2', 'param3');
        $this->assertEquals('param1 || param2 || param3', $result);

        $result = $this->object->concat('param1', 'param2', 'param3', 'param4');
        $this->assertEquals('param1 || param2 || param3 || param4', $result);
    }

    public function testLimit()
    {
        $baseSql = 'select * from table';

        $result = $this->object->limit($baseSql, 10);
        $this->assertEquals($baseSql . ' LIMIT 10, 50', $result);

        $result = $this->object->limit($baseSql, 10, 20);
        $this->assertEquals($baseSql . ' LIMIT 10, 20', $result);

        $result = $this->object->limit($baseSql . ' LIMIT 5, 50', 10, 20);
        $this->assertEquals($baseSql . ' LIMIT 10, 20', $result);
    }

    public function testTop()
    {
        $baseSql = 'select * from table';

        $result = $this->object->top($baseSql, 10);
        $this->assertEquals($baseSql . ' LIMIT 0, 10', $result);

        $result = $this->object->top($baseSql . ' LIMIT 20,350', 10);
        $this->assertEquals($baseSql . ' LIMIT 0, 10', $result);
    }

    public function testHasTop()
    {
        $this->assertTrue($this->object->hasTop());
    }

    public function testHasLimit()
    {
        $this->assertTrue($this->object->hasLimit());
    }

    public function testSqlDate()
    {
        $this->assertEquals("strftime('%d/%m/%Y', column)", $this->object->sqlDate('d/M/Y', 'column'));
        $this->assertEquals("strftime('%d/%m/%Y %H:%M', column)", $this->object->sqlDate('d/m/Y H:i', 'column'));
        $this->assertEquals("strftime('%H:%M', column)", $this->object->sqlDate('H:i', 'column'));
        $this->assertEquals("strftime('%d %m %Y %H %M', column)", $this->object->sqlDate('d m Y H i', 'column'));
        $this->assertEquals("strftime('%d/%m/%Y %H:%M', 'now')", $this->object->sqlDate('d/m/y h:i'));
        $this->assertEquals("strftime('%m ', column)", $this->object->sqlDate('M q', 'column'));
    }

    public function testToDate()
    {
    }

    public function testFromDate()
    {

    }
}
