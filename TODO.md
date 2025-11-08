# TODO: Add Score and Status to Assignments

## Steps to Complete

- [x] Create a new migration to add `score` (nullable decimal) and `status` (enum: pending, submitted, overdue; default 'pending') to the assignments table.
- [x] Update the Assignment model: add 'score' and 'status' to fillable array; add casts for 'score' as decimal and 'status' as string.
- [x] Modify createAssignment in TeacherController: make 'score' optional in validation; set status to 'pending' if score is null.
- [x] Modify updateAssignment in TeacherController: if score is added (was null, now provided), set status to 'submitted'.
- [x] Modify getAssignments in TeacherController: before returning assignments, check each for overdue (due_date < now and status == 'pending'), update to 'overdue'.
- [x] Run the migration to apply database changes.
- [ ] Test the functionality: create assignment without score (status pending), update to add score (status submitted), check overdue logic.
