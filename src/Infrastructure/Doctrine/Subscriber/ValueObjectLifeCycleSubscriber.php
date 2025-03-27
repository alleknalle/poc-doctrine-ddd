<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Subscriber;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\Persistence\Reflection\TypedNoDefaultReflectionProperty;
use ReflectionObject;

use function array_key_exists;
use function get_class;
use function is_object;

#[AsDoctrineListener(event: Events::postLoad, priority: 500, connection: 'default')]
final class ValueObjectLifeCycleSubscriber
{
    public function postLoad(LifecycleEventArgs $eventArgs): void
    {
        $entity = $eventArgs->getObject();

        $classMeta = $eventArgs->getObjectManager()->getClassMetadata(get_class($entity));
        foreach ($classMeta->reflFields as $reflectionProperty) {
            if (!array_key_exists($reflectionProperty->getName(), $classMeta->embeddedClasses)) {
                // no embedded class
                continue;
            }

            if (!$reflectionProperty instanceof TypedNoDefaultReflectionProperty) {
                // why exactly?
                continue;
            }

            $value = $reflectionProperty->getValue($entity);

            // object? -> double check with datetime and stuff!
            if (!is_object($value)) {
                continue;
            }

            // check all nested objects
            $this->checkObject($value);

            if (!$reflectionProperty->getType()?->allowsNull()) {
                continue;
            }

            if (!$this->areAllPropertiesNull($value)) {
                continue;
            }

            $reflectionProperty->setValue($entity, null);
        }
    }

    private function checkObject(object $object): void
    {
        $objectReflection = new ReflectionObject($object);
        foreach ($objectReflection->getProperties() as $property) {
            // initialized
            $initialized = $property->isInitialized($object);
            if (!$initialized) {
                continue;
            }

            $value = $property->getValue($object);

            // object? -> double check with datetime and stuff!
            if (!is_object($value)) {
                continue;
            }

            // check all nested objects
            $this->checkObject($value);

            if (!$property->getType()?->allowsNull()) {
                continue;
            }

            if (!$this->areAllPropertiesNull($value)) {
                continue;
            }

            /**
             * @todo this does not work for readonly properties!
             * This needs to be fixed
             * See https://stitcher.io/blog/cloning-readonly-properties-in-php-81
             */
            $property->setValue($object, null);
        }
    }

    private function areAllPropertiesNull(object $object): bool
    {
        $objectReflection = new ReflectionObject($object);
        foreach ($objectReflection->getProperties() as $property) {
            if ($property->isInitialized($object) && $property->getValue($object) !== null) {
                return false;
            }
        }

        return true;
    }
}
