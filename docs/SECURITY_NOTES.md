# Security Notes (My Account Menu Restriction)

This document summarizes the security‑related logic recently added around the member My Account page.

## Overview
- Goal: On a single device, if more than one different member account logs in, hide the My Account sidebar menu as a light deterrent.
- Scope: Frontend‑only, uses `localStorage`. It does not invalidate API tokens or block backend access.

## Behavior
- When a member logs in or their profile is fetched, the current member ID is recorded as having used the current device.
- If the device has usage records for 2 or more different member IDs within the last 30 days, a device "block" flag is set.
- While the flag is set, the My Account page renders an empty menu area (no text shown).

## Implementation
- Device/account usage tracking
  - File: `src/composables/useMemberAuth.js`
  - Added helpers:
    - `getOrCreateDeviceId()` – persists a random device ID in `localStorage` key `device_id_v1`.
    - `recordDeviceAccountUsage(memberId)` – updates per‑device usage log `localStorage` key `devacc:<device_id>` with a 30‑day TTL. If unique member IDs ≥ 2, sets `devacc_block:<device_id>` to `"1"`.
    - `isDeviceMultiAccountBlocked()` – returns whether the device block flag is set.
  - Integrated call:
    - Inside `store.setMember(...)` the current member ID is recorded via `recordDeviceAccountUsage(...)`.

- Menu hiding
  - File: `src/views/MyAccountPage.vue`
  - Import: `isDeviceMultiAccountBlocked`, `recordDeviceAccountUsage` from `useMemberAuth`.
  - Computed: `isDeviceBlocked` uses `isDeviceMultiAccountBlocked()`.
  - Template: The `<nav class="sidebar-nav">` renders the menu links only when `!isDeviceBlocked`.
  - On initial profile load, calls `recordDeviceAccountUsage(memberInfo.id)` defensively.

## Keys used in localStorage
- `device_id_v1`: Persistent random device identifier.
- `devacc:<device_id>`: JSON array of `{ id: <memberId>, ts: <millis> }` records, TTL 30 days.
- `devacc_block:<device_id>`: `"1"` when ≥ 2 unique member IDs are detected in the last 30 days.

## Reset / Unblock (manual)
- Clear the block flag for current device in browser devtools console:
  - Get the device ID: `localStorage.getItem('device_id_v1')`
  - Remove: `localStorage.removeItem('devacc_block:' + deviceId)`
  - Optionally clear history: `localStorage.removeItem('devacc:' + deviceId)`

## Limitations
- Frontend‑only; users can bypass by clearing storage, using private window, or different browsers.
- Hides menu UI only; does not disable backend endpoints or tokens.

## Recommended Next Steps (server‑side hardening)
- Sanctum token policy:
  - Limit active tokens per member (e.g., max 3). On login, if over limit, revoke oldest tokens.
  - Optionally encode device info into token name/metadata to track devices.
- Expose an endpoint returning active session/device count to allow FE to show accurate notices.
- Admin tools to list/revoke a member’s active tokens.

## Files Touched
- `src/composables/useMemberAuth.js`
- `src/views/MyAccountPage.vue`

