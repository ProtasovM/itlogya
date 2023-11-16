<?php

return new class extends Migration
{
    public function up(): void
    {
        $this->db->query(
            'CREATE TABLE teacher_course (`teacher_id` int not null, `course_id` int not null)'
        );
    }

    public function down(): void
    {
        $this->db->query(
            'DROP TABLE teacher_course'
        );
    }
};
