<?php

namespace Tasyakur\Facades\FileSystem;

class FileCreator
{
    public const MODE_OVERWRITE = 1;
    public const MODE_NEWFILE = 2;
    public const MODE_APPEND = 3;
    public const MODE_ABORT = 4;

    /**
     * @param string $filePath
     * @param mixed $content
     * @param int $mode must follow MODE_* const
     * @return bool
     */
    public static function create(string $filePath, $content, int $mode = 2): bool
    {
        $fileExists = file_exists($filePath);
        $fileDir = dirname($filePath);
        $fileName = basename($filePath);
        $fileNameWithoutExt = removeFileExt($fileName);
        $fileExt = pathinfo($filePath, PATHINFO_EXTENSION);

        // Create dir if it doesn't exists
        if (!is_dir($fileDir))
            mkdir($fileDir, 0777, true);

        switch ($mode) {
            case static::MODE_OVERWRITE:
                file_put_contents($filePath, $content);
                break;

            case static::MODE_NEWFILE:
                if ($fileExists) {
                    $fileUnique = false;
                    $index = 1;
                    while($fileUnique) {
                        $filePath = "$fileDir/{$fileNameWithoutExt}_$index.$fileExt";
                        $fileUnique = file_exists($filePath);
                    }
                }
                file_put_contents($filePath, $content);
                break;

            case static::MODE_APPEND:
                file_put_contents($filePath, $content, FILE_APPEND);
                break;

            case static::MODE_ABORT:
                return false;
                break;

            default:
                throw new \InvalidArgumentException('FileCreator: Invalid mode');
                break;
        }

        return true;
    }

    /**
     * @param string $filePath
     * @return bool
     */
    public static function remove(string $filePath): bool
    {
        $fileExists = file_exists($filePath);
        if (!$fileExists)
            return false;

        // Remove the file
        return unlink($filePath);
    }
}