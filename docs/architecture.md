# E7 — Architecture

## Flow

```
State mutation
    │
    ▼
ReportStatusChanged
    │
    │ ShouldDispatchAfterCommit
    ▼
NotifyConcernedUsers
    │
    ├── recipient resolution
    └── Notification::firstOrCreate()
```

Media follows a separate infrastructure boundary:

```
Controller / Action
      │
      ▼
ReportMediaService
      │
      ▼
MediaStorage contract
      │
      ▼
S3MediaStorage
      │
      ▼
MinIO / S3
```

## Principles

### Single Responsibility

- `ReportMediaService`: application-level media use cases.
- `MediaStorage`: storage capability.
- `S3MediaStorage`: S3/MinIO technical details.
- `ReportStatusChanged`: state-change fact.
- `NotifyConcernedUsers`: notification side effect.

### Dependency inversion

Business/application code depends on `MediaStorage`, not directly on MinIO.

### Post-commit guarantee

The event implements `ShouldDispatchAfterCommit`. Notification work therefore cannot run from an uncommitted transaction.

### Idempotency

Recipients are persisted with `firstOrCreate`, so repeated delivery of the same status event does not intentionally create duplicate notifications.

### Redis

Dashboard caching must remain behind a dedicated query/service boundary. Controllers should not contain scattered `Cache::remember()` calls.

## Integration note

This workspace intentionally does not modify the team's GitLab repository. The classes here are the E7 implementation candidate to review, test, and later port through the team's agreed GitLab workflow.
