# E7 — Integration contract

This repository is a personal implementation workspace. It does not modify the team GitLab project.

## Media

The application layer should validate report images with ReportMediaRule.

StoreReportAttachment deliberately performs storage before metadata persistence. If the database transaction fails, the uploaded object is deleted immediately, preventing an orphan in MinIO/S3.

Expected ReportAttachment metadata:

- report_id
- path
- mime_type
- size
- original_name

Adapt the metadata names to the team's existing model if they differ.

## Notifications

Each status transition gets a deterministic event key:

report-status:{report-id}:{from-status}:{to-status}

The notifications table must enforce uniqueness on (user_id, event_key). This makes retries safe: the same recipient can receive the same transition notification only once.

## Event registration

The application's existing provider/bootstrap should register ReportStatusObserver for Report and register both listeners for ReportStatusChanged:

- NotifyConcernedUsers
- InvalidateReportDashboardCache

This workspace does not invent a provider structure that may conflict with the team's Laravel version.

## Redis

ReportDashboardCache is the single query/cache boundary. Any mutation that changes dashboard indicators must invalidate this cache. Status transitions are covered through ReportStatusChanged.

## Temporary URLs

Use ReportMediaService::temporaryUrl() only when the authenticated caller has already passed the appropriate report/attachment authorization policy.

## E7 acceptance targets

- Scenario 19: media is stored in MinIO/S3 and is not orphaned when metadata persistence fails.
- Scenario 21: status changes notify concerned users only after commit and remain idempotent under retries.
- Scenario 22: dashboard indicators are cached with TTL and invalidated immediately after a relevant transition.
