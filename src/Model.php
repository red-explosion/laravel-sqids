<?php

declare(strict_types=1);

namespace RedExplosion\Sqids;

use Error;
use Exception;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
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
        $prefix = Str::beforeLast(subject: $sqid, search: Config::separator());

        /** @var class-string<EloquentModel>|null $model */
        $model = $models[$prefix] ?? null;

        if (!$model) {
            return null;
        }

        /** @phpstan-ignore-next-line */
        return $model::query()->findBySqid(sqid: $sqid);
    }

    public static function findOrFail(string $sqid): EloquentModel
    {
        $models = static::models();
        $prefix = Str::beforeLast(subject: $sqid, search: Config::separator());

        /** @var class-string<EloquentModel>|null $model */
        $model = $models[$prefix] ?? null;

        if (!$model) {
            throw new ModelNotFoundException();
        }

        /** @phpstan-ignore-next-line */
        return $model::query()->findBySqidOrFail(sqid: $sqid);
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

    protected static function namespaces(): array
    {
        $composer = File::json(path: base_path(path: 'composer.json'));

        /** @var array $namespaces */
        $namespaces = Arr::get(array: $composer, key: 'autoload.psr-4', default: []);

        return array_flip($namespaces);
    }

    protected static function fullQualifiedClassNameFromFile(SplFileInfo $file): string
    {
        /** @var Application $application */
        $application = app();

        return Str::of(string: $file->getRealPath())
            ->replaceFirst(search: static::basePath(), replace: '')
            ->replaceLast(search: '.php', replace: '')
            ->trim(characters: DIRECTORY_SEPARATOR)
            ->replace(
                search: array_keys(static::namespaces()),
                replace: array_values(static::namespaces())
            )
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
            directory: static::basePath(),
        ));

        /** @var SplFileInfo $file */
        foreach ($iterator as $file) {
            if ($file->isDir() || str_contains(haystack: $file->getRealPath(), needle: 'vendor')) {
                continue;
            }

            $files[] = $file;
        }

        return $files;
    }

    protected static function basePath(): string
    {
        /** @var Application $application */
        $application = app();

        if ($application->runningUnitTests()) {
            $basePath = new SplFileInfo(base_path(path: '../../../../'));

            return $basePath->getRealPath();
        }

        return base_path();
    }
}
