# Signalement Urbain — EPIC 7

E7 is developed in this repository as an isolated implementation workspace.

## Scope

- MinIO / S3 object storage for report media
- Secure temporary signed URLs
- Media validation and orphan cleanup
- Post-commit `ReportStatusChanged` event
- Idempotent `NotifyConcernedUsers` listener
- Redis dashboard indicators with TTL and invalidation

## Architecture principles

The implementation follows the same evolvable approach used for the reservation-salles project:

- thin entry points
- application services/actions
- domain events
- listeners for side effects
- infrastructure adapters isolated from business rules
- configuration through environment variables
- explicit contracts only where they provide a real extension point
- tests around business guarantees
- no business logic in Blade/JavaScript
- no coupling of domain rules to MinIO or Redis

## Repository boundary

This repository is the personal E7 workspace. The team's GitLab repository is not modified from here.

## Target

`v0.13.0` — `feat/13-media-events-cache`
