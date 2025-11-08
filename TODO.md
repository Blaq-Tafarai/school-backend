# TODO: Fix Event Creation and Retrieval Issues

## Tasks
- [x] Update getEvents() in AdminController to use pagination (e.g., Event::paginate(10)) to limit response size and prevent "Response body is too large" error.
- [x] Add try-catch block in createEvent() method to handle exceptions and return meaningful error messages for 500 Internal Server Error.
- [x] Add 'time' to casts in Event model for proper handling of time field.

## Followup Steps
- [ ] Test the create event endpoint to ensure no 500 errors occur.
- [ ] Test get events endpoint to confirm pagination works and response is manageable.
