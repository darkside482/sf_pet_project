<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Security;

use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class TokenGenerator
{
	private const REDIS_TOKEN_KEY = 'token_';

	public function __construct
	(
		private RedisAdapter $redisAdapter
	) {}

	public function create(string $userId): string
	{
		$token = md5(random_bytes(16) . $userId);

		$cachedToken = $this->redisAdapter->getItem(self::REDIS_TOKEN_KEY . $token);
		$cachedToken->set(['id' => $userId]);
		$cachedToken->expiresAfter(\DateInterval::createFromDateString('1 day'));

		$this->redisAdapter->save($cachedToken);
		$this->redisAdapter->commit();

		return $token;
	}

	public function hasToken(string $token): bool
	{
		return $this->redisAdapter->hasItem(self::REDIS_TOKEN_KEY . $token);
	}

	public function getData(string $token): array
	{
		if (!$this->redisAdapter->hasItem(self::REDIS_TOKEN_KEY . $token)) {
			throw new AccessDeniedHttpException();
		}
		return $this->redisAdapter->getItem(self::REDIS_TOKEN_KEY . $token)->get();
	}
}