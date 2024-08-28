<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Service\AwsS3\Creator;

use Aws\CommandInterface;
use Aws\S3\S3ClientInterface;
use DateTime;
use Psr\Http\Message\UriInterface;
use Pyz\Service\AwsS3\AwsS3Config;
use Pyz\Service\AwsS3\Exception\S3BucketConfigurationNotFoundException;
use Pyz\Shared\AwsS3\AwsS3Config as SharedAwsS3Config;

class UrlCreator implements UrlCreatorInterface
{
    private const SCHEMA_HTTPS = 'https';

    private S3ClientInterface $s3Client;

    private AwsS3Config $config;

    private string $objectType;

    public function __construct(AwsS3Config $config, S3ClientInterface $s3Client, string $objectType)
    {
        $this->config = $config;
        $this->s3Client = $s3Client;
        $this->objectType = $objectType;
    }

    public function getPresignedUrl(string $fileName): string
    {
        $command = $this->getPutObjectCommand($fileName);
        $expiration = $this->getPreSignUrlExpiration();
        $uri = $this->s3Client->createPresignedRequest($command, $expiration)->getUri();

        return $this->buildPresignedUrl($uri);
    }

    public function getCdnUrl(string $fileName): string
    {
        $cdnHost = $this->getCdnHost();

        return strtr(
            $this->config->getCdnUrlPattern(),
            [
                '{schema}' => self::SCHEMA_HTTPS,
                '{cdnHost}' => $cdnHost,
                '{fileName}' => $fileName,
            ],
        );
    }

    private function getPutObjectCommand(string $fileName): CommandInterface
    {
        return $this->s3Client->getCommand('PutObject', [
            'Bucket' => $this->getBucketName(),
            'Key' => $fileName,
        ]);
    }

    private function getBucketName(): string
    {
        $bucketConfiguration = $this->config->getClientConfigurationForObjectType($this->objectType);

        return $bucketConfiguration['Bucket'];
    }

    private function getCdnHost(): string
    {
        $cdnHost = $this->config->getClientConfigurationForObjectType($this->objectType)[SharedAwsS3Config::CONFIG_CDN_HOST] ?? null;
        if (!$cdnHost) {
            throw new S3BucketConfigurationNotFoundException(
                sprintf('CDN host is not configured for object type %s.', $this->objectType),
            );
        }

        return $this->sanitizeTrailingSlash($cdnHost);
    }

    private function getPreSignUrlExpiration(): DateTime
    {
        $configuration = $this->config->getClientConfigurationForObjectType($this->objectType);
        $expiration = $configuration[SharedAwsS3Config::CONFIG_PRE_SIGNED_URL_EXPIRATION] ?? null;
        if (!$expiration) {
            throw new S3BucketConfigurationNotFoundException(
                sprintf('Pre-signed URL expiration is not configured for object type %s.', $this->objectType),
            );
        }

        return new DateTime(sprintf('+%s', $expiration));
    }

    private function buildPresignedUrl(UriInterface $uri): string
    {
        return $uri->getScheme() . '://' . $uri->getHost() . $uri->getPath() . '?' . $uri->getQuery();
    }

    private function sanitizeTrailingSlash(string $path): string
    {
        return rtrim($path, DIRECTORY_SEPARATOR);
    }
}
