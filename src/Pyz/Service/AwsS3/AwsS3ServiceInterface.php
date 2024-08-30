<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Service\AwsS3;

interface AwsS3ServiceInterface
{
    /**
     * Specification:
     * - Returns the presigned URL for the given file name.
     *
     * @api
     *
     * @param string $fileName
     * @param string $objectType
     *
     * @return string
     */
    public function getPresignedUrl(string $fileName, string $objectType): string;

    /**
     * Specification:
     * - Returns the S3 object URL for the given file name.
     *
     * @api
     *
     * @param string $fileName
     * @param string $objectType
     *
     * @return string
     */
    public function getS3ObjectUrl(string $fileName, string $objectType): string;

    /**
     * Specification:
     * - Deletes the S3 object for the given path.
     *
     * @api
     *
     * @param string $objectType
     * @param string $path
     *
     * @return void
     */
    public function deleteS3Object(string $objectType, string $path): void;

    /**
     * Specification:
     * - Registers the stream wrapper for the S3 client.
     *
     * @api
     *
     * @param string $objectType
     *
     * @return void
     */
    public function registerStreamWrapper(string $objectType): void;

    /**
     * Specification:
     * - Returns the CDN URL for the given file name and object type.
     *
     * @api
     *
     * @param string $fileName
     * @param string $objectType
     *
     * @return string
     */
    public function getCdnUrl(string $fileName, string $objectType): string;
}
