#!/usr/bin/env php
<?php

function files(): array
{
    $files = explode(
        separator: PHP_EOL,
        string: run(command: 'grep -E -r -l -i "package_name|package_slug|package_description|author_name|author_username|author@email.com|skeleton|Skeleton" --exclude-dir=vendor ./* ./.github/* | grep -v ' . basename(path: __FILE__))
    );

    $files[] = './config/skeleton.php';

    return $files;
}

function run(string $command): string
{
    return trim(string: (string) shell_exec(command: $command));
}

function replaceInFile(string $file, array $replacements): void
{
    /** @var string $contents */
    $contents = file_get_contents(filename: $file);
    $contents = str_replace(search: array_keys($replacements), replace: array_values($replacements), subject: $contents);

    file_put_contents(filename: $file, data: $contents);
}

function removePrefix(string $prefix, string $content): string
{
    if (str_starts_with(haystack: $content, needle: $prefix)) {
        return mb_substr(string: $content, start: mb_strlen(string: $prefix));
    }

    return $content;
}

function titleCase(string $subject): string
{
    return str_replace(search: ' ', replace: '', subject: ucwords(string: $subject));
}

function determineSeparator(string $path): string
{
    return str_replace(search: '/', replace: DIRECTORY_SEPARATOR, subject: $path);
}

function removeReadmeParagraphs(string $file): void
{
    /** @var string $contents */
    $contents = file_get_contents(filename: $file);

    file_put_contents(
        filename: $file,
        data: preg_replace(pattern: '/<!--delete-->.*<!--\/delete-->/s', replacement: '', subject: $contents) ?: $contents
    );
}

$packageSlug = $argv[1];
$packageSlugWithoutPrefix = removePrefix(prefix: 'laravel-', content: $packageSlug);
$packageName = ucwords(string: str_replace(search: '-', replace: ' ', subject: $packageSlug));
$packageDescription = $argv[2];

$authorName = $argv[3];
$authorUsername = $argv[4];
$authorEmail = $argv[5];

$className = removePrefix(prefix: 'Laravel', content: titleCase(subject: $packageName));

foreach (files() as $file) {
    replaceInFile($file, [
        'package_name' => $packageName,
        'package_slug' => $packageSlug,
        'package_description' => $packageDescription,
        'author_name' => $authorName,
        'author_username' => $authorUsername,
        'author@email.com' => $authorEmail,
        'skeleton' => $packageSlugWithoutPrefix,
        'Skeleton' => $className,
    ]);

    match (true) {
        str_contains($file, determineSeparator(path: 'src/Skeleton.php')) => rename($file, determineSeparator(path: './src/' . $className . '.php')),
        str_contains($file, determineSeparator(path: 'src/SkeletonServiceProvider.php')) => rename($file, determineSeparator(path: './src/' . $className . 'ServiceProvider.php')),
        str_contains($file, determineSeparator(path: 'config/skeleton.php')) => rename($file, determineSeparator(path: './config/' . $packageSlugWithoutPrefix . '.php')),
        str_contains($file, 'README.md') => removeReadmeParagraphs($file),
        default => [],
    };
}
