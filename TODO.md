# TODO: Restructure Grade Creation for Formatted Report Card

## Steps to Complete

- [x] Create new migration to alter grades table: drop first_test, second_test, ca, remark; add class_score (decimal), exam_score (decimal), total_score (decimal), grade_meaning (string), subj_pos_class (string), subj_pos_form (string), teacher_mod_p (string).
- [x] Create new migration to add fields to students table: position_in_class (string), next_term_reopens (date), interest (string), conduct (string), attitude (string), class_teacher_remark (text), academic_remark (text).
- [x] Update Grade model fillable array to include new fields: subject, class_score, exam_score, total_score, grade_meaning, subj_pos_class, subj_pos_form, teacher_mod_p, student_id, teacher_id.
- [x] Update Student model fillable array to include new fields: position_in_class, next_term_reopens, interest, conduct, attitude, class_teacher_remark, academic_remark.
- [x] Modify createGrade method in TeacherController: update validation and logic to accept student_id, subjects (array of objects), and per-student fields; calculate total_score; update Student; create Grade records; return formatted report string.
- [x] Run php artisan migrate to apply new migrations.
- [x] Test the updated createGrade endpoint with sample data to ensure it creates records and returns the formatted report.
