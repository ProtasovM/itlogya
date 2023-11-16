<?php

return new class extends Migration
{
    public function up(): void
    {
        $this->db->query(
            'CREATE TABLE lessons (`id` int not null auto_increment, `teacher_id` int not null, `course_id` int not null, `student_id` int not null, `started_at` int not null, primary key (id))'
        );
    }

    public function down(): void
    {
        $this->db->query(
            'DROP TABLE lessons'
        );
    }
};
