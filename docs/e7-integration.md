# E7 — Integration contract

This repository is a personal implementation workspace. It does not modify the team GitLab project.

## One integration point

The E7 implementation exposes `App\\Providers\\E7ServiceProvider` as the single application integration point.

Register this provider in the team's existing Laravel provider/bootstrap mechanism. It performs only E7 wiring:

- binds `MediaStorage` to `S3MediaStorage`;
- registers `ReportStatusObserver`;
- registers `NotifyConcernedUsers` for `ReportStatusChanged`;
- registers `InvalidateReportDashboardCache` for `ReportStatusChanged`.

Keeping these registrations in one provider avoids scattering E7-specific changes across the application's existing providers.

## Media

The application layer should validate report images with `ReportMediaRule`.

`StoreReportAttachment` deliberately performs storage before metadata persistence. If the database transaction fails, the uploaded object is deleted immediately, preventing an orphan in MinIO/S3.

Expected `ReportAttachment` metadata:

- `report_id`
- `path`
- `mime_type`
- `size`
- `original_name`

Adapt the metadata names to the team's existing model if they differ.

## Notifications

Each status transition gets a deterministic event key:

`report-status:{report-id}:{from-status}:{to-status}`

The notifications table must enforce uniqueness on `(user_id, event_key)`. This makes retries safe: the same recipient can receive the same transition notification only once.

The event implements `ShouldDispatchAfterCommit`, so notification and cache invalidation listeners run only after the surrounding database transaction commits.

## Redis

`ReportDashboardCache` is the single query/cache boundary. Any mutation that changes dashboard indicators must invalidate this cache. Status transitions are covered through `ReportStatusChanged`.

## Temporary URLs

Use `ReportMediaService::temporaryUrl()` only when the authenticated caller has already passed the appropriate report/attachment authorization policy.

## E7 acceptance targets

- Scenario 19: media is stored in MinIO/S3 and is not orphaned when metadata persistence fails.
- Scenario 21: status changes notify concerned users only after commit and remain idempotent under retries.
- Scenario 22: dashboard indicators are cached with TTL and invalidated immediately after a relevant transition.

## Final integration gate

Before declaring E7 complete, the team application must:

1. register `E7ServiceProvider`;
2. align `ReportAttachment` metadata with the real schema;
3. configure the S3-compatible disk for MinIO;
4. run migrations and application tests;
5. execute acceptance scenarios 19, 21 and 22;
6. verify temporary URL authorization and Redis invalidation.

No team GitLab code is modified by this workspace.
