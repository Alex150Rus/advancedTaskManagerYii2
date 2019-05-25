<?php namespace frontend\tests;

use common\models\LoginForm;
use frontend\components\Processor;
use frontend\components\TestService;

class FirstTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;
    // tests

    public function testAttribute()
    {
        $obj = new LoginForm();

        // здесь проверка более близка к человеческому языку
        expect('rememberMe is true', $obj->rememberMe)->equals(true);
        //здесь по программистстки описывается проверка
       // $this->assertAttributeEquals(true, 'rememberMe', $obj);
    }

    public function testVariable()
    {
        //$processor = new Processor();
        // говорим что надо создать Mock объект. Объект заменяющий класс.
        $processor = $this->getMockBuilder(Processor::class)
            //создаём метод заглушку
            ->setMethods(['fill'])->getMock();

        // задаём поведение объекта-заглушки. Ожидаем, что в нём один раз будет вызван метод fill, в который
        // будут переданы опаределённые параметры и который вернёт определённое значение.
        $processor->expects($this->once())->method('fill')
            ->with(2, 'xx')->willReturn(['xx', 'xx']);
                $service = new TestService($processor);
        expect($service->run(2, 'xx')) ->equals(['xx', 'xx']);

    }

    public function testAsserts()
    {
        $a = 123;
        $b = true;
        $array = ['var' => 2];

        $this->assertNotEmpty($a);
        $this->assertEquals(123, $a);
        $this->assertTrue($b, 'значение $b - должно быть true');
        $this->assertLessThan(125, $a);
        $this->assertArrayHasKey('var', $array, 'В массиве должен быть ключ var');
    }

}