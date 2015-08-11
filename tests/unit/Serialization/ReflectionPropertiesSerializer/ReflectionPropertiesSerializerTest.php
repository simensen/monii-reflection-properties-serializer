<?php

namespace Monii\Serialization\ReflectionPropertiesSerializer;

//use Monii\AggregateEventStorage\Contract\SimplePhpFqcnContractResolver;

use Monii\Serialization\ReflectionPropertiesSerializer\Fixtures\Depth\ReflectionPropertiesSerializerFixture;
use Monii\Serialization\ReflectionPropertiesSerializer\Fixtures\Blogging\Post;
use Monii\Serialization\ReflectionPropertiesSerializer\Fixtures\Blogging\PostId;
use Monii\Serialization\ReflectionPropertiesSerializer\Fixtures\Banking\Account\AccountWasOpened;
use PHPUnit_Framework_TestCase as TestCase;

class ReflectionPropertiesSerializerTest extends TestCase
{
    /**
     * @dataProvider provideRoundTripData
     */
    public function testRoundTrip($input)
    {
        $reflectionSerializer = new ReflectionPropertiesSerializer();

        $data = $reflectionSerializer->serialize($input);

        // Let's simulate converting this to a JSON string and
        // back again.
        $data = json_decode(json_encode($data), true);

        $object = $reflectionSerializer->deserialize($input, $data);

        $this->assertEquals($input, $object);
    }

    public function provideRoundTripData()
    {
        $complicated = new ReflectionPropertiesSerializerFixture();
        $complicated->setPrivateOuterValue('a');
        $complicated->setPrivateExtendedValue('b');
        $complicated->setPrivateTraitValue('c');

        return [
            [new AccountWasOpened('fixture-account-000', 25)],
            [new Post(PostId::fromString('first-post'))],
            [$complicated],
        ];
    }
}