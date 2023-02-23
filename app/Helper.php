<?php

use Carbon\Carbon;
use Jenssegers\Agent\Agent;

/**
 * @param $date
 * @return string
 */
function timeAgo($date): string
{
	return Carbon::parse($date)->diffForHumans();
}

/**
 * @param $date
 * @param $format
 * @return string
 */
function timeConvert($date, $format): string
{
	return Carbon::parse($date)->translatedFormat($format);
}

/**
 * @param $start
 * @param $end
 * @return string
 */
function timeDiffMinutes($start, $end): string
{
	return Carbon::parse($start)->addMinutes(30)->diffInMinutes($end);
}

/**
 * @param $start
 * @param $end
 * @return string
 */
function timeDiffHours($start, $end): string
{
	$start = Carbon::parse($start);
	$end = Carbon::parse($end);

	$startTime = Carbon::createFromFormat('H:i:s', '08:30:00');
	$startTime->year($start->year);
	$startTime->month($start->month);
	$startTime->day($start->day);

	$endTime = Carbon::createFromFormat('H:i:s', '17:00:00');
	$endTime->year($end->year);
	$endTime->month($end->month);
	$endTime->day($end->day);

	if ($start->lt($startTime))
	{
		$start->hour('08');
		$start->minute('30');
	}

	if ($end->gt($endTime))
	{
		$end->hour('17');
		$end->minute('00');
	}

	$different = ($start->addMinutes(30)->diffInMinutes($end)) / 60;

	return $different == intval($different) ? number_format($different, 1, ',', '') : intval($different);
}

/**
 * @param $start
 * @param $end
 * @return float
 */
function timeDiffHoursWithDecimal($start, $end): float
{
	$start = Carbon::parse($start);
	$end = Carbon::parse($end);

	$startTime = Carbon::createFromFormat('H:i:s', '08:30:00');
	$startTime->year($start->year);
	$startTime->month($start->month);
	$startTime->day($start->day);

	$endTime = Carbon::createFromFormat('H:i:s', '17:00:00');
	$endTime->year($end->year);
	$endTime->month($end->month);
	$endTime->day($end->day);

	if ($start->lt($startTime))
	{
		$start->hour('08');
		$start->minute('30');
	}

	if ($end->gt($endTime))
	{
		$end->hour('17');
		$end->minute('00');
	}

	$different = $start->addMinutes(30)->diffInMinutes($end);

	return $different / 60;
}

function getDevice($ua)
{
	$agent = new Agent();
	$agent->setUserAgent($ua);

	if ($agent->isMobile())
	{
		$device = 'Mobil';
	}
	else if ($agent->isTablet())
	{
		$device = 'Tablet';
	}
	else
	{
		$device = 'Bilgisayar';
	}

	return $device;
}

/**
 * @param int|null $index
 * @return mixed
 */
function segments(int $index = null): mixed
{
	$baseUrl = config('BASE_URL');
	$baseArray = explode('/', trim(parse_url($baseUrl, PHP_URL_PATH) ?? '', '/'));

	$requestUri = $_SERVER['REQUEST_URI'];
	$parsedUrl = parse_url($requestUri, PHP_URL_PATH);
	$requestArray = explode('/', trim($parsedUrl ?? '', '/'));

	$diffArray = array_values(array_diff($requestArray, $baseArray));

	if ($index || $index === 0)
	{
		if (isset($diffArray[$index]))
		{
			return $diffArray[$index];
		}
		else
		{
			return false;
		}
	}
	else
	{
		return $diffArray;
	}
}

/**
 * @param float $par
 * @return string
 */
function turkishLira(float $par): string
{
	return number_format($par, 2, ',', '.');
}

/**
 * @param int $limit
 * @return string
 * @noinspection PhpLoopNeverIteratesInspection
 */
function hashid(int $limit = 11): string
{
	$chars = 'bcdfghjklmnpqrstvwxyz';
	$chars .= 'BCDFGHJKLMNPQRSTVWXYZ';
	$chars .= '0123456789';

	while (1)
	{
		$key = '';
		srand((double) microtime() * 1000000);

		for ($i = 0; $i < $limit; $i++)
		{
			$key .= substr($chars, (rand() % (strlen($chars))), 1);
		}

		break;
	}

	return $key;
}
