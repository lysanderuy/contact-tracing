-- Migration: Remove unused visitor columns (middle_name, email)
-- Date: 2026-05-25
-- Reason: Fields not collected in registration form

USE contact_tracing;

ALTER TABLE visitors DROP COLUMN middle_name;
ALTER TABLE visitors DROP COLUMN email;
