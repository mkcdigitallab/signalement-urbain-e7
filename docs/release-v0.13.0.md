# E7 — v0.13.0 release checklist

## Implementation

- [x] MediaStorage contract
- [x] S3/MinIO adapter
- [x] temporary URLs
- [x] reusable image validation
- [x] attachment persistence with orphan cleanup
- [x] post-commit status event
- [x] notification idempotency
- [x] Redis dashboard cache
- [x] cache invalidation

## Integration

- [ ] register ReportStatusObserver in the real Laravel bootstrap/provider
- [ ] register E7 listeners
- [ ] align ReportAttachment columns with the real schema
- [ ] configure MinIO/S3 credentials
- [ ] configure Redis
- [ ] run the complete Laravel test suite
- [ ] execute scenarios 19, 21 and 22 against real infrastructure

## Git workflow

- [x] implementation kept in the personal GitHub workspace
- [x] team GitLab untouched
- [x] draft PR kept open until integration validation
- [ ] final review
- [ ] merge
- [ ] tag v0.13.0

## Release rule

Do not tag v0.13.0 until the integration checklist and acceptance scenarios are validated on the complete Laravel application.
