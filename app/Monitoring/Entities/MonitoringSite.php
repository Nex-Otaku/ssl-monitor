<?php

namespace App\Monitoring\Entities;

use App\Monitoring\Models\Monitor as MonitorModel;
use App\Monitoring\Models\Site as SiteModel;
use App\Monitoring\Models\Check as CheckModel;
use App\Monitoring\Models\SiteStatus as SiteStatusModel;
use Illuminate\Support\Carbon;

class MonitoringSite
{
    private const CHECK_STATUS_OK = 'ok';
    private const CHECK_STATUS_WARNING = 'warning';
    private const CHECK_STATUS_FAIL = 'fail';

    private MonitorModel $monitor;

    private function __construct(
        MonitorModel $monitor
    ) {
        $this->monitor = $monitor;
    }

    public static function create(string $domainName, int $userTgId): self
    {
        /** @var SiteModel $site */
        $site = SiteModel::firstOrCreate(
            [
                'domain' => $domainName,
            ],
            [
                'created_at' => now(),
            ],
        );

        /** @var MonitorModel $monitor */
        $monitor = MonitorModel::firstOrCreate(
            [
                'user_tg_id' => $userTgId,
                'site_id' => $site->id,
            ],
            [
                'created_at' => now(),
            ],
        );

        return new self($monitor);
    }

    /**
     * @return self[]
     */
    public static function forTgUser(int $userTgId): array
    {
        $records = MonitorModel::where(['user_tg_id' => $userTgId])->get()->all();

        return self::packArray($records);
    }

    /**
     * @return self[]
     */
    public static function all(): array
    {
        $records = MonitorModel::all()->all();

        return self::packArray($records);
    }

    /**
     * @return self[]
     */
    private static function packArray(array $records): array
    {
        $items = [];

        foreach ($records as $record) {
            $items [] = new self($record);
        }

        return $items;
    }

    public static function destroy(string $domainName, int $userTgId): void
    {
        $siteModel = SiteModel::where(['domain' => $domainName])->first();

        if ($siteModel === null) {
            return;
        }

        MonitorModel::where([
                                'user_tg_id' => $userTgId,
                                'site_id' => $siteModel->id,
                            ])->delete();
    }

    public function getDomainName(): string
    {
        return $this->getSite()->domain;
    }

    private function getSite(): SiteModel
    {
        return SiteModel::where(['id' => $this->monitor->site_id])->firstOrFail();
    }

    public function logCheckSuccess(): void
    {
        $this->logCheck(self::CHECK_STATUS_OK, null);
    }

    public function logCheckWarning(string $warningMessage): void
    {
        $this->logCheck(self::CHECK_STATUS_WARNING, $warningMessage);
    }

    public function logCheckFail(string $failMessage): void
    {
        $this->logCheck(self::CHECK_STATUS_FAIL, $failMessage);
    }

    private function logCheck(string $status, ?string $reason): void
    {
        $now = now();

        $check = new CheckModel(
            [
                'date' => $now,
                'site_id' => $this->monitor->site_id,
                'status' => $status,
                'reason' => $reason,
                'created_at' => $now,
            ]
        );

        $check->saveOrFail();

        /** @var SiteStatusModel $siteStatus */
        $siteStatus = SiteStatusModel::firstOrCreate(
            [
                'site_id' => $this->monitor->site_id,
            ],
            [
                'status' => $status,
                'reason' => $reason,
                'checked_at' => $now,
                'uptime_percent' => '0.0',
                'days_online' => 0,
                'created_at' => $now,
            ],
        );

        $siteStatus->update(
            [
                'status' => $status,
                'reason' => $reason,
                'checked_at' => $now,
                'uptime_percent' => '0.0', // TODO Вычислить
                'days_online' => 0,        // TODO Вычислить
            ]
        );
    }

    public function getStatusLabel(): string
    {
        /** @var SiteStatusModel $siteStatus */
        $siteStatus = SiteStatusModel::where(['site_id' => $this->monitor->site_id])
            ->first();

        if ($siteStatus === null) {
            return '(нет данных)';
        }

        $code = strtoupper($siteStatus->status);

        $icon = '';

        if ($siteStatus->status === self::CHECK_STATUS_OK) {
            $icon = '✅';
        } elseif ($siteStatus->status === self::CHECK_STATUS_WARNING) {
            $icon = '⚠';
        } elseif ($siteStatus->status === self::CHECK_STATUS_FAIL) {
            $icon = '❌';
        } else {
            $icon = '❓';
        }

        $checkedDate = $siteStatus->checked_at !== null
            ? Carbon::createFromFormat('Y-m-d H:i:s', $siteStatus->checked_at)->format('d.m.Y H:i')
            : '(нет)';

        $uptimePercent = $siteStatus->uptime_percent;
        $daysOnline = $siteStatus->days_online;
        $isOk = $siteStatus->status === self::CHECK_STATUS_OK;

        if ($isOk) {
            return " {$icon} {$code}, проверено {$checkedDate}, доступность {$uptimePercent}%, онлайн {$daysOnline} дней";
        }

        $reason = $siteStatus->reason;

        return " {$icon} {$code}, проверено {$checkedDate}, причина: {$reason}";
    }

    public function isOk(): bool
    {
        return $this->getStatusCode() === self::CHECK_STATUS_OK;
    }

    public function isWarning(): bool
    {
        return $this->getStatusCode() === self::CHECK_STATUS_WARNING;
    }

    public function isFail(): bool
    {
        return $this->getStatusCode() === self::CHECK_STATUS_FAIL;
    }

    private function getStatusCode(): ?string
    {
        /** @var SiteStatusModel $siteStatus */
        $siteStatus = SiteStatusModel::where(['site_id' => $this->monitor->site_id])
                                     ->first();

        return $siteStatus?->status;
    }
}
