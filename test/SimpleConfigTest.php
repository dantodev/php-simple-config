<?php namespace Dtkahl\SimpleConfig;

class SimpleConfigTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Config
     */
    private $config;

    public function setUp()
    {
        $this->config = new Config([
            "lv1a" => [
                "lv2a" => [
                    "lv3a" => "foobarA"
                ]
            ],
            "lv1b" => [
                "lv2b" => "foobarb"
            ],
            "lv1c" => [],
            "foo" => "bar"
        ], ["_a" => "lv1a.lv2a"]);
    }

    public function testHas()
    {
        $this->assertTrue($this->config->has("foo"));
        $this->assertTrue($this->config->has("lv1a"));
        $this->assertTrue($this->config->has("lv1a.lv2a"));
        $this->assertTrue($this->config->has("lv1a.lv2a.lv3a"));
        $this->assertFalse($this->config->has("i.am.not.there"));
    }

    public function testGet()
    {
        $this->assertEquals("bar", $this->config->get("foo"));
        $this->assertEquals(
            [
                "lv2a" => [
                    "lv3a" => "foobarA"
                ]
            ],
            $this->config->get("lv1a")
        );
        $this->assertEquals(
            [
                "lv3a" => "foobarA"
            ],
            $this->config->get("lv1a.lv2a")
        );
        $this->assertEquals("foobarA", $this->config->get("lv1a.lv2a.lv3a"));
        $this->assertNull($this->config->get("i.am.not.there"));
        $this->assertEquals("test", $this->config->get("i.am.not.there", "test"));
    }

    public function testSet()
    {
        $this->assertEquals("test", $this->config->set("test", "test")->get("test"));
        $this->assertEquals("test", $this->config->set("test2.test", "test", true)->get("test2.test"));
        $this->assertEquals("test", $this->config->set("lv1a.test", "test")->get("lv1a.test"));
    }

    public function testRemove()
    {
        $this->assertNull($this->config->remove("lv1a.lv12")->get("lv1a.lv12"));
        $this->assertNull($this->config->remove("foo")->get("foo"));
    }

    public function testAliases()
    {
        $this->assertEquals(["lv3a" => "foobarA"], $this->config->get("_a"));
        $this->assertEquals("foobarA", $this->config->get("_a.lv3a"));
    }

}