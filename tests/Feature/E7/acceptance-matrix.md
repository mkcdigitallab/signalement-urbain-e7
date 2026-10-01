# E7 — Acceptance test matrix

## Scenario 19 — Médias

1. Submit a valid JPEG/PNG/WebP report photo.
2. Verify the object is stored through the S3/MinIO abstraction.
3. Persist attachment metadata.
4. Force metadata persistence failure.
5. Verify the uploaded object is deleted.
6. Verify a temporary URL is generated only after authorization.

## Scenario 21 — Notifications

1. Start a database transaction.
2. Change report status.
3. Verify the event is not processed before commit.
4. Commit.
5. Verify concerned recipients receive one notification per transition.
6. Retry the listener.
7. Verify the database uniqueness on (user_id, event_key) prevents duplication.

## Scenario 22 — Dashboard cache

1. Request dashboard indicators twice.
2. Verify the second request uses the cache.
3. Change a report status.
4. Verify the dashboard cache is invalidated.
5. Request indicators again and verify fresh values.
6. Verify the configured TTL expires the cached value.

## Non-regression

- cancelled/rejected transitions must not bypass authorization;
- unrelated users must not receive report notifications;
- temporary URLs must never replace authorization;
- cache invalidation must not change report workflow rules.
