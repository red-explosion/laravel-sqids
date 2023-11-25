<?php

declare(strict_types=1);

namespace RedExplosion\Sqids;

use Error;
use Exception;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Foundation\Application;
use Illuminate\Support\Str;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionClass;
use SplFileInfo;

class Model
{
    public static function find(string $sqid): ?EloquentModel
    {
        $models = static::models();
        $prefix = Str::beforeLast(subject: $sqid, search: Sqids::separator());

        /** @var class-string<EloquentModel>|null $model */
        $model = $models[$prefix] ?? null;

        if (!$model) {
            return null;
        }

        /** @phpstan-ignore-next-line */
        return $model::query()->findBySqid(id: $sqid);
    }

    /**
     * @return array<string, class-string<EloquentModel>>
     */
    protected static function models(): array
    {
        /** @var array<string, class-string<EloquentModel>> $models */
        $models = collect(static::getFilesRecursively())
            ->map(fn(SplFileInfo $file) => self::fullQualifiedClassNameFromFile(file: $file))
            ->map(function (string $class): ?ReflectionClass {
                try {
                    /** @phpstan-ignore-next-line */
                    return new ReflectionClass(objectOrClass: $class);
                } catch (Exception|Error) {
                    return null;
                }
            })
            ->filter()
            /** @phpstan-ignore-next-line */
            ->filter(fn(ReflectionClass $class): bool => $class->isSubclassOf(class: EloquentModel::class))
            /** @phpstan-ignore-next-line */
            ->filter(fn(ReflectionClass $class) => !$class->isAbstract())
            /** @phpstan-ignore-next-line */
            ->filter(fn(ReflectionClass $class) => in_array(needle: HasSqids::class, haystack: $class->getTraitNames()))
            /** @phpstan-ignore-next-line */
            ->mapWithKeys(fn(ReflectionClass $reflectionClass) => [
                Sqids::prefixForModel($reflectionClass->getName()) => $reflectionClass->getName()
            ])
            ->toArray();

        return $models;
    }

    protected static function fullQualifiedClassNameFromFile(SplFileInfo $file): string
    {
        /** @var Application $application */
        $application = app();

        return Str::of($file->getRealPath())
            ->replaceFirst(search: base_path(), replace: '')
            ->replaceLast(search: '.php', replace: '')
            ->trim(characters: DIRECTORY_SEPARATOR)
            ->ucfirst()
            ->replace(
                search: [DIRECTORY_SEPARATOR, 'App\\'],
                replace: ['\\', $application->getNamespace()],
            )
            ->toString();
    }

    /**
     * @return array<int, SplFileInfo>
     */
    protected static function getFilesRecursively(): array
    {
        $files = [];

        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(
            directory: app_path(),
        ));

        /** @var SplFileInfo $file */
        foreach ($iterator as $file) {
            if ($file->isDir()) {
                continue;
            }

            $files[] = $file;
        }

        return $files;
    }
}
