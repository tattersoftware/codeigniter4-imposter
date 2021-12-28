<?php

use Tatter\Imposter\Factories\ImposterFactory;
use Tatter\Users\Test\FactoryTestCase;

/**
 * @internal
 */
final class FactoryTest extends FactoryTestCase
{
    protected $migrate = false;
    protected $refresh = false;
    protected $class   = ImposterFactory::class;

    /**
     * Since ImposterFactory isn't a true model it cannot
     * be used with Fabricator, so we create our own entity.
     */
    protected function createEntity(): void
    {
        $this->user = ImposterFactory::fake();
        ImposterFactory::add($this->user);
    }

    public function testIndex()
    {
        $index = ImposterFactory::index();

        ImposterFactory::add(ImposterFactory::fake());

        $this->assertSame($index + 1, ImposterFactory::index());
    }

    public function testReset()
    {
        ImposterFactory::add(ImposterFactory::fake());
        $this->assertGreaterThan(0, ImposterFactory::index());

        ImposterFactory::reset();
        $this->assertSame(0, ImposterFactory::index());
    }
}
